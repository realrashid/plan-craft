# Displaying Subscription Plans

For this example, I'm using `Alpine.js` and `Tailwind CSS` to render the subscription plans in Laravel application. Follow these steps to get started:

## Step 1: Fetch Plans in Controller

In your controller, use `PlanCraft::plans()` to fetch the plans.

```php
use RealRashid\PlanCraft\Facades\PlanCraft;

public function showPlans()
{
    $plans = PlanCraft::plans();
    return view('plans.index', ['plans' => $plans]);
}
```

## Step 2: Create a Blade View

Create a Blade view (e.g., `resources/views/plans/index.blade.php`) to render the plans.

```blade
@extends('layouts.app')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($plans as $plan)
            <label
                class="relative block p-6 bg-white border border-gray-200 rounded-lg shadow-lg transform transition duration-300 hover:scale-105 cursor-pointer">

                <!-- The hidden input with name 'interval' -->
                <input type="hidden" name="interval" x-bind:value="interval">

                <input type="radio" name="planKey" value="{{ $plan->key }}" {{ $plan->key == 'pro' ? 'checked' : '' }}
                    class="absolute -top-2 -left-2 h-5 w-5 text-indigo-600 border border-gray-300 focus:ring-indigo-500">

                <div class="text-center mb-4">
                    <h4 class="text-2xl font-bold text-indigo-600 mb-4">
                        {{ $plan->name }}</h4>
                    <div class="text-gray-700 mb-4 text-[12px]">
                        @if ($plan->trialDays)
                            <p class="text-indigo-600">Trial for {{ $plan->trialDays }}
                                days</p>
                        @endif
                    </div>
                    <p class="text-gray-600 text-sm">{{ $plan->description }}</p>
                </div>

                <ul class="text-gray-700 text-left mt-2">
                    @foreach ($plan->features as $feature)
                        <li class="flex items-center mb-2">
                            <svg class="w-4 h-4 mr-2 text-indigo-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z">
                                </path>
                            </svg>
                            {{ $feature }}
                        </li>
                    @endforeach
                </ul>

                <div class="text-center mt-6">
                    <span class="block text-2xl font-bold text-indigo-600"
                        x-text="interval === 'Monthly' ? '${{ $plan->price->monthly }}/month' : '${{ $plan->price->yearly }}/year'">
                    </span>
                    <!-- Display the incentive (yearly) if interval is 'Yearly' -->
                    <span class="block text-sm text-indigo-500 font-bold mb-2 mt-2"
                        x-show="interval === 'Yearly' && '{{ $plan->yearlyIncentive }}'">
                        {{ $plan->yearlyIncentive }}
                    </span>
                </div>
            </label>
        @endforeach
    </div>
@endsection
```

## Step 3: Styling with Tailwind CSS

Ensure that you have `Tailwind CSS` included in your project. If not, follow the installation steps from the official documentation.

## Step 4: Define Routes
In your `web.php` routes file, define a route to access the plans.

```php
use App\Http\Controllers\PlanController;

Route::get('/plans', [PlanController::class, 'showPlans']);
```

## Step 5: Test

Start your development server (`php artisan serve`) and visit `http://localhost:8000/plans` to see the available plans.

Make sure to replace `'layouts.app'` with your actual layout file.

This example assumes that you have already set up `PlanCraft` and integrated it with your Laravel application. If you encounter any issues or need further assistance, feel free to let me know!
