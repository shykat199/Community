<?php

namespace App\Models\Community\Page;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersPage extends Model
{
    use HasFactory;

    protected $fillable=['page_id','user_id','role'];
    protected $table='users_pages';
}
