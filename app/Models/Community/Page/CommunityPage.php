<?php

namespace App\Models\Community\Page;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityPage extends Model
{
    use HasFactory;

    protected $fillable=['page_name','page_details','user_id'];
    protected $table='community_pages';

    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }



}
