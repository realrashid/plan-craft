# Defining Subscription Plans

In PlanCraft, you have the power to craft your subscription plans with ease. The `PlanCraftServiceProvider` acts as your canvas for creating distinctive plans tailored to your SaaS application.

## Getting Started

1. Locate the `PlanCraftServiceProvider` file in your Laravel application. It is typically located at `app/Providers/PlanCraftServiceProvider.php`.

2. Open the `PlanCraftServiceProvider` file in your preferred code editor.

## Get Artistic

Unleash your creativity by using the `PlanCraft::create()` method to define your subscription plans. This method allows you to customize every detail of your plan, from its name to its pricing and features.

### PlanCraft::create Parameters

- `Plan Key`: A unique identifier for your plan.
- `Plan Name`: The name that will dazzle your users.
- `Pricing`: Set the stage with monthly and yearly prices.
- `Interval`: Choose between Monthly and Yearly intervals.
- `Plan Features`: Highlight the key offerings of your plan.
- `Plan Eligibilities`: Define any limitations or special attributes.
- `Stripe or Paddle Price IDs`: Link your plan to your preferred payment gateway.

## Let's Create!

Let's bring a sample plan to life. Behold, the creation of the illustrious "Basic" plan:

```php
PlanCraft::create('basic', 'Basic', '12|129.6', 'Monthly|Yearly', [
    '10 Chirps',
    '5 Teams',
], [
    'max_chirps' => 2,
    'max_teams' => 5,
], 'basic_price_monthly|basic_price_yearly')
->description('Basic plan users can create 10 Chirps per team and create 5 Teams.')
->trialDays(7)
->yearlyIncentive('Save 10%');
```

## The Enchanted Result

The incantation above conjures the following magical JSON representation:

```json
{
  "key": "basic",
  "name": "Basic",
  "price": {
    "monthly": "12",
    "yearly": "129.6"
  },
  "interval": [
    "Monthly",
    "Yearly"
  ],
  "description": "Basic plan users can create 10 Chirps on per team and Create 5 Teams.",
  "features": [
    "10 Chirps",
    "5 Teams"
  ],
  "eligibilities": {
    "max_chirps": 2,
    "max_teams": 5
  },
  "planId": {
    "monthly": "basic_price_monthly",
    "yearly": "basic_price_yearly"
  },
  "trialDays": 7,
  "monthlyIncentive": null,
  "yearlyIncentive": "Save 10%"
}
```

## Fine-Tuning Your Masterpiece

For a plan with Monthly billing only, the script is refined:

```php
PlanCraft::create('basic', 'Basic', '12', 'Monthly', [
    '10 Chirps',
    '5 Teams',
], [
    'max_chirps' => 2,
    'max_teams' => 5,
], 'basic_price_monthly')
->description('Basic plan users can create 10 Chirps per team and create 5 Teams.')
->trialDays(7);
```

## The Enchanted Result

```json
{
  "key": "basic",
  "name": "Basic",
  "price": {
    "monthly": "12"
  },
  "interval": [
    "Monthly"
  ],
  "description": "Basic plan users can create 10 Chirps per team and create 5 Teams.",
  "features": [
    "10 Chirps",
    "5 Teams"
  ],
  "eligibilities": {
    "max_chirps": 2,
    "max_teams": 5
  },
  "planId": {
    "monthly": "basic_price_monthly"
  },
  "trialDays": 7,
  "monthlyIncentive": null,
  "yearlyIncentive": null
}
```

Repeat this process for each plan you want to define.


Saving and Implementing Plans
Once you have defined your plans, save the `PlanCraftServiceProvider` file. Your subscription plans will now be ready to use within your Laravel SaaS application.

## Fetching Available Plans

Once you have defined your subscription plans, you can easily retrieve them using the following code:

```php
// Fetch all available plans using PlanCraft
$plans = PlanCraft::plans();
```

This code snippet will retrieve an array containing all the defined plans, allowing you to further utilize them within your Laravel SaaS application.
