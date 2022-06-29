<?php

namespace App\Services;

use App\Models\Book;
use App\Models\Plan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Stripe;

class PaymentService
{

    /**
     * @param $cardData
     * @param $planId
     * @return array[]
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function subscriptionPayment($cardData, $planId): array
    {

        $plan = Plan::find($planId);
        $stripe = new \Stripe\StripeClient(
            'sk_test_51L8jHaAcc1mBcc9SQyBW6iMyKmSV8mX0u0NcHWrROifm4Smvv4kJV3JIgwBNvVhIwnSnyN8oktEJrnGvpQ8HlqFd00MVj0wXbs'
        );

        $token = $stripe->tokens->retrieve($cardData['stripeToken']);

        $price = $stripe->prices->retrieve($plan->plan_id);

        $customer = $stripe->customers->create(
            [
                'email' => Auth::user()->email,
                'source' => $token->id,
            ]
        );

        $subscription = $stripe->subscriptions->create([
            'customer' => $customer->id,
            'payment_settings' => [
                'payment_method_types' => ['card'],
            ],
            'items' => [
                ['price' => $price->id],
            ],
        ]);

        $date = Carbon::parse($subscription->current_period_end);

        $subData = [
            'user_id' => Auth::id(),
            'stripe_plan' => $plan->id,
            'period_end' => $date,
            'status' => $subscription->status,
            'sub_id' => $subscription->id,

        ];

        return ['subData' => $subData];

    }

    /**
     * @param $paymentData
     * @param $bookId
     * @return array[]
     * @throws Stripe\Exception\ApiErrorException
     */
    public function payment($paymentData, $bookId): array
    {
        $book = Book::find($bookId);
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $charge = Stripe\Charge::create([
            "amount" => 100 * $book->price,
            "currency" => "USD",
            "source" => $paymentData['stripeToken'],
            "description" => "This is payment for " . $book->name,
        ]);

        $data = [
            'user_id' => Auth::id(),
            'book_id' => $book->id,
            'amount' => $book->price,
            'payable_type' => Book::class,
            'payable_status' => $charge->status,
            'payable_id' => $charge->id,
        ];

        return ['data' => $data];
    }

}
