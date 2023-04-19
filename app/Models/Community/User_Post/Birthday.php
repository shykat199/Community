<?php

namespace App\Models\Community\User_Post;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Birthday extends Model
{
    use HasFactory;
    protected $fillable=['user_id','wished_user_id','message'];
    protected $table='community_user_friends_birthday';
}
