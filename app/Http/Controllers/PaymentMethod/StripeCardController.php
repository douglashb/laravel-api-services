<?php

namespace App\Http\Controllers\PaymentMethod;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentMethod\CardPostRequest;
use App\Http\Resources\Stripe\CreateCardResource;
use App\Http\Resources\Stripe\CreateProfileResource;
use App\Libraries\ApiErrorCode;
use App\Libraries\ResponseHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Exception\ApiErrorException;
use Stripe\StripeClient;

class StripeCardController extends Controller
{
    public function __construct()
    {
    }

    public function index(Request $request)
    {

    }

    /**
     * @param CardPostRequest $request
     * @return JsonResponse
     */
    public function create(CardPostRequest $request): JsonResponse
    {
        return ResponseHandler::success('Stripe profile', $request->user()->stripeProfile);

        if (is_null($request->user()->stripeProfile)) {
            $stripeProfile = $this->createCustomerProfile($request->user()->toArray());

            if (is_string($stripeProfile)) {
                return ResponseHandler::badRequest(ApiErrorCode::INVALID_DATA, $stripeProfile);
            }
        }

        try {
            $resultCardCreated = app(StripeClient::class)->paymentMethods->create(
                (new CreateCardResource($request->validated()))->jsonSerialize()
            );
        } catch (ApiErrorException $e) {
            Log::alert('Add Card Error : ' . $e->getError()->code . ' | ' . $e->getError()->message);

            return ResponseHandler::badRequest(ApiErrorCode::INVALID_DATA, $e->getError()->message);
        }

        try {
            app(StripeClient::class)->paymentMethods->attach(
                $resultCardCreated->id,
                ['customer' => $request->user()->stripeProfile->stripe_id]
            );
        } catch (ApiErrorException $e) {
            Log::alert('Card Attach Error : ' . $e->getError()->code . ' | ' . $e->getError()->message);

            return ResponseHandler::badRequest(ApiErrorCode::INVALID_DATA, $e->getError()->message);
        }

        return ResponseHandler::success(__('card.created'));
    }

    public function delete()
    {

    }

    /**
     * @param array $user
     * @return string|object
     */
    private function createCustomerProfile(array $user): object|string
    {
        try {
            return app(StripeClient::class)->customers->create(
                (new CreateProfileResource($user))->jsonSerialize()
            );
        } catch (ApiErrorException $e) {
            Log::alert('Create Profile Error : ' . $e->getError()->code . ' | ' . $e->getError()->message);

            return $e->getMessage();
        }
    }
}
