<?php
/**
 * Created by IntelliJ IDEA.
 * User: linhdo
 * Date: 1/10/18
 * Time: 10:20 AM
 */

namespace App\Http\Middleware;

use Closure;

class RequestLogger
{
    public function handle( $request, Closure $next )
    {
        \Log::debug( 'LOGGING REQUEST', [ $request ] );

        $response = $next( $request );

        \Log::debug( 'LOGGING RESPONSE', [ $response ] );

        return $response;
    }
}
