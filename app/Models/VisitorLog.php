<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitorLog extends Model
{
    use HasFactory;

    protected $table = 'visitor_logs';

    public $timestamps = false; // Kita tidak menggunakan created_at/updated_at

    protected $fillable = [
        'ip_address',
        'user_agent',
        'url_visited',
        'visited_at',
    ];
}