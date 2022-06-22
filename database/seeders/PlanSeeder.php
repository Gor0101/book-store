<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Stripe\Plan;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $stripe = new \Stripe\StripeClient(
            'sk_test_51L8jHaAcc1mBcc9SQyBW6iMyKmSV8mX0u0NcHWrROifm4Smvv4kJV3JIgwBNvVhIwnSnyN8oktEJrnGvpQ8HlqFd00MVj0wXbs'
        );
        $standard =  $stripe->products->create([
            'name' => 'Standard',
        ]);

        $standard_plan = $stripe->plans->create([
            'amount' => 1000,
            'currency' => 'usd',
            'interval' => 'month',
            'product' => $standard->id,
        ]);

        $premium =  $stripe->products->create([
            'name' => 'Premium',
        ]);

        $premium_plan = $stripe->plans->create([
            'amount' => 2500,
            'currency' => 'usd',
            'interval' => 'month',
            'product' => $premium->id,
        ]);


        DB::table('plans')->insert([

        [
            'name' => 'Standard',
            'price' => 10,
            'period' => 'monthly',
            'limit' => 5,
            'plan_id' => $standard_plan->id,
        ],
            [
                'name' => 'Premium',
                'price' => 25,
                'period' => 'monthly',
                'limit' => 15,
                'plan_id' => $premium_plan->id,
            ],
        ]);
    }
}
