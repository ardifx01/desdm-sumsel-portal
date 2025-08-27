<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string|null $ip_address
 * @property string|null $user_agent
 * @property string $url_visited
 * @property string $visited_at
 * @method static \Illuminate\Database\Eloquent\Builder|VisitorLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VisitorLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VisitorLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|VisitorLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VisitorLog whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VisitorLog whereUrlVisited($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VisitorLog whereUserAgent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VisitorLog whereVisitedAt($value)
 * @mixin \Eloquent
 */
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