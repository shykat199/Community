<?php

namespace App\Models\Community\Group;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityUserGroupPivot extends Model
{
    use HasFactory;
    protected $fillable=['group_id','user_id','group_user_role','user_status'];
    protected $table='community_user_group_pivots';
}
