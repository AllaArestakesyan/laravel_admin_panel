<?php
namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            return null;
        }

        throw new HttpResponseException(
            response()->json(['error' => 'Unauthorized User!'], JsonResponse::HTTP_UNAUTHORIZED)
        );

        // return $request->expectsJson() ? null : route('login');
    }

}