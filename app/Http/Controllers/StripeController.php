<?php

namespace App\Http\Controllers;

use App\Contracts\BookRepositoryContract;
use App\Contracts\PaymentRepositoryContract;
use App\Contracts\PlanRepositoryContract;
use App\Contracts\SubscriptionRepositoryContract;
use App\Models\Book;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Session;
use Stripe;

use Illuminate\Http\Request;

class StripeController extends Controller
{

    protected BookRepositoryContract $bookRepositoryContract;
    protected PaymentRepositoryContract $paymentRepositoryContract;
    protected PlanRepositoryContract $planRepositoryContract;
    protected SubscriptionRepositoryContract $subscriptionRepositoryContract;

    public function __construct(BookRepositoryContract $bookRepositoryContract, PaymentRepositoryContract $paymentRepositoryContract, PlanRepositoryContract $planRepositoryContract, SubscriptionRepositoryContract $subscriptionRepositoryContract)
    {
        $this->bookRepositoryContract = $bookRepositoryContract;
        $this->paymentRepositoryContract = $paymentRepositoryContract;
        $this->planRepositoryContract = $planRepositoryContract;
        $this->subscriptionRepositoryContract = $subscriptionRepositoryContract;
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function stripe($id)
    {
        $book = $this->bookRepositoryContract->getOneBook($id);
        return view('pages.stripe', compact('book'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws Stripe\Exception\ApiErrorException
     */
    public function stripePost(Request $request, $id)
    {
        $book = $this->bookRepositoryContract->getOneBook($id);

        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $charge = Stripe\Charge::create([
            "amount" => 100 * $book->price,
            "currency" => "USD",
            "source" => $request->stripeToken,
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

        $this->paymentRepositoryContract->store($data);

        Session::flash('success', 'Payment Successful !');

        return redirect(route('index'));
    }

    public function index()
    {
        return view('pages.subscribe');
    }

    public function store(Request $request, $id)
    {

        $plan = $this->planRepositoryContract->getOnePLan($id);

        $stripe = new \Stripe\StripeClient(
            'sk_test_51L8jHaAcc1mBcc9SQyBW6iMyKmSV8mX0u0NcHWrROifm4Smvv4kJV3JIgwBNvVhIwnSnyN8oktEJrnGvpQ8HlqFd00MVj0wXbs'
        );

        $token = $stripe->tokens->retrieve($request->stripeToken);


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

        ];

        $this->subscriptionRepositoryContract->store($subData);

        auth()->user()->assignRole('seller');

        return redirect()->back();
    }

}
