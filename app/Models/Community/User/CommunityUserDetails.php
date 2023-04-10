<?php

namespace App\Models\Community\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityUserDetails extends Model
{
    use HasFactory;

    protected $fillable=['user_id','dob','birthplace','phone','gender','relationship','blood','website','about_me'];
    protected $table='community_user_details';
}
