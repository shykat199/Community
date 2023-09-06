<?php

namespace App\Models\Community\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityUserBan extends Model
{
    use HasFactory;
    protected $fillable=['user_id','user_ban'];
    protected $table='community_user_bans';
}
