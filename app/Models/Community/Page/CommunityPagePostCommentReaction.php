<?php

namespace App\Models\Community\Page;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityPagePostCommentReaction extends Model
{
    use HasFactory;

    protected $fillable=['page_post_comment_id','user_id','reaction_type'];
    protected $table='community_page_post_comment_reactions';

    public function pageComments(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(CommunityPagePostComment::class,'page_post_comment_id');
    }
}
