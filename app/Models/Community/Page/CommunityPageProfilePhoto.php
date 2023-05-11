<?php

namespace App\Models\Community\Page;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityPageProfilePhoto extends Model
{
    use HasFactory;
    protected $fillable=['page_id','page_profile_photo'];
    protected $table='community_page_profile_photos';
}
