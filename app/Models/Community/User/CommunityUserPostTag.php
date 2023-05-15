<?php

namespace App\Models\Community\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityUserPostTag extends Model
{
    use HasFactory;
    protected $fillable=['user_id','tag_user_id','user_post_id','created_at','updated_at'];
}
