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

    /**
     * @param $data
     * @return mixed
     */
    public function store($data)
    {
        return $this->payment::create($data);
    }

    public function getPayment($params)
    {
        return $this->payment::where($params)->first();
    }

}
