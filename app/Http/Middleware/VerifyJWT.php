<?php

namespace App\Http\Middleware;

use App\Libraries\ResponseHandler;
use App\Models\Profile\Session;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class VerifyJWT
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function handle(Request $request, Closure $next)
    {
        if (! JWTAuth::parser()->setRequest($request)->hasToken()) {
            return ResponseHandler::unauthorized(40, __('auth.token_not_found'));
        }

        try {
            $user = JWTAuth::parseToken()->authenticate();
            if (! $user) {
                return ResponseHandler::unauthorized(40, __('auth.token_not_found'));
            }
        } catch (TokenExpiredException $e) {
            return ResponseHandler::unauthorized(41, __('auth.token_expired'));
        } catch (TokenInvalidException $e) {
            return ResponseHandler::unauthorized(42, __('auth.token_invalid'));
        }

        $session = Session::firstWhere('profile_user_id', $user->id);
        $payload = auth()->payload();

        // If session is inactive
        if ($session->active === 0) {
            return ResponseHandler::unauthorized(42, __('auth.token_invalid'));
        }

        // If user have more than 15 minutes of inactivity
        if (now()->diffInMinutes(Carbon::parse($session->last_activity_at)) >= 15) {
            $session->active = 0;
            $session->save();

            return ResponseHandler::unauthorized(41, __('auth.token_expired_inactivity'));
        }

        // Compare iat in database and request
        if ((int) $session->iat !== $payload->get('iat')) {
            return ResponseHandler::unauthorized(42, __('auth.token_invalid'));
        }

        $payload = JWTAuth::parseToken()->getPayload();
        session()->put($payload['session']);

        $session->last_activity_at = now();
        $session->save();

        return $next($request);
    }
}
