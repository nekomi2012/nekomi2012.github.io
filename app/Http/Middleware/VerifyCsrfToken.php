<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'api/*',
        '*',
        '/api/generateGame',
        '/api/checkGame',
        '/api/takebet',
        '/api/getBalance',
        '/api/stats',
        '/api/getHistory',
        '/api/getHistoryUser',
        '/api/getTopUser',
        '/api/getTopUserWeg',
        '/api/getBig',
        'api/generateGame',
        'api/checkGame',
        'api/takebet',
        'api/getBalance',
        'api/stats',
        'api/getHistory',
        'api/getHistoryUser',
        'api/getTopUser',
        'api/getTopUserWeg',
        'api/getBig'
    ];
}
