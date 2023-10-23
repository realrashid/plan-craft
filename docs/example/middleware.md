# Middleware Example: EnsureUserIsSubscribed

In this example, we'll create a custom middleware named `EnsureUserIsSubscribed` that will ensure a user has an active subscription plan before allowing access to certain routes. If the user does not have an active plan, they will be redirected to a billing page.

## Step 1: Create the Middleware

Create the middleware using the following command:

```bash
php artisan make:middleware EnsureUserIsSubscribed
```

This command will generate a new middleware class file named `EnsureUserIsSubscribed.php` in the `App\Http\Middleware` directory.

## Step 2: Define the Middleware Logic

Open the generated `EnsureUserIsSubscribed.php` file and add the following code:

```php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsSubscribed
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && ! $request->user()->hasActivePlan()) {
            // This user is not a paying customer...
            return redirect('billing');
        }

        return $next($request);
    }
}
```

## Step 3: Register the Middleware

Add the `EnsureUserIsSubscribed` middleware to the appropriate group within your `App\Http\Kernel.php` file. This will specify which routes should be protected by this middleware.

```php
protected $routeMiddleware = [
    // ...
    'isSubscribed' => \App\Http\Middleware\EnsureUserIsSubscribed::class,
];
```

## Step 4: Apply the Middleware to Routes

You can now apply the `isSubscribed` middleware to any routes that require users to have an active subscription. For example:

```php
Route::group(['middleware' => ['isSubscribed']], function () {
    // Your protected routes go here...
});
```

This example demonstrates how to create and use a custom middleware named `EnsureUserIsSubscribed` to restrict access to routes based on the user's subscription status. If a user does not have an active plan, they will be redirected to the billing page.

Please make sure to adjust the redirection URL (`'billing'`) to match your specific application's routing.
