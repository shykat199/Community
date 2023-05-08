<?php

namespace App\Models\Community\User_Post;

use App\Models\Community\User\CommunityUserPost;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityUserPostComment extends Model
{
    use HasFactory;
    protected $fillable=['user_id','user_post_id','user_post_comment_id','comment_text','comment_image'];
    protected $table='community_user_post_comments';

    public function userPosts(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(CommunityUserPost::class,'user_post_id');
    }
}
