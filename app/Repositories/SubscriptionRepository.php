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

    /**
     * @param $subData
     * @return mixed
     */
    public function store($subData)
    {
        return $this->subscription::create($subData);
    }

    /**
     * @param $params
     * @return mixed
     */
    public function getSub($params)
    {
        return $this->subscription::where($params)->with('plan')->first();
    }

    /**
     * @param $params
     * @return mixed
     */
    public function deleteSubscription($params)
    {
        return $this->subscription::where($params)->delete() ;
    }

}
