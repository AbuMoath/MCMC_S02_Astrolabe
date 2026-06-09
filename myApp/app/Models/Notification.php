<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_type',
        'inquiry_id',
        'type',
        'title',
        'message',
        'additional_data',
        'is_read',
    ];

    protected $casts = [
        'additional_data' => 'array',
        'is_read' => 'boolean',
    ];

    public function inquiry()
    {
        return $this->belongsTo(\App\Models\Module3\Inquiry::class, 'inquiry_id', 'InquiryID');
    }
}
