<?php
//
//namespace App\Services;
//
//use App\Contracts\PaymentRepositoryContract;
//use App\Contracts\SubscriptionRepositoryContract;
//use App\Repositories\PaymentRepository;
//use App\Repositories\SubscriptionRepository;
//
//class PaymentService
//{
//    protected PaymentRepositoryContract $paymentRepositoryContract;
//    protected PaymentRepository $paymentRepository;
//
//    public function __construct(PaymentRepositoryContract $paymentRepositoryContract, PaymentRepository $paymentRepository)
//    {
//        $this->paymentRepositoryContract = $paymentRepositoryContract;
//        $this->paymentRepository = $paymentRepository;
//    }
//
//    public function charge(array $chargeData): Charge
//    {
//        return Charge::create([
//            "amount" => 100 * $chargeData->price,
//            "currency" => "USD",
//            "source" => $chargeData->stripeToken,
//            "description" => "This is payment for " . $chargeData->name,
//        ]);
//    }
//
//    /**
//     * @param $data
//     * @param $type
//     * @return array
//     */
//    public function createPayment($data , $type): array
//    {
//        try {
//            match ($type) {
//                Book::class => $this->paymentRepository->store($data['paymentData']),
//                Subscription::class => $this->subRepository->store($data['paymentData'])
//            };
//            Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
//            $charge = $this->charge($data['chargeData']);
//
//            return [
//                'success' => true,
//                'type' => 'success',
//                'charge' => $charge
//            ];
//        } catch (\Exception $exception) {
//
//            return [
//                'success' => false,
//                'type' => 'error',
//                'message' => $exception->getMessage()
//            ];
//        }
//    }
//
//
//}
