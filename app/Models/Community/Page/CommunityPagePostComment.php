<?php

namespace App\Models\Community\Page;

use App\Models\Community\Group\CommunityUserGroupPost;
use App\Models\Community\Group\CommunityUserGroupPostComment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityPagePostComment extends Model
{
    use HasFactory;
    protected $fillable=['user_id','page_post_comment_id','page_post_id','comment_text','comment_image'];
    protected $table='community_page_post_comments';

    public function userPosts(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(CommunityPagePost::class,'page_post_id');
    }

    public function replies(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CommunityPagePostComment::class,'page_post_comment_id','id');
    }

    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function commentsReaction(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CommunityPagePostCommentReaction::class,'page_post_comment_id')->where('user_id','=',\Auth::id());
    }

}
