<?php

namespace App\Models\Community\Group;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityUserGroupPostReaction extends Model
{
    use HasFactory;
    protected $fillable=['user_id','group_post_id','reaction_type'];
    protected $table='community_user_group_post_reactions';
}
