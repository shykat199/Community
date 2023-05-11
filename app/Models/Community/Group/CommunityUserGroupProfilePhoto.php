<?php

namespace App\Models\Community\Group;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityUserGroupProfilePhoto extends Model
{
    use HasFactory;
    protected $fillable=['group_id','group_profile_photo'];
    protected $table='community_user_group_profile_photos';
}
