<?php

namespace App\Models\Community\Group;

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
}
