<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitorDaily extends Model
{
    protected $fillable = [
        'ip_address',
        'visit_date',
        'country',
        'region',
        'city',
        'latitude',
        'longitude',
        'visited_routes',
    ];

    protected function casts(): array
    {
        return [
            'visit_date' => 'date',
            'visited_routes' => 'array',
        ];
    }
}
