<?php

namespace App\Models\Community\Page;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityPagePostReaction extends Model
{
    use HasFactory;
    protected $fillable=['page_post_id','user_id','reaction_type'];
    protected $table='community_page_post_reactions';
}
