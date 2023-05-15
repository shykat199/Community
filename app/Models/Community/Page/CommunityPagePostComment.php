<?php

namespace App\Models\Community\Page;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityPagePostComment extends Model
{
    use HasFactory;
    protected $fillable=['user_id','page_post_comment_id','page_post_id','comment_text','comment_image'];
    protected $table='community_page_post_comments';
}
