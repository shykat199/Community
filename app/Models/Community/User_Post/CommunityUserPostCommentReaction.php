<?php

namespace App\Models\Community\User_Post;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityUserPostCommentReaction extends Model
{
    use HasFactory;
    protected $fillable=['user_id','post_comment_id','reaction_type'];
    protected $table='community_user_post_comment_reactions';

    public function postComment(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(CommunityUserPostComment::class,'post_comment_id');
    }
}
