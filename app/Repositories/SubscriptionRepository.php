<?php

namespace App\Repositories;

use App\Contracts\SubscriptionRepositoryContract;
use App\Models\Subscription;

class SubscriptionRepository implements SubscriptionRepositoryContract
{

    protected Subscription $subscription;

    public function __construct(Subscription $subscription)
    {
        $this->subscription = $subscription;
    }

    public function store($subData)
    {
        return $this->subscription::create($subData);
    }

}
