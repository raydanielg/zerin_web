# Partner Delivery API

Public/partner-facing API that lets external systems (shops, e-commerce
platforms, other apps) create delivery orders, get fare quotes, track order
status and receive webhook notifications — without needing a customer login
inside the Drivemond apps. It reuses the same zone/fare/discount engine as
the customer app (`Modules/TripManagement`, `Modules/ParcelManagement`,
`Modules/FareManagement`), so pricing stays consistent everywhere.

## 1. Run the migration

```
php artisan module:migrate PartnerApiManagement
```

## 2. Create a partner (issues API key + secret)

```
php artisan partner:create "Acme Shop" acme@example.com --phone=255700000000 --webhook=https://acme.example.com/webhooks/delivery
```

This prints an **API Key**, **API Secret** and **Webhook Secret**. Store them
safely — the secret and webhook secret are shown only once (the secret is
stored hashed, the webhook secret is stored so it can be used to sign
outgoing webhooks).

## 3. Authentication

Every request must include:

```
X-API-KEY: <api_key>
X-API-SECRET: <api_secret>
```

## 4. Endpoints (base path: `/api/partner/v1/delivery`)

| Method | Path | Description |
|---|---|---|
| POST | `/quote` | Get an estimated fare for a pickup/destination + parcel category/weight |
| POST | `/orders` | Create a delivery order |
| GET  | `/orders` | List the partner's delivery orders |
| GET  | `/orders/{id}` | Get a single order's details/status |
| PUT  | `/orders/{id}/cancel` | Cancel an order (only while `pending`/`accepted`) |

### POST /quote

```json
{
  "pickup_coordinates": [lat, lng],
  "destination_coordinates": [lat, lng],
  "pickup_address": "...",
  "destination_address": "...",
  "parcel_category_id": "uuid",
  "weight": 2.5
}
```

### POST /orders

```json
{
  "pickup_coordinates": [lat, lng],
  "destination_coordinates": [lat, lng],
  "pickup_address": "...",
  "destination_address": "...",
  "parcel_category_id": "uuid",
  "weight": 2.5,
  "payer": "sender",
  "sender_name": "...",
  "sender_phone": "...",
  "sender_address": "...",
  "receiver_name": "...",
  "receiver_phone": "...",
  "receiver_address": "..."
}
```

The fare is always recomputed server-side from the live fare/zone/discount
configuration; any fare sent by the client is ignored.

## 5. Webhooks

When an order's status changes (accepted, out for pickup, ongoing,
completed, cancelled, etc.) a `POST` request is sent to the partner's
`webhook_url`:

```json
{
  "event": "delivery.status_updated",
  "order_id": "uuid",
  "reference": 100123,
  "status": "accepted",
  "driver_id": "uuid",
  "updated_at": "2025-01-01T10:00:00+00:00"
}
```

Header `X-Webhook-Signature` contains `hash_hmac('sha256', <raw body>, <webhook_secret>)`
so the partner can verify authenticity.

## Notes

- Underlying identity: each partner is backed by a normal `customer` user
  record (`Modules\UserManagement\Entities\User`), created automatically by
  `partner:create`. All orders/discounts/coupons behave exactly as they
  would for a regular customer of that account.
- To regenerate OpenAPI/Postman docs including these routes, re-run the
  project's existing `generate_api_docs.php` / `generate_openapi_postman.py`
  scripts after enabling this module.
