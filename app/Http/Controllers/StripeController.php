<?php

namespace App\Http\Controllers;

use App\Contracts\BookRepositoryContract;
use App\Contracts\PaymentRepositoryContract;
use App\Contracts\PlanRepositoryContract;
use App\Contracts\SubscriptionRepositoryContract;
use App\Contracts\UserRepositoryContract;
use App\Models\Book;
use App\Models\Payment;
use App\Models\Subscription;
use App\Services\PaymentService;
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
    protected UserRepositoryContract $userRepositoryContract;

    public function __construct(BookRepositoryContract $bookRepositoryContract, PaymentRepositoryContract $paymentRepositoryContract, PlanRepositoryContract $planRepositoryContract, SubscriptionRepositoryContract $subscriptionRepositoryContract, UserRepositoryContract $userRepositoryContract)
    {
        $this->bookRepositoryContract = $bookRepositoryContract;
        $this->paymentRepositoryContract = $paymentRepositoryContract;
        $this->planRepositoryContract = $planRepositoryContract;
        $this->subscriptionRepositoryContract = $subscriptionRepositoryContract;
        $this->userRepositoryContract = $userRepositoryContract;
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
        $paymentService = new PaymentService();
        $paymentService = $paymentService->payment($request->input(), $id);

        $this->paymentRepositoryContract->store($paymentService['data']);

        Session::flash('success', 'Payment Successful !');

        return redirect(route('index'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('pages.subscribe');
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws Stripe\Exception\ApiErrorException
     */
    public function store(Request $request, $id)
    {
        $paymentService = new PaymentService();
        $paymentService = $paymentService->subscriptionPayment($request->input(), $id);

        if ($paymentService) {
            $this->subscriptionRepositoryContract->store($paymentService['subData']);
            auth()->user()->assignRole('seller');
            return redirect()->back();
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|void
     * @throws Stripe\Exception\ApiErrorException
     */
    public function refundPayment($id)
    {
        $stripe = new \Stripe\StripeClient(
            'sk_test_51L8jHaAcc1mBcc9SQyBW6iMyKmSV8mX0u0NcHWrROifm4Smvv4kJV3JIgwBNvVhIwnSnyN8oktEJrnGvpQ8HlqFd00MVj0wXbs'
        );
        $userPayment = $this->paymentRepositoryContract->getPayment(['id' => $id]);
        $refund = $stripe->refunds->create([
            'charge' => $userPayment->payable_id,
        ]);

        if ($refund->status == "succeeded") {
            Payment::where('user_id', Auth::id())->update(['refund_id' => $refund->id]);
            return redirect()->back();
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|void
     * @throws Stripe\Exception\ApiErrorException
     */
    public function refundSubscription($id)
    {
        $date = Carbon::now();
        $stripe = new \Stripe\StripeClient(
            'sk_test_51L8jHaAcc1mBcc9SQyBW6iMyKmSV8mX0u0NcHWrROifm4Smvv4kJV3JIgwBNvVhIwnSnyN8oktEJrnGvpQ8HlqFd00MVj0wXbs'
        );

        $sub = $this->subscriptionRepositoryContract->getSub(['id' => $id]);
        $user = $this->userRepositoryContract->getOneUser(['id' => Auth::id()]);
        $stripe->subscriptions->cancel(
            $sub->sub_id
        );
        if ($sub->status == "active") {
            Subscription::where('user_id', Auth::id())->update(['cancel_at_period_end' => $date->toDateString()]);
            $user->removeRole('seller');
            $this->subscriptionRepositoryContract->deleteSubscription(['id' => $id]);
            return redirect()->back();
        }
    }
}
