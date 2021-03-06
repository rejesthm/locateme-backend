<?php

namespace App\API\v1\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\API\v1\Models\Groups;
use App\User;

class GroupMembers extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'group_id', 'user_id', 'user_position'
    ];


    public function group(){
        return $this->belongsTo(Groups::class, 'group_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

}
