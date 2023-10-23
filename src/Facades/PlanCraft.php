<?php

namespace RealRashid\PlanCraft\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \RealRashid\PlanCraft\PlanCraft
 */
class PlanCraft extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \RealRashid\PlanCraft\PlanCraft::class;
    }
}
