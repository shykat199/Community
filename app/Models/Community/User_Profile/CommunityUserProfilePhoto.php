<?php

namespace App\Models\Community\User_Profile;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityUserProfilePhoto extends Model
{
    use HasFactory;
    protected $fillable=['user_id','user_profile'];
    protected $table='community_user_profile_photos';
}
