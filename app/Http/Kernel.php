<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $middlewareAliases = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'admin.role' => \App\Http\Middleware\AdminRoleMiddleware::class,
        'superadmin.role' => \App\Http\Middleware\SuperAdminRole::class,
        'audit.log' => \App\Http\Middleware\AuditLogMiddleware::class,
    ];
}
