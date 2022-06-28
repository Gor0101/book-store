<?php

namespace App\Http\Controllers;

use App\Contracts\BookRepositoryContract;
use App\Contracts\GenreRepositoryContract;
use App\Contracts\PaymentRepositoryContract;
use App\Contracts\PlanRepositoryContract;
use App\Contracts\SubscriptionRepositoryContract;
use App\Contracts\UserRepositoryContract;
use App\Http\Requests\BookCreateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BookController extends Controller
{

    protected GenreRepositoryContract $genreRepositoryContract;
    protected BookRepositoryContract $bookRepositoryContract;
    protected PaymentRepositoryContract $paymentRepositoryContract;
    protected UserRepositoryContract $userRepositoryContract;
    protected SubscriptionRepositoryContract $subscriptionRepositoryContract;
    protected PlanRepositoryContract $planRepositoryContract;

    public function __construct(GenreRepositoryContract $genreRepositoryContract, BookRepositoryContract $bookRepositoryContract, PaymentRepositoryContract $paymentRepositoryContract, UserRepositoryContract $userRepositoryContract, SubscriptionRepositoryContract $subscriptionRepositoryContract, PlanRepositoryContract $planRepositoryContract)
    {
        $this->genreRepositoryContract = $genreRepositoryContract;
        $this->bookRepositoryContract = $bookRepositoryContract;
        $this->paymentRepositoryContract = $paymentRepositoryContract;
        $this->userRepositoryContract = $userRepositoryContract;
        $this->subscriptionRepositoryContract = $subscriptionRepositoryContract;
        $this->planRepositoryContract = $planRepositoryContract;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        if (!$request->input('search')) {
            $search = null;
        } else {
            $search = $request->input('search');
        }
        $books = $this->bookRepositoryContract->getAllBooks($search);
        return view('pages.books', ['books' => $books, 'search' => $search]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $genres = $this->genreRepositoryContract->getAllGenres();
        return view('pages.create_book', compact('genres'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookCreateRequest $bookCreateRequest)
    {
        $sub = $this->subscriptionRepositoryContract->getSub(['user_id' => Auth::id()]);
        $plan = $this->planRepositoryContract->getOnePLan($sub->stripe_plan);
        if(count(Auth::user()->books) > $plan->limit){
            return view('pages.index');
        }
        $image = Storage::putFile('public/booksAvatars', $bookCreateRequest->file('bookAvatar'), 'private');
        $book_avatar = Str::replaceFirst('public', 'storage', $image);
        $file = Storage::putFile('public/booksPDF', $bookCreateRequest->file('bookFile'), 'private');
        $book_pdf = Str::replaceFirst('public', 'storage', $file);
        $data = [
            'name' => $bookCreateRequest->input('bookName'),
            'description' => $bookCreateRequest->input('textArea'),
            'price' => $bookCreateRequest->input('price'),
            'user_id' => Auth::id(),
            'genre_id' => $bookCreateRequest->input('genre'),
            'book_pdf' => $book_pdf,
            'book_avatar' => $book_avatar,
        ];
        $this->bookRepositoryContract->store($data);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->bookRepositoryContract->destroy($id);
    }

}
