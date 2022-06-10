# bond-algoritma
[![Actions Status](https://github.com/luisdalmolin/laravel-ci-test/workflows/CI/badge.svg)](https://github.com/RasimAghayev/bond-algoritma/actions)

composer create-project laravel/laravel api

touch database/database.sqlite

https://bond-algoritma.herokuapp.com/api/

php artisan make:model Bond
php artisan make:model PurchaseOrder

php artisan make:migration create_comments_table
php artisan make:migration create_purchase_order_table

php artisan migrate

php artisan make:seeder BondSeeder
php artisan make:seeder PurchaseOrderSeeder

php artisan make:factory BondFactory
php artisan make:factory PurchaseOrderFactory

php artisan db:seed

php artisan tinker -> App\Models\Bond::all() | App\Models\PurchaseOrder::all()


php artisan make:controller API/BondController --resource
php artisan make:controller API/PurchaseOrderController --resource

php artisan make:resource BondResource
php artisan make:resource PurchaseOrderResource


php artisan make:test BondTest
php artisan make:test PurchaseOrderTest


POST https://bond-algoritma.herokuapp.com/api/bonds/
```json
{
"emisia_date": "2021-11-08",
"turnover_date": "2022-11-03",
"nominal_price": 100,
"frequency_payment_coupons": "4",
"period_for_calculating_interest": "360",
"coupon_interest": 10
}

{
  "emisia_date": "2021-11-08",
  "turnover_date": "2022-11-07",
  "nominal_price": 200,
  "frequency_payment_coupons": "4",
  "period_for_calculating_interest": "364",
  "coupon_interest": 20
}

{
  "emisia_date": "2021-11-08",
  "turnover_date": "2022-11-08",
  "nominal_price": 300,
  "frequency_payment_coupons": "4",
  "period_for_calculating_interest": "365",
  "coupon_interest": 30
}
```

POST https://bond-algoritma.herokuapp.com/api/bond/3/order
```json
{
  "order_date": "2021-11-23",
  "number_bonds_received": 30
}
```

[![Run in Postman](https://run.pstmn.io/button.svg)](https://documenter.getpostman.com/view/1965733/Uz5NiDCK)