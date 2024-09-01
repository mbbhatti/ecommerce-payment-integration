# Payment API Integration in Laravel

This Laravel module simulates a checkout system with Stripe payment integration.

## Setup

1. **Clone Repository**

    ```bash
    git clone https://github.com/mbbhatti/ecommerce-payment-integration.git
    cd ecommerce-payment-integration
    ```

2. **Install Dependencies**

    ```bash
    composer install
    ```
3. **Set Up Environment**

   Copy the `.env.example` file to `.env`

    ```bash
    cp .env.example .env
    ```
   
4. **Generate Key**

    ```bash
    php artisan key:generate
    ```

5. **Configure Database**

   Update `.env`:

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=laravel
    DB_USERNAME=root
    DB_PASSWORD=
    ```

6. **Run Migrations & Seeder**

    ```bash
    php artisan migrate
    php artisan db:seed
    ```

7. **Configure Stripe**

   Add your Stripe API keys to `.env`:

    ```env
    STRIPE_KEY=your_stripe_key
    STRIPE_SECRET=your_stripe_secret
    ```

8. **Run Application**

    ```bash
    php artisan serve
    ```

## Testing

1. **Generate Token**

   POST to `/api/auth/token` with:

    ```json
    {
      "email": "test@example.com",
      "password": "password"
    }
    ```

   **Response:**

    ```json
    {
      "token": "Bearer <token>"
    }
    ```

2. **Create Order**

   POST to `/api/order` with `Authorization: Bearer <token>` header and:

    ```json
    {
      "amount": 100.00
    }
    ```
   **Validation Error Response:**

   If the `amount` field is missing or invalid, you might receive a response like this:

    ```json
    {
      "errors": {
        "amount": [
            "The amount field is required."
        ]
      }
    }
    ```

   **Success Response:**

    ```json
    {
         "order": {
             "orderId": 1,
             "totalAmount": 78.20,
             "paymentStatus": "paid",
             "user": "Test User"
         }
    }
    ```

   **Failure Response:**

    ```json
    {
         "order": {
             "orderId": 2,
             "totalAmount": 78.2001,
             "paymentStatus": "failed",
             "user": "Test User"
        }
    }
    ```
