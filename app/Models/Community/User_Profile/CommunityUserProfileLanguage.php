<?php

namespace App\Models\Community\User_Profile;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityUserProfileLanguage extends Model
{
    use HasFactory;
    protected $fillable=['user_id','language_name'];

    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class,'users_id');
    }
}
