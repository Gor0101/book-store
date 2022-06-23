<?php

namespace App\Console\Commands;

use App\Contracts\UserRepositoryContract;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SubEndCheck extends Command
{
    private UserRepositoryContract $userRepositoryContract;

    public function __construct(UserRepositoryContract $userRepositoryContract)
    {
        parent::__construct();
        $this->userRepositoryContract = $userRepositoryContract;
    }
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SubEndCheck:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $date = Carbon::now();
        $subscriptions = Subscription::where('period_end',$date->format('Y-m-d'))->get();
        foreach ($subscriptions as $subscriber) {
            $stripe = new \Stripe\StripeClient(
                'sk_test_51L8jHaAcc1mBcc9SQyBW6iMyKmSV8mX0u0NcHWrROifm4Smvv4kJV3JIgwBNvVhIwnSnyN8oktEJrnGvpQ8HlqFd00MVj0wXbs'
            );
            $stripe->subscriptions->cancel(
                $subscriber->sub_id,
            );
            $user = $this->userRepositoryContract->getOneUser(['id' => $subscriber->user_id]);
            $user->removeRole('seller');
            $subscriber->delete();
        }
    }
}
