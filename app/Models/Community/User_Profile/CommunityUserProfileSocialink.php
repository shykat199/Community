<?php

namespace App\Models\Community\User_Profile;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityUserProfileSocialink extends Model
{
    use HasFactory;
    protected $fillable=['user_id','name','link'];
    protected $table='community_user_profile_socialinks';
}
