<?php

namespace App\Models\Community\Group;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityUserGroupPostFile extends Model
{
    use HasFactory;
    protected $fillable=['group_post_id','group_post_caption','group_post_file'];
    protected $table='community_user_group_post_files';
}
