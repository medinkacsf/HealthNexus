<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccesoIoT extends Model
{
    use HasFactory;

    protected $fillable = ['area', 'evento'];

    public $timestamps = false;
}