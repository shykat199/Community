<?php

namespace App\Models\Community\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityUserFriendRequest extends Model
{
    use HasFactory;
    protected $fillable=['sender_user_id','receiver_user_id','status'];
    protected $table='community_user_friend_requests';
}
