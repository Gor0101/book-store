<?php

namespace App\Repositories;

use App\Contracts\PaymentRepositoryContract;
use App\Models\Payment;

class PaymentRepository implements PaymentRepositoryContract
{

    protected Payment $payment;

    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    public function store($data)
    {
        return $this->payment::create($data);
    }

}
