<?php
// app/Http/Middlewares/AuthorOnly.php
namespace App\Http\Middleware;
use Illuminate\Http\Request;
use Closure;

class AuthCheck
{
    public function handle(Request $request, Closure $next, $param)
    {
        if (!$request->user()) {
            flash()->error("Please login");

            return redirect(route('sessions.create'));
        }
        return $next($request);
    }
}
