<?php

namespace App\Http\Middleware\Remittance;

use App\Libraries\ApiErrorCode;
use App\Libraries\ResponseHandler;
use App\Models\Remittance\ProfileRemit;
use Closure;
use Illuminate\Http\Request;

class VerifyRemitStatus
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function handle(Request $request, Closure $next)
    {
        if (! session()->has('remit_user_token') && ProfileRemit::byUser($request->user()->id)->first() === null) {
            return ResponseHandler::unauthorized(ApiErrorCode::REMIT_NEED_REGISTER, __('remittance.user_not_registered'));
        }

        return $next($request);
    }
}
