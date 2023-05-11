<?php

namespace App\Models\Community\Group;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityUserGroupPost extends Model
{
    use HasFactory;
    protected $fillable=['group_id','user_id','post_description'];
    protected $table='community_user_group_posts';

    public function groupPosts(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(CommunityUserGroup::class);
    }

    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function comments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CommunityUserGroupPostComment::class,'group_post_id');
    }

}
