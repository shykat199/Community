<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\Constraint\Count;

class State extends Model
{
    use HasFactory;
    protected $fillable=['name','c_id'];
    protected $table='states';
    public function countries(){
        return $this->belongsTo(Country::class,'c_id');
    }

    public function cities(){
        return $this->hasMany(City::class,'state_id');
    }
}
