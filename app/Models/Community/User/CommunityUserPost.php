<?php

namespace App\Models\Community\User;

use App\Models\Community\User_Post\CommunityUserPostReaction;
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
}
