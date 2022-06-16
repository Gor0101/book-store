<?php

namespace App\Http\Controllers;
use App\Contracts\BookRepositoryContract;
use App\Contracts\PaymentRepositoryContract;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;
use Session;
use Stripe;

use Illuminate\Http\Request;

class StripeController extends Controller
{

    protected BookRepositoryContract $bookRepositoryContract;
    protected PaymentRepositoryContract $paymentRepositoryContract;

    public function __construct(BookRepositoryContract $bookRepositoryContract, PaymentRepositoryContract $paymentRepositoryContract){
        $this->bookRepositoryContract = $bookRepositoryContract;
        $this->paymentRepositoryContract = $paymentRepositoryContract;
    }

    public function stripe($id)
    {
        $book = $this->bookRepositoryContract->getOneBook($id);
        return view('pages.stripe', compact('book'));
    }

    public function stripePost(Request $request,$id)
    {
        $book = $this->bookRepositoryContract->getOneBook($id);

        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $charge = Stripe\Charge::create ([
            "amount" => 100 * $book->price,
            "currency" => "USD",
            "source" => $request->stripeToken,
            "description" => "This is payment for ".$book->name,
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
}
