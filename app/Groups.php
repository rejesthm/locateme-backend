<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Groups extends Model
{

    protected $fillable = [
        'id',
        'group_name',
        'group_destination',
        'destination_lat',
        'destination_long',
        'group_status',
        'date',
        'creator_id'
    ];

    protected $casts = [
        'date' => 'datetime:d/m/Y',
    ];
}
