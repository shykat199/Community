<?php

namespace App\Models\Community\Page;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityPagePostFileType extends Model
{
    use HasFactory;
    protected $fillable=['post_id','post_image_video','caption'];
    protected $table='community_page_post_file_types';
}
