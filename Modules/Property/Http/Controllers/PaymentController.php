<?php

namespace Modules\Property\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Modules\Property\Http\Requests\PaymentRequest;
use Modules\Property\Models\Property;
use Modules\Property\Repositories\Interfaces\PropertyRepositoryInterface;
use Modules\Shared\Actions\HandleFormSubmission;

class PaymentController extends Controller
{
    protected $propertyRepository;

    public function __construct(PropertyRepositoryInterface $propertyRepository)
    {
        $this->propertyRepository = $propertyRepository;
    }

    public function initiatePayment(PaymentRequest $request, HandleFormSubmission $handler, Property $property)
    {
        try {
            $response = $this->propertyRepository->initiatePayment($request, $handler, $property);

            return $response;
        } catch (\Exception $e) {
            Log::error('Payment Initiation Failed', [
                'error' => $e->getMessage(),
                'property_id' => $property->id,
            ]);

            return back()->with('error', 'Failed to initiate payment: '.$e->getMessage());
        }
    }

    // Handles PhonePe callback response
    public function paymentCallback()
    {
        // Log the entire callback request for debugging
        Log::info('PhonePe Callback Received', [
            'headers' => request()->headers->all(),
            'body' => request()->all(),
        ]);

        // Verify X-VERIFY header
        $xVerify = request()->header('X-VERIFY');
        $responseData = request()->input('response');

        if (! $xVerify || ! $responseData) {
            Log::error('Invalid PhonePe Callback: Missing X-VERIFY or response');

            return response()->json(['status' => 'error', 'message' => 'Invalid callback'], 400);
        }

        try {
            // Decode the base64 response
            $decodedResponse = json_decode(base64_decode($responseData), true);

            // Fetch Salt Key and Salt Index
            $saltKey = env('PHONEPE_SALT_KEY');
            $saltIndex = env('PHONEPE_SALT_INDEX');

            // Generate expected X-VERIFY
            $hashInput = $responseData.'/pg/v1/status'.$saltKey;
            $expectedXVerify = hash('sha256', $hashInput).'###'.$saltIndex;

            // Log verification details
            Log::info('PhonePe Callback Verification', [
                'received_x_verify' => $xVerify,
                'expected_x_verify' => $expectedXVerify,
                'decoded_response' => $decodedResponse,
            ]);

            // Verify the signature
            if ($xVerify !== $expectedXVerify) {
                Log::error('PhonePe Callback Verification Failed: Invalid X-VERIFY');

                return response()->json(['status' => 'error', 'message' => 'Invalid signature'], 400);
            }

            // Process the payment response
            if ($decodedResponse['success'] && $decodedResponse['code'] === 'PAYMENT_SUCCESS') {
                // Update payment status in database (example)
                // Payment::where('merchant_transaction_id', $decodedResponse['data']['merchantTransactionId'])->update(['status' => 'success']);
                Log::info('PhonePe Payment Successful', [
                    'transaction_id' => $decodedResponse['data']['merchantTransactionId'],
                    'amount' => $decodedResponse['data']['amount'] / 100,
                ]);

                return view('success', ['response' => $decodedResponse]);
            } else {
                Log::error('PhonePe Payment Failed', [
                    'response' => $decodedResponse,
                ]);

                return view('failed', ['error' => $decodedResponse['message'] ?? 'Unknown error']);
            }
        } catch (\Exception $e) {
            Log::error('PhonePe Callback Exception', [
                'error' => $e->getMessage(),
            ]);

            return response()->json(['status' => 'error', 'message' => 'Callback processing failed'], 500);
        }
    }
}
