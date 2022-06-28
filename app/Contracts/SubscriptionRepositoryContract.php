<?php

namespace App\Contracts;

interface SubscriptionRepositoryContract
{
    public function store($subData);
    public function getSub($params);
}
