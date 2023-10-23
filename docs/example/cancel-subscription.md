# Cancel Subscription

In this example, we'll demonstrate how to cancel a user's subscription using Laravel `Cashier-Stripe` and `Alpine.js`.

## Step 1: Create a Route

Define a route in your `web.php` file to handle the cancellation process.

```php
use App\Http\Controllers\SubscriptionController;

Route::post('/cancel', [SubscriptionController::class, 'cancelSubscription'])->name('subscription.cancel');
```

## Step 2: Create a Controller

Create a controller named `SubscriptionController` using the following command:

```bash
php artisan make:controller SubscriptionController
```
Next, in the `SubscriptionController`, add the `cancelSubscription` method. This method will be responsible for handling the subscription cancellation process.

```php
use Illuminate\Http\Request;
use RealRashid\PlanCraft\Facades\PlanCraft;

class SubscriptionController extends Controller
{
    // Cancel subscription
    public function cancelSubscription(Request $request)
    {
        // Step 1: Get the authenticated user from the request
        $user = $request->user();

        // Step 2: Check if the user has an active subscription
        if ($user->hasActivePlan()) {

            // Step 3: Cancel the user's Stripe subscription
            $user->subscription('default')->cancelNow();

            // Step 4: Check if the subscription was successfully cancelled
            if ($user->subscription('default')->canceled()) {
                // Step 5: Delete the associated PlanCraft plan
                $user->deletePlan();

                // Step 6: Redirect back with a success message
                return redirect()->back()->with('success', 'Subscription cancelled successfully.');
            }
        }

        // Step 7: If any of the steps above failed, redirect back with an error message
        return redirect()->back()->with('error', 'Unable to cancel subscription.');
    }
}
```

## Step 3: Create the Cancellation Form

In your Blade view, add the following form to enable users to cancel their subscription:

```html
<form id="cancel-subscription-form" action="{{ route('subscription.cancel') }}" method="POST">
    @csrf
    <!-- Add any additional form fields or hidden inputs if needed -->
    <button type="submit" class="bg-red-500 text-white py-3 px-6 rounded-full hover:bg-red-600 transition duration-300 ease-in-out transform hover:-translate-y-1 w-full">
        Cancel Subscription
    </button>
</form>
```

In this example, we perform the following steps:

- Get the authenticated user from the request.
- Check if the user has an active subscription.
- If the user has an active subscription, cancel the subscription in Stripe.
- Delete the associated `PlanCraft` plan.
- Check if the subscription was successfully cancelled.
- If successful, redirect back with a success message.
- If any of the steps fail, redirect back with an error message.

This example provides a detailed guide on how to cancel a user's subscription using Laravel `Cashier-Stripe`. Make sure to adapt it to your specific application's structure and requirements.
