<?php

namespace App\Models\Community\Group;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityUserGroupPostCommentReaction extends Model
{
    use HasFactory;

    protected $fillable=['user_id','group_post_comment_id','reaction_type'];
    protected $table='community_user_group_post_comment_reactions';

    public function postComments(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(CommunityUserGroupPostComment::class,'group_post_comment_id');
    }
}
