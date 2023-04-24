<?php

namespace App\Models\Community\User_Profile;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityUserProfileInterest extends Model
{
    use HasFactory;
    protected $fillable=['user_id','interest_name','interest_details'];
    protected $table='community_user_profile_interests';
}
