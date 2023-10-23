# Trying the Chirpers Demo App

To try out the Chirpers demo app, you can clone the GitHub repository and set it up locally on your machine. Follow these steps:

## Step 1: Clone the Repository

Open your terminal or command prompt and run the following command to clone the Chirpers repository:

```bash
git clone https://github.com/realrashid/chirpers.git
```

## Step 2: Install Dependencies

Navigate to the project directory and install the necessary dependencies using Composer:

```bash
cd chirpers
composer install && npm install && npm run build
```

## Step 3: Set Up Environment Variables

Copy the `.env.example` file and rename it to `.env`. Then, open the file and configure your database settings and other environment variables.

```bash
cp .env.example .env
```

Add the following Stripe environment variables:

```env
STRIPE_KEY=your-stripe-key
STRIPE_SECRET=your-stripe-secret
STRIPE_WEBHOOK_SECRET=your-stripe-webhook-secret
CASHIER_CURRENCY=your-cashier-currency
```

Feel free to replace `your-stripe-key`, `your-stripe-secret`, `your-stripe-webhook-secret`, and `your-cashier-currency` with your actual Stripe credentials and preferred currency.

## Step 4: Generate Application Key

Generate a unique application key by running the following command:

```bash
php artisan key:generate
```

## Step 5: Migrate the Database

Run the database migrations to create the necessary tables:

```bash
php artisan migrate
```

## Step 6: Start the Application

Start the development server:

```bash
php artisan serve
```

## Step 7: Access the Application

Open your web browser and go to `http://localhost:8000` to access the Chirpers demo app.

## Step 8: Explore and Test

You can now explore the features of the Chirpers app, try out the subscription plans, and create chirps within teams.

### Stripe Test Card
To test the payment functionality, you can use the following Stripe test card details:

Card Number: `4242 4242 4242 4242` \
Expiration Date: Any future date \
CVC: Any 3-digit number

You can now use the provided Stripe test card for testing payment transactions in the Chirpers demo app.

----

Note: This demo app is for demonstration purposes only and may not have full production-level functionality.
