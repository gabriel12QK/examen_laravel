<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tipoanimal extends Model
{
    use HasFactory;
    protected $table= 'tipoanimals';
    public $timestamps =false;
     public $fillable = ['tipo','eliminado'];
}
