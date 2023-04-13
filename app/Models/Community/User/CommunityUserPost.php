<?php

namespace App\Models\Community\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityUserPost extends Model
{
    use HasFactory;
    protected $fillable=['user_id','post_description'];
}
