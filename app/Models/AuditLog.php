<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'ip_address', 'action', 'details', 'created_at'];
    
    // Por defecto Laravel usa 'updated_at', aquí lo desactivamos porque un log no se edita, solo se crea
    public $timestamps = false;
}
