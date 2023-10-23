# Checking User's Eligibility for a Specific Action

In this section, we'll explore how to determine if a user is eligible to perform a specific action based on their subscription plan using the `checkEligibility` method.

## Usage

The `checkEligibility` method allows you to check if the user is eligible to perform a specific action based on their subscription plan's configured eligibility limits. Here's an example of how to use it:

```php
$user = auth()->user();

// Check if the user is eligible to create a new project
$isEligibleToCreateProject = $user->checkEligibility('max_project');
```

## Explanation

The code above get the current authenticated user and then checks if they are eligible to create a new project using the `checkEligibility` method. It returns `true` if the user is eligible, and `false` if they are not.

## Parameters

`$eligibilityKey`: The key of the eligibility to check eligibility for.
`$userCreated`: The user's count for the specific eligibility limit (default is 0).

## Result

After running the code, the `$isEligibleToCreateProject` variable will be `true` if the user is eligible to create a new project, and `false` if they are not.


<br />

>Note: This method is particularly useful for controlling specific actions based on the user's subscription plan.
