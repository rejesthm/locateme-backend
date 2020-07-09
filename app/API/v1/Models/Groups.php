<?php

namespace App\API\v1\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\API\v1\Models\GroupMembers;

class Groups extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'id', 'group_name', 'group_destination', 'destination_lat', 'destination_long', 'group_image_url' ,'group_status', 'date', 'creator_id'
    ];

    protected $casts = [
        'date' => 'datetime:d/m/Y',
    ];

    protected $attributes = [
        'group_status' => 1,
    ];


    public function groupmembers(){
        return $this->hasMany(GroupMembers::class, 'group_id', 'id')->orderByDesc("id");
    }
}
