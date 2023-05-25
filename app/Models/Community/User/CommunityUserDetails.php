<?php

namespace App\Models\Community\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityUserDetails extends Model
{
    use HasFactory;

    protected $fillable=['user_id','dob','birthplace','phone','gender','relationship','blood','website','about_me','fname','lname','occupation','email','city','state','country'];
    protected $table='community_user_details';

    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
