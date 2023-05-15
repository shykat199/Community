<?php

namespace App\Models\Community\Page;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityPageCoverPhoto extends Model
{
    use HasFactory;
    protected $fillable=['page_id','page_cover_photo'];
    protected $table='community_page_cover_photos';
}
