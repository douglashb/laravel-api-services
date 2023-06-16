<?php

namespace App\Http\Middleware;

use App\Libraries\ApiErrorCode;
use App\Libraries\ResponseHandler;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;

class VerifyHeaders
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
//        $validator = Validator::make([
//            'x-remote-address' => $request->header('x-remote-address'),
//            'x-remote-platform' => $request->header('x-remote-platform'),
//        ], [
//            'x-remote-address' => 'required|ip',
//            'x-remote-platform' => 'required|string|in:android,ios,web',
//        ]);
//
//        if ($validator->fails()) {
//            return ResponseHandler::badRequest(ApiErrorCode::INVALID_DATA, $validator->errors()->first());
//        }
//
//        session()->put([
//            'user_remote_address' => $request->header('x-remote-address'),
//            'user_remote_platform' => $request->header('x-remote-platform'),
//        ]);

        if ($request->headers->has('Accept-Language') && $request->header('Accept-Language') !== '') {
            $locale = explode('-', $request->header('Accept-Language'));

            App::setLocale($locale[0]);
        } else {
            App::setLocale('en');
        }

        return $next($request);
    }
}
