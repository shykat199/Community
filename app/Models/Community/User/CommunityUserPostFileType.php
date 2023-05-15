<?php

namespace App\Models\Community\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityUserPostFileType extends Model
{
    use HasFactory;
    protected $fillable=['post_id','post_image_video','caption'];
}
