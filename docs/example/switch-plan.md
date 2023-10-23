# Switch Plan

For this example, we'll demonstrate how to switch a user's subscription plan using Laravel `Cashier-Stripe` and `Alpine.js`.

## Step 1: Create a Route

Define a route in your `web.php` file to handle the subscription process.

```php
use App\Http\Controllers\SubscriptionController;

Route::post('/switch', [SubscriptionController::class, 'switchSubscription'])->name('subscription.switch');
```

## Step 2: Create a Controller

Create a controller named `SubscriptionController` using the following command:

```bash
php artisan make:controller SubscriptionController
```

In the controller, add the methods to display the switch subscription form and handle the switch subscription process.

```php
public function switchSubscription(Request $request)
{
    // Step 1: Get the authenticated user from the request
    $user = $request->user();

    // Step 2: Get the selected plan key and interval from the request
    $planKey = $request->planKey;
    $interval = $request->interval;

    // Step 3: Find the plan details based on the selected planKey
    $plan = PlanCraft::findPlan($planKey);

    // Step 4: Construct the planId parameter based on the selected interval
    if ($interval === 'Monthly') {
        $planId = $plan->planId['monthly'];
    } else {
        $planId = $plan->planId['yearly'];
    }

    // Step 5: Swap and invoice the user's subscription with the new plan
    $user->subscription('default')->swapAndInvoice($planId);

    // Step 6: For PlanCraft, switch the user's plan using the provided key
    $user->switchPlan($planKey);

    // Step 7: Redirect back with a success message
    return redirect()->back()->banner('Subscription switched successfully');
}
```
# Step 3: Create the Plans Form View

Create a Blade view named `billing.blade.php` in the `resources/views/subscription` directory. This view will contain the subscription form.

```blade 
<div class="container mx-auto" x-data="{ showUpdatePaymentMethodModal: false, interval: 'Monthly', show: false }">
    @if ($subscription)
        <form action="{{ route('switchSubscription') }}" method="POST" class="flex">
            @csrf
            <div class="bg-white rounded-lg shadow-lg p-8 mb-8 w-1/2 mr-8">
                <h2 class="text-4xl font-bold mb-4 text-indigo-500">Your Subscription</h2>
                <h2 class="text-2xl font-bold mb-4 text-indigo-500">{{ $subscription->name }}</h2>
                <p class="text-gray-700 text-lg mb-2">{{ $subscription->description }}</p>
                <p class="text-indigo-600 text-xl font-bold">${{ $subscription->price->monthly }}/month
                </p>
                <p class="text-gray-600 text-sm mt-2 font-semibold">
                    Default payment method: {{ $defaultPaymentMethod->card->brand }}
                    ****{{ $defaultPaymentMethod->card->last4 }}
                    <a class="text-indigo-600 ml-2 hover:underline focus:outline-none cursor-pointer"
                        x-on:click="showUpdatePaymentMethodModal = true">
                        Update Payment Method
                    </a>
                </p>

            </div>
            <div class="flex flex-col w-1/2">
                <h2 class="text-3xl font-bold mb-4 text-indigo-500">Switch Plans</h2>
                <div class="flex justify-center mb-4">
                    <a x-on:click="interval = 'Monthly'"
                        :class="{
                            'bg-indigo-500 text-white': interval ===
                                'Monthly',
                            'bg-gray-200 text-gray-800': interval !== 'Monthly'
                        }"
                        class="py-2 px-4 rounded-full mr-4 cursor-pointer">
                        Monthly
                    </a>
                    <a x-on:click="interval = 'Yearly'"
                        :class="{
                            'bg-indigo-500 text-white': interval ===
                                'Yearly',
                            'bg-gray-200 text-gray-800': interval !== 'Yearly'
                        }"
                        class="py-2 px-4 rounded-full cursor-pointer">
                        Yearly
                    </a>
                </div>
                <div class="space-y-4">
                    @foreach ($plans as $plan)
                        <div class="relative">
                            <input type="hidden" name="interval" x-bind:value="interval">

                            <input class="sr-only peer" type="radio" name="planKey" value="{{ $plan->key }}"
                                id="{{ $plan->key }}" {{ $plan->key === $subscription->key ? 'checked' : '' }}>
                            <label for="{{ $plan->key }}"
                                class="flex items-center h-24 px-8 bg-white bg-opacity-50 border border-gray-300 rounded cursor-pointer transform transition duration-300 hover:scale-105 peer-checked:bg-indigo-100 ring-opacity-50 ring-indigo-600 peer-checked:ring-2 group">
                                <div
                                    class="flex items-center justify-center w-6 h-6 border border-gray-600 rounded-full peer-checked:group:bg-indigo-600">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="hidden w-4 h-4 text-indigo-200 fill-current peer-checked:group:visible"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="flex flex-col ml-6">
                                    <span class="text-xl font-medium text-gray-800">{{ $plan->name }}</span>
                                    <span class="text-sm font-light text-gray-600">{{ $plan->description }}</span>
                                </div>
                                <span class="ml-auto text-1xl font-bold text-indigo-600"
                                    x-text="interval === 'Monthly' ? '${{ $plan->price->monthly }}/month' : '${{ $plan->price->yearly }}/year'">
                                </span>
                                <!-- Display the yearly incentive in top right corner -->
                                <span
                                    class="absolute -top-2 right-0 mt-2 p-2 bg-indigo-500 text-white text-sm font-medium rounded"
                                    x-show="interval === 'Yearly' && '{{ $plan->yearlyIncentive }}'">
                                    {{ $plan->yearlyIncentive }}
                                </span>
                            </label>
                        </div>
                    @endforeach
                </div>
                <button type="submit"
                    class="bg-indigo-600 text-white py-3 px-6 rounded-full hover:bg-indigo-700 transition duration-300 ease-in-out transform hover:-translate-y-1 self-end mt-6">
                    Switch
                </button>
            </div>

        </form>

    @endif
</div>
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

- Get the authenticated user from the request.
- Get the selected `plankey` and `interval` from the request.
- Find the plan details based on the selected `planKey`.
- Construct the `planId` parameter based on the selected `interval`.
- Swap and invoice the user's subscription with the new plan.
- For PlanCraft, switch the user's plan using the provided key.
- Redirect back with a success message.


This example demonstrates how to smoothly transition a user from their current subscription plan to a new one. Be sure to customize it to fit your specific application's structure and requirements.
