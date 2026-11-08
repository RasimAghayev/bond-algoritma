# API Reference — bond-algoritma

Base path: `/api` (production: `https://bond-algoritma.herokuapp.com/api/`).

## Endpoints

### Bonds

| Method | Path | Description | Auth | Body / Query |
|--------|------|-------------|------|--------------|
| GET | `/api/bonds` | List bonds (with `purchase_orders_count`) | No | — |
| POST | `/api/bonds` | Create a bond | No | Bond payload |
| GET | `/api/bonds/{id}` | Get a single bond | No | — |
| PUT/PATCH | `/api/bonds/{id}` | Update a bond | No | Bond payload |
| DELETE | `/api/bonds/{id}` | Delete a bond | No | — |
| GET | `/api/bonds/{id}/payouts` | Bond payout dates | No | `?arr=1` returns a raw array |

### Purchase orders

| Method | Path | Description | Auth | Body / Query |
|--------|------|-------------|------|--------------|
| GET | `/api/purchase_orders` | List purchase orders (with nested bond) | No | — |
| POST | `/api/purchase_orders` | Create a purchase order | No | Order payload |
| GET | `/api/purchase_orders/{id}` | Get a single purchase order | No | — |
| PUT/PATCH | `/api/purchase_orders/{id}` | Update a purchase order | No | Order payload |
| DELETE | `/api/purchase_orders/{id}` | Delete a purchase order | No | — |

### Custom endpoints

| Method | Path | Description | Auth | Body |
|--------|------|-------------|------|------|
| POST | `/api/bonds/{id}/order` | Create an order for a bond | No | `order_date`, `number_bonds_received` |
| GET | `/api/bond/order/{id}` | Order payouts / interest payments | No | — |

Routes are not guarded by authentication middleware (Sanctum is installed; the user endpoint is commented out in `routes/api.php`).

## Request / response examples

### Create a bond

Request `POST /api/bonds`:

```json
{
  "emisia_date": "2021-11-08",
  "turnover_date": "2022-11-08",
  "nominal_price": "100.00",
  "frequency_payment_coupons": "4",
  "period_for_calculating_interest": "360",
  "coupon_interest": 10
}
```

Response `200`:

```json
{
  "bond": {
    "id": 1,
    "emisia_date": "2021-11-08",
    "turnover_date": "2022-11-08",
    "nominal_price": 100.0,
    "frequency_payment_coupons": "4",
    "period_for_calculating_interest": "360",
    "coupon_interest": 10,
    "purchase_orders_count": 0,
    "created_at": "...",
    "updated_at": "..."
  },
  "message": "Bond created successfully"
}
```

### Bond payout dates

`GET /api/bonds/1/payouts`:

```json
{
  "dates": [
    { "date": "2021-12-08" },
    { "date": "2022-01-08" }
  ]
}
```

### Create a purchase order

Request `POST /api/bonds/1/order`:

```json
{
  "order_date": "2021-11-23",
  "number_bonds_received": "30.00"
}
```

Response `200`:

```json
{
  "purchase_order": {
    "id": 1,
    "bond_id": 1,
    "order_date": "2021-11-23",
    "number_bonds_received": 30.0,
    "bond": { ... },
    "created_at": "...",
    "updated_at": "..."
  },
  "message": "Purchase order created successfully"
}
```

### Order payouts

`GET /api/bond/order/1`:

```json
{
  "payouts": [
    { "date": "2021-12-08", "amount": 75.0 },
    { "date": "2022-01-08", "amount": 75.0 }
  ]
}
```

## Validation

### Bond payload (`BondStoreRequest`; `BondUpdateRequest` extends it)

| Field | Rule | Notes |
|-------|------|-------|
| `emisia_date` | required, date_format:Y-m-d | — |
| `turnover_date` | required, date_format:Y-m-d, after_or_equal:emisia_date | — |
| `nominal_price` | required, regex /^\d+(\.\d{1,2})?$/ | decimal |
| `frequency_payment_coupons` | required, in:1,2,4,12 | enum |
| `period_for_calculating_interest` | required, in:360,364,365 | enum |
| `coupon_interest` | required, integer, between:0,100 | percent |

### Order payload (`PurchaseOrderStoreRequest`; `PurchaseOrderUpdateRequest` extends it)

| Field | Rule | Notes |
|-------|------|-------|
| `order_date` | required, date_format:Y-m-d | — |
| `number_bonds_received` | required, regex /^\d+(\.\d{1,2})?$/ | decimal |

Cross-field rule (controller): `order_date` must be between `emisia_date` and `turnover_date`, otherwise `422`.

## Error responses

Validation failures return `422` with Azerbaijani messages:

```json
{
  "bond": { ... },
  "error": "Alış tarixi “Emissiya tarixi”-dən az ola bilməz."
}
```

```json
{
  "error": "Alış tarixi “Son tədavül tarixi”-dən çox ola bilməz."
}
```

Standard Laravel validation errors return `422` with field-level `errors`.

## Related

- Postman collection: https://documenter.getpostman.com/view/1965733/Uz5NiDCK
- Routes: `routes/api.php`
- Controllers: `app/Http/Controllers/API/{BondController,PurchaseOrderController}.php`
