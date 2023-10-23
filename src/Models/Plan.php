<?php

namespace RealRashid\PlanCraft\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Plan extends Pivot
{
    use HasFactory;

    protected $table = 'plans';
}
