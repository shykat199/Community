<?php

namespace App\Models\Community\User;

use App\Models\Community\User_Post\CommunityUserPostComment;
use App\Models\Community\User_Post\CommunityUserPostReaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityUserPost extends Model
{
    use HasFactory;
    protected $fillable=['user_id','post_description'];

    public function reactions()
    {
        return $this->hasMany(CommunityUserPostReaction::class, 'user_post_id');
    }

    public  function users(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function comments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CommunityUserPostComment::class,'user_post_id');
    }

    public function commentLimits(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CommunityUserPostComment::class,'user_post_id')->latest()->limit(2);
    }

}
