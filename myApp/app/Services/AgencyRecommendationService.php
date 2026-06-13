<?php

namespace App\Services;

use App\Models\Module3\Agency;

class AgencyRecommendationService
{
    /**
     * Keyword groups mapped to the most suitable agency category.
     */
    private const KEYWORD_RULES = [
        'PDRM' => [
            'keywords' => ['scam', 'fraud', 'phishing', 'hack', 'banking scam', 'money scam'],
            'agency_terms' => ['pdrm', 'police', 'polis', 'royal malaysia police', 'crime', 'enforcement'],
        ],
        'KKM' => [
            'keywords' => ['virus', 'disease', 'health', 'hospital', 'clinic', 'medical'],
            'agency_terms' => ['kkm', 'ministry of health', 'health', 'medical', 'hospital', 'clinic'],
        ],
        'JPJ' => [
            'keywords' => ['vehicle', 'road', 'traffic', 'license', 'driving', 'car'],
            'agency_terms' => ['jpj', 'road transport', 'transport', 'vehicle', 'traffic', 'driving'],
        ],
    ];

    /**
     * Recommend the most suitable agency for an inquiry.
     *
     * @param  iterable<int, Agency>  $agencies
     */
    public static function recommend(string $title, ?string $description, iterable $agencies): array
    {
        $content = self::normalizeText($title . ' ' . ($description ?? ''));
        $agencyList = collect($agencies)->values();

        $bestMatch = [
            'category' => null,
            'agency' => null,
            'matched_keywords' => [],
            'score' => 0,
        ];

        foreach (self::KEYWORD_RULES as $category => $rule) {
            $matchedKeywords = self::matchedKeywords($content, $rule['keywords']);

            if (empty($matchedKeywords)) {
                continue;
            }

            $matchedAgency = self::resolveAgency($agencyList, $rule['agency_terms']);
            $score = (count($matchedKeywords) * 100) + self::agencyAlignmentScore($matchedAgency, $rule['agency_terms']);

            if ($score > $bestMatch['score']) {
                $bestMatch = [
                    'category' => $category,
                    'agency' => $matchedAgency,
                    'matched_keywords' => $matchedKeywords,
                    'score' => $score,
                ];
            }
        }

        return [
            'category' => $bestMatch['category'],
            'agency' => $bestMatch['agency'],
            'agency_id' => $bestMatch['agency']?->AgencyID,
            'agency_name' => $bestMatch['agency']?->AgencyName,
            'matched_keywords' => $bestMatch['matched_keywords'],
            'reason' => $bestMatch['category']
                ? 'Matched keywords: ' . implode(', ', $bestMatch['matched_keywords'])
                : null,
        ];
    }

    /**
     * Normalize text for keyword matching.
     */
    private static function normalizeText(string $text): string
    {
        $text = mb_strtolower($text);

        return trim(preg_replace('/\s+/u', ' ', $text) ?? $text);
    }

    /**
     * Find the keywords that are present in the inquiry text.
     */
    private static function matchedKeywords(string $content, array $keywords): array
    {
        $matches = [];

        foreach ($keywords as $keyword) {
            if (self::containsKeyword($content, $keyword)) {
                $matches[] = $keyword;
            }
        }

        return array_values(array_unique($matches));
    }

    /**
     * Resolve the best matching agency for a keyword group.
     *
     * @param  iterable<int, Agency>  $agencies
     */
    private static function resolveAgency(iterable $agencies, array $agencyTerms): ?Agency
    {
        $bestAgency = null;
        $bestScore = 0;

        foreach ($agencies as $agency) {
            $score = self::agencyAlignmentScore($agency, $agencyTerms);

            if ($score > $bestScore) {
                $bestScore = $score;
                $bestAgency = $agency;
            }
        }

        if ($bestAgency instanceof Agency) {
            return $bestAgency;
        }

        return collect($agencies)->first();
    }

    /**
     * Score how closely an agency matches a keyword group.
     */
    private static function agencyAlignmentScore(?Agency $agency, array $agencyTerms): int
    {
        if (!$agency) {
            return 0;
        }

        $haystack = self::normalizeText(implode(' ', array_filter([
            $agency->AgencyName ?? null,
            $agency->AgencyType ?? null,
            $agency->AgencyDescription ?? null,
        ])));

        $score = 0;

        foreach ($agencyTerms as $term) {
            if (self::containsKeyword($haystack, $term)) {
                $score += 10;
            }
        }

        return $score;
    }

    /**
     * Check if the text contains a keyword or keyword phrase.
     */
    private static function containsKeyword(string $content, string $keyword): bool
    {
        $keyword = self::normalizeText($keyword);

        if ($keyword === '') {
            return false;
        }

        if (str_contains($keyword, ' ')) {
            return str_contains($content, $keyword);
        }

        return preg_match('/\b' . preg_quote($keyword, '/') . '\b/u', $content) === 1;
    }
}