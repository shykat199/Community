<?php

namespace App\Models\Community\User_Profile;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityUserProfileEducation extends Model
{
    use HasFactory;
    protected $fillable=['user_id','degree_name','institute','description','starting_date','ending_date','is_present','type','designation'];
    protected $table='community_user_profile_education';
}
