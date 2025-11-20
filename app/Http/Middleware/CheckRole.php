<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{

	public function handle(Request $request, Closure $next, ...$roles): Response
	{
		if (!$request->user()) {
			return redirect()->route('login');
		}

		if (array_any($roles , fn($role) => $request->user()->hasRole($role))) {
			return $next($request);
		}

		abort(403, 'Доступ запрещен');
	}
}
