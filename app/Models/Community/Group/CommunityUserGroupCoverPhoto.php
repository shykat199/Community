<?php

namespace App\Models\Community\Group;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityUserGroupCoverPhoto extends Model
{
    use HasFactory;
    protected $fillable=['group_id','cover_photo'];
    protected $table='community_user_group_cover_photos';
}
