<?php

namespace App\Models\Community\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityUserFollowing extends Model
{
    use HasFactory;
    protected $fillable=['user_id','user_following_id'];
}
