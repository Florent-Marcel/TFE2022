<?php

namespace Database\Seeders;

use App\Models\Paypal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaypalSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'account' => "sb-0qlpm20022832@business.example.com",
                'client_id' => "eyJpdiI6IjRFMGZ1a1IveXhud0VLQSs0MTN1a0E9PSIsInZhbHVlIjoiMjRxTGsxUWRmK3A1elRBbFdnL1p2VkNvNEtoV3cwRTlNQmlkSVVlSFQ1bk10VFd0cUIyRU5HeXM4Qk45WjkxQnljVVltQzZkVDJseVBzYjhUSHB0bVhQd3VOQjcwWkcrejlQRjRGa09OZzhQa1dLWGtDc1RYREJVbkl2anVXQU0iLCJtYWMiOiJkNzMwMTI2YzdmOGFmZGE0N2U3MWQzYWNmOTU5MjJiODJlZmNiZjA2MzdlMGQyMzRmZjUxNzg2YjY0YTM3ZTAzIiwidGFnIjoiIn0",
                'secret' => "eyJpdiI6IkZFeXVPdE1IKys5Skp3cXhVZjc0cWc9PSIsInZhbHVlIjoiYlo4RXdzZk4vRkRMR3ZJTlR0RW1lQ1FVWWZIOElsdzlnMVNJUkQxdWFvdjk5SVhWa2lVcTJLUHNrUUdYVjM5TFVPQzB4YWRBN1hCZTV5OUY1aGoreU8zVU5Qbm8zUTZFK0lRRnRxcGIyR3cvejVkZ0ZGSWkxMmFKV2ZNNVZoYUciLCJtYWMiOiJhOTk1MDc0NmU1ODhiMmFhNDcwMWRjYzUzMmNkOTIyOGRmOTIzZWMxOTUyZTRkYTI5OTg4ZTJkN2Q5NDY3NTkzIiwidGFnIjoiIn0=",
                'base_url' => "https://api-m.sandbox.paypal.com",
            ],
        ];

        Paypal::insert($data);
    }
}
