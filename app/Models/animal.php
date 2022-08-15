<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class animal extends Model
{
    use HasFactory;
    protected $table= 'animals';
    public $timestamps =false;
     public $fillable = ['nombre','foto','eliminado','id_tipo'];
}
