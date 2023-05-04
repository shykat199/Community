<?php

namespace App\Models\Community\User_Post;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityUserPostComment extends Model
{
    use HasFactory;
    protected $fillable=['user_id','user_post_id','user_post_comment_id','comment_text','comment_image'];
    protected $table='community_user_post_comments';
}
