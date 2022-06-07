# bond-algoritma
composer create-project laravel/laravel api

touch database/database.sqlite

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
