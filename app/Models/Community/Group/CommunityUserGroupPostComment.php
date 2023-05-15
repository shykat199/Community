<?php

namespace App\Models\Community\Group;

use App\Models\Community\User\CommunityUserPost;
use App\Models\Community\User_Post\CommunityUserPostComment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityUserGroupPostComment extends Model
{
    use HasFactory;
    protected $fillable=['user_id','group_post_id','group_post_comment_id','comment_text'];
    protected $table='community_user_group_post_comments';

    public function userPosts(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(CommunityUserGroupPost::class,'group_post_id');
    }

    public function replies(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CommunityUserGroupPostComment::class,'group_post_comment_id','id');
    }

    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }

}
