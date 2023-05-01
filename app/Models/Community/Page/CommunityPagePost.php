<?php

namespace App\Models\Community\Page;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityPagePost extends Model
{
    use HasFactory;
    protected $fillable=['page_id','user_id','post_description'];
    protected $table='community_page_posts';

    public  function users(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
