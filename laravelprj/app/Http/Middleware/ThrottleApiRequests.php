<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Dingo\Api\Routing\Helpers;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;
class ThrottleApiRequests extends ThrottleRequests
{
    use Helpers;
    public function handle($request, Closure $next, $maxAttempts = 60, $decayMinutes = 1)
    {
        $key = $this->resolveRequestSignature($request);
        if ($this->limiter->tooManyAttempts($key, $maxAttempts, $decayMinutes)) {
            throw new TooManyRequestsHttpException('',"Too Many request Attempt, X-RateLimit-Limit : ".$maxAttempts);
/*            return $this->response->array([
                'request' => $request,
                'next' => $next,
                'decaySecondes' => $decayMinutes,
                'Retry-After' => $this->limiter->availableIn($key),
                'X-RateLimit-Limit' => $maxAttempts,
                'X-RateLimit-Remaining' => 0,
            ]);*/
        }
        $this->limiter->hit($key, $decayMinutes);

        $response = $next($request);

        $response->headers->add([
            'X-RateLimit-Limit' => $maxAttempts,
            'X-RateLimit-Remaining' => $maxAttempts - $this->limiter->attempts($key) + 1,
        ]);
        return $response;
    }
}
