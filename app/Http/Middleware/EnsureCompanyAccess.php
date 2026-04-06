<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureCompanyAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        abort_unless(
            $user
            && ! $user->isSystemAdmin()
            && $user->company
            && $user->company->is_active,
            403
        );

        return $next($request);
    }
}
