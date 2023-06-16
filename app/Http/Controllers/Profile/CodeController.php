<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Interfaces\Profile\CodeRepository;
use App\Libraries\MaskData;
use App\Libraries\ResponseHandler;
use App\Notifications\AccountCreatedMail;
use App\Notifications\ActivationCodeMail;
use App\Notifications\ActivationCodeSms;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CodeController extends Controller
{
    public function __construct(
        private CodeRepository $codeRepository
    ){}


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function resendActivationCode(Request $request): JsonResponse
    {
        $activationCode = $this->codeRepository->getLastActivationCode($request->user()->id);

        if (session('merchant_notify_mode') === 'email') {
            $sendBy = MaskData::email($request->user()->email);
            $request->user()->notify(new ActivationCodeMail($activationCode->code));
        } else {
            $sendBy = MaskData::phone($request->user()->phone);
            $request->user()->notify(new ActivationCodeSms($activationCode->code));
        }

        return ResponseHandler::success(__('user.account_need_activation', ['send_by' => $sendBy]));
    }
}
