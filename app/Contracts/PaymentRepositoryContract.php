<?php

namespace App\Contracts;

interface PaymentRepositoryContract
{

    public function store($data);
    public function getPayment($params);
}
