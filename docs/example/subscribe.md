# Subscribe to Plan

For this example, we'll demonstrate how to subscribe a user to a plan using Laravel `Cashier-Stripe` and `Alpine.js`.

## Step 1: Create a Route

Define a route in your `web.php` file to handle the subscription process.

```php
use App\Http\Controllers\SubscriptionController;

Route::post('/subscribe', [SubscriptionController::class, 'subscribe'])->name('subscribe.post');
```

## Step 2: Create a Controller

Create a controller named `SubscriptionController` using the following command:

```bash
php artisan make:controller SubscriptionController
```

In the controller, add the methods to display the subscription form and handle the subscription process.

```php
use Illuminate\Http\Request;
use RealRashid\PlanCraft\Facades\PlanCraft;

class SubscriptionController extends Controller
{
    // Show subscription form
    public function showPlans()
    {
        $plans = PlanCraft::plans();

        $subscription = $user->currentPlan();

        return view('subscription.plans', compact('plans', 'subscription'));
    }

    // Handle subscription
    public function subscribe(Request $request)
    {
        // Step 1: Retrieve the selected planKey and interval from the request
        $planKey = $request->planKey;
        $interval = $request->interval;

        // Step 2: Find the plan details based on the selected planKey
        $plan = PlanCraft::findPlan($planKey);

        // Step 3: Construct the planId parameter based on the selected interval
        if ($interval === 'Monthly') {
            $planId = $plan->planId['monthly'];
        } else {
            $planId = $plan->planId['yearly'];
        }

        // Step 4: Retrieve the authenticated user making the request
        $user = $request->user();

        // Step 5: Retrieve the payment token from the request
        $paymentMethod = $request->token;

        // Step 6: Create or retrieve the Stripe customer associated with the user
        $user->createOrGetStripeCustomer();

        // Step 7: Update the user's default payment method with the provided token
        $user->updateDefaultPaymentMethod($paymentMethod);

        // Step 8: Create a new subscription with the selected plan
        $subscription = $user->newSubscription('default', $planId)
            ->trialDays($plan->trialDays)
            ->create($paymentMethod, ['email' => $user->email]);

        // Step 9: Check if the subscription was successfully created in Stripe
        if ($subscription) {
            // Step 10: Create a PlanCraft plan and associate it with the user
            $user->createPlan($planKey);

            // Step 11: Redirect to the dashboard with a success message
            return redirect()->route('dashboard')->with('success','You have subscribed successfully!');
        }

        // Step 12: If subscription creation failed, redirect back with an error message
        return redirect()->back()->with('error','Something went wrong while subscribing. Please try again.');
    }
}

```

# Step 3: Create the Plans Form View

Create a Blade view named `plans.blade.php` in the `resources/views/subscription` directory. This view will contain the subscription form.

```blade 
<form id="payment-form" class="flex" action="{{ route('subscribe') }}" method="POST">
    @csrf
    <div class="w-1/1 pr-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($plans as $plan)
                <label
                    class="relative block p-6 bg-white border border-gray-200 rounded-lg shadow-lg transform transition duration-300 hover:scale-105 cursor-pointer">

                    <!-- The hidden input with name 'interval' -->
                    <input type="hidden" name="interval" x-bind:value="interval">

                    <input type="radio" name="planKey" value="{{ $plan->key }}"
                        {{ $plan->key == 'pro' ? 'checked' : '' }}
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
    </div>

    <!-- Stripe Elements container -->
    <div class="w-1/3">
        <div id="stripe-element-container" class="p-6 bg-white rounded-lg shadow-lg mb-4">
            <div>
                <label for="card-element" class="block text-sm font-medium text-gray-700">
                    {{ __('Card Information') }}
                </label>
                <div id="card-element" class="mt-1 rounded-md border border-indigo-300 p-4">
                    <!-- A Stripe Element will be inserted here. -->
                </div>

                <!-- Used to display form errors. -->
                <div id="card-errors" class="mt-2 text-sm text-red-600 space-y-1" role="alert"></div>
            </div>
        </div>

        <button type="submit" id="card-button" data-secret="{{ $intent->client_secret }}"
            class="bg-indigo-600 text-white py-3 px-6 rounded-full hover:bg-indigo-700 transition duration-300 ease-in-out transform hover:-translate-y-1 w-full">
            Subscribe Now
        </button>
    </div>
</form>
```

## Step 4: Create JavaScript for Stripe Elements

Create a JavaScript file named `subscribe.js` in the `public/js` directory to handle the Stripe payment form.

```js
<script src="https://js.stripe.com/v3/"></script>
<script>
    var stripe = Stripe("{{ config('services.stripe.key') }}");
    var elements = stripe.elements();
    var cardBtn = document.getElementById('card-button');

    var card = elements.create('card', {
        style: {
            base: {
                color: '#32325d',
                fontFamily: 'Arial, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                    color: '#a0aec0',
                },
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a',
            },
        },
    });

    card.mount('#card-element');

    // Handle real-time validation errors from the card Element.
    card.addEventListener('change', function(event) {
        var displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });

    // Create a PaymentIntent when the form is submitted.
    var form = document.getElementById('payment-form');
    form.addEventListener('submit', async (e) => {
        e.preventDefault()

        cardBtn.disabled = true
        const {
            setupIntent,
            error
        } = await stripe.confirmCardSetup(
            cardBtn.dataset.secret, {
                payment_method: {
                    card: card
                }
            }
        )

        if (error) {
            cardBtn.disable = false
        } else {
            let token = document.createElement('input')
            token.setAttribute('type', 'hidden')
            token.setAttribute('name', 'token')
            token.setAttribute('value', setupIntent.payment_method)
            form.appendChild(token)
            form.submit();
        }
    });
</script>
```

In this example, we perform the following steps:

- Retrieve the selected `planKey` and `interval` from the request.
- Find the plan details based on the selected `planKey`.
- Construct the `planId` parameter based on the selected `interval`.
- Retrieve the authenticated user making the request.
- Retrieve the payment token from the request.
- Create or retrieve the Stripe customer associated with the user.
- Update the user's default payment method with the provided token.
- Create a new subscription with the selected plan.
- Check if the subscription was successfully created in Stripe.
- Create a PlanCraft plan and associate it with the user.
- Redirect to the dashboard with a success message.
- If subscription creation failed, redirect back with an error message.

This example provides a detailed guide on how to subscribe a user to a plan using your package with Laravel Cashier-Stripe. Make sure to adapt it to your specific application's structure and requirements.
