<?php

namespace App\Contracts;

interface PlanRepositoryContract
{
    public function getAllPlans();
    public function getOnePLan($id);
}
