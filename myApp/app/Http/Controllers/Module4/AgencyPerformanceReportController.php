<?php

namespace App\Http\Controllers\Module4;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Module1\Agency as Module1Agency;
use App\Models\Inquiry;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class AgencyPerformanceReportController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Show the agency performance reports dashboard
     */
    public function index()
    {
        // Get all agencies for filtering
        $agencies = Module1Agency::select('AgencyID', 'AgencyName')
                                ->orderBy('AgencyName')
                                ->get();

        // Get inquiry categories for filtering
        $categories = Inquiry::select('InquirySource')
                            ->distinct()
                            ->whereNotNull('InquirySource')
                            ->orderBy('InquirySource')
                            ->pluck('InquirySource');

        return view('Module4.admin.agency-performance-reports', compact('agencies', 'categories'));
    }

    /**
     * Generate agency performance report based on filters
     */
    public function generateReport(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'agency_id' => 'nullable|exists:agencies,AgencyID',
            'inquiry_category' => 'nullable|string',
        ]);

        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->subMonths(3);
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now();
        $agencyId = $request->agency_id;
        $inquiryCategory = $request->inquiry_category;

        // Build the base query
        $agencyQuery = Module1Agency::select('agencies.*');
        
        if ($agencyId) {
            $agencyQuery->where('AgencyID', $agencyId);
        }

        $agencies = $agencyQuery->get();

        $reportData = [];

        foreach ($agencies as $agency) {
            // Base inquiry query for this agency
            $inquiryQuery = Inquiry::where('AgencyID', $agency->AgencyID)
                                  ->whereBetween('assignment_date', [$startDate, $endDate]);

            if ($inquiryCategory) {
                $inquiryQuery->where('InquirySource', $inquiryCategory);
            }

            // Get total assigned inquiries
            $totalAssigned = (clone $inquiryQuery)->count();

            // Get resolved inquiries
            $resolvedInquiries = (clone $inquiryQuery)
                               ->whereIn('InquiryStatus', ['Verified as True', 'Identified as Fake'])
                               ->get();

            $totalResolved = $resolvedInquiries->count();

            // Calculate average resolution time
            $avgResolutionTime = 0;
            if ($totalResolved > 0) {
                $totalDays = 0;
                foreach ($resolvedInquiries as $inquiry) {
                    if ($inquiry->assignment_date && $inquiry->updated_at) {
                        $assignmentDate = Carbon::parse($inquiry->assignment_date);
                        $resolutionDate = Carbon::parse($inquiry->updated_at);
                        $totalDays += $assignmentDate->diffInDays($resolutionDate);
                    }
                }
                $avgResolutionTime = $totalResolved > 0 ? round($totalDays / $totalResolved, 1) : 0;
            }

            // Get pending inquiries
            $pendingInquiries = (clone $inquiryQuery)
                              ->whereIn('InquiryStatus', ['Pending', 'Under Investigation'])
                              ->count();

            // Get overdue inquiries (pending for more than 30 days)
            $overdueInquiries = (clone $inquiryQuery)
                              ->whereIn('InquiryStatus', ['Pending', 'Under Investigation'])
                              ->where('assignment_date', '<', Carbon::now()->subDays(30))
                              ->count();

            // Calculate performance metrics
            $resolutionRate = $totalAssigned > 0 ? round(($totalResolved / $totalAssigned) * 100, 1) : 0;

            $reportData[] = [
                'agency' => $agency,
                'total_assigned' => $totalAssigned,
                'total_resolved' => $totalResolved,
                'pending_inquiries' => $pendingInquiries,
                'overdue_inquiries' => $overdueInquiries,
                'avg_resolution_time' => $avgResolutionTime,
                'resolution_rate' => $resolutionRate,
            ];
        }

        // Get summary statistics
        $summary = [
            'total_agencies' => count($reportData),
            'total_assigned_all' => array_sum(array_column($reportData, 'total_assigned')),
            'total_resolved_all' => array_sum(array_column($reportData, 'total_resolved')),
            'total_pending_all' => array_sum(array_column($reportData, 'pending_inquiries')),
            'total_overdue_all' => array_sum(array_column($reportData, 'overdue_inquiries')),
            'avg_resolution_rate' => count($reportData) > 0 ? round(array_sum(array_column($reportData, 'resolution_rate')) / count($reportData), 1) : 0,
        ];

        return response()->json([
            'success' => true,
            'data' => $reportData,
            'summary' => $summary,
            'filters' => [
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d'),
                'agency_id' => $agencyId,
                'inquiry_category' => $inquiryCategory,
            ]
        ]);
    }

    /**
     * Export report to PDF
     */
    public function exportToPDF(Request $request)
    {
        // Get the same data as the generate report
        $reportResponse = $this->generateReport($request);
        $reportData = $reportResponse->getData();

        $pdf = PDF::loadView('Module4.admin.agency-performance-pdf', [
            'data' => $reportData->data,
            'summary' => $reportData->summary,
            'filters' => $reportData->filters,
            'generated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        $filename = 'agency-performance-report-' . date('Y-m-d') . '.pdf';
        return $pdf->download($filename);
    }

    /**
     * Export report to Excel
     */
    public function exportToExcel(Request $request)
    {
        // Get the same data as the generate report
        $reportResponse = $this->generateReport($request);
        $reportData = $reportResponse->getData();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set headers
        $headers = [
            'A1' => 'Agency Name',
            'B1' => 'Total Assigned',
            'C1' => 'Total Resolved',
            'D1' => 'Pending Inquiries',
            'E1' => 'Overdue Inquiries',
            'F1' => 'Avg Resolution Time (Days)',
            'G1' => 'Resolution Rate (%)'
        ];

        foreach ($headers as $cell => $value) {
            $sheet->setCellValue($cell, $value);
            $sheet->getStyle($cell)->getFont()->setBold(true);
        }

        // Add data
        $row = 2;
        foreach ($reportData->data as $agency) {
            $sheet->setCellValue('A' . $row, $agency->agency->AgencyName);
            $sheet->setCellValue('B' . $row, $agency->total_assigned);
            $sheet->setCellValue('C' . $row, $agency->total_resolved);
            $sheet->setCellValue('D' . $row, $agency->pending_inquiries);
            $sheet->setCellValue('E' . $row, $agency->overdue_inquiries);
            $sheet->setCellValue('F' . $row, $agency->avg_resolution_time);
            $sheet->setCellValue('G' . $row, $agency->resolution_rate);
            $row++;
        }

        // Auto-size columns
        foreach (range('A', 'G') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'agency-performance-report-' . date('Y-m-d') . '.xlsx';
        
        $temp_file = tempnam(sys_get_temp_dir(), $filename);
        $writer->save($temp_file);

        return Response::download($temp_file, $filename)->deleteFileAfterSend(true);
    }

    /**
     * Get visual statistics for charts
     */
    public function getVisualStatistics(Request $request)
    {
        // Get the same data as the generate report
        $reportResponse = $this->generateReport($request);
        $reportData = $reportResponse->getData();

        $agencies = [];
        $resolutionRates = [];
        $assignedCounts = [];
        $resolvedCounts = [];
        $avgResolutionTimes = [];

        foreach ($reportData->data as $agency) {
            $agencies[] = $agency->agency->AgencyName;
            $resolutionRates[] = $agency->resolution_rate;
            $assignedCounts[] = $agency->total_assigned;
            $resolvedCounts[] = $agency->total_resolved;
            $avgResolutionTimes[] = $agency->avg_resolution_time;
        }

        return response()->json([
            'success' => true,
            'charts' => [
                'agencies' => $agencies,
                'resolution_rates' => $resolutionRates,
                'assigned_counts' => $assignedCounts,
                'resolved_counts' => $resolvedCounts,
                'avg_resolution_times' => $avgResolutionTimes,
                'summary' => $reportData->summary
            ]
        ]);
    }
}
