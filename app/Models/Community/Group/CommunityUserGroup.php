<?php

namespace App\Models\Community\Group;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityUserGroup extends Model
{
    use HasFactory;
    protected $fillable=['group_name','group_details'];
}
