<?php

namespace App\Http\Middleware\Remittance;

use App\Http\Controllers\Remittance\SecurityController;
use App\Models\Remittance\SessionRemit;
use Closure;
use Illuminate\Http\Request;

class VerifyRemitSession
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $lastToken = SessionRemit::updatedLessThan(15)->ByUser($request->user()->id)->first();

        if ($lastToken !== null) {
            session(['remit_user_token' => $lastToken->token]);
        } else {
            $result = app(SecurityController::class)->userLogin($request);

            if ($result->getData()->code !== 0) {
                return $result->getData()->data;
            }
        }

        return $next($request);
    }
}
