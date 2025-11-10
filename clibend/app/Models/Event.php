<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
protected $fillable = [
    'event_title',
    'event_description',
    'event_type',
    'expected_participants',
    'region',
    'location_detail',
    'latitude',
    'longitude',
    'tree_types',
    'event_date',
    'start_time',
    'duration',
    'registration_deadline',
    'event_image',
    'user_id',
];

    protected $casts = [
        'tree_types' => 'array',
    ];


    public function proposer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function participants()
    {
        return $this->belongsToMany(User::class, 'event_user')->withTimestamps();
    }
    
    
    
}
