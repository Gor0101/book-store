<?php

namespace App\Repositories;

use App\Contracts\PlanRepositoryContract;
use App\Models\Plan;

class PlanRepository implements PlanRepositoryContract
{

    protected Plan $plan;

    public function __construct(Plan $plan)
    {
        $this->plan = $plan;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllPlans()
    {
        return $this->plan::all();
    }

    public function getOnePLan($id)
    {
        return $this->plan::where('id',$id)->first();
    }

}
