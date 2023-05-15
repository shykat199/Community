<?php

namespace App\Models\Community\User_Post;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityUserPostReaction extends Model
{
    use HasFactory;

    protected $fillable=['user_id','user_post_id','reaction_type'];
    protected $table='community_user_post_reactions';
}
