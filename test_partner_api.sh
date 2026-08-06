#!/bin/bash

# Partner API Test Script
# Usage: bash test_partner_api.sh

BASE_URL="https://zerinexpress.com"
API_KEY="pk_j3cphoNr48vXfM4g2fBfJ0ZL"

# JSON pretty print using python if jq is not available
pp() {
  if command -v jq &>/dev/null; then
    jq .
  elif command -v python3 &>/dev/null; then
    python3 -m json.tool
  elif command -v python &>/dev/null; then
    python -m json.tool
  else
    cat
  fi
}

# Extract field from JSON
extract() {
  local field="$1"
  if command -v jq &>/dev/null; then
    jq -r "$field // empty"
  elif command -v python3 &>/dev/null; then
    python3 -c "import sys,json; d=json.load(sys.stdin); print(d.get('data',{}).get('id','') or d.get('data',{}).get('trip_request_id','') or '')"
  elif command -v python &>/dev/null; then
    python -c "import sys,json; d=json.load(sys.stdin); print(d.get('data',{}).get('id','') or d.get('data',{}).get('trip_request_id','') or '')"
  else
    grep -o '"id":"[^"]*"' | head -1 | sed 's/"id":"//;s/"//'
  fi
}

echo "=========================================="
echo "  Partner API Test Script"
echo "  Base URL: $BASE_URL"
echo "  API Key:  $API_KEY"
echo "=========================================="
echo ""

# ==========================================
# 1. POST /api/partner/v1/delivery/quote
# ==========================================
echo ">>> [1/4] POST /api/partner/v1/delivery/quote"
echo "    Testing: Get delivery fare estimate"
echo ""

curl -s -X POST "$BASE_URL/api/partner/v1/delivery/quote" \
  -H "X-API-KEY: $API_KEY" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "pickup_coordinates": ["-6.8235", "39.2695"],
    "destination_coordinates": ["-6.8135", "39.2795"],
    "pickup_address": "Dar es Salaam, Ilala",
    "destination_address": "Dar es Salaam, Kinondoni",
    "parcel_category_id": "00000000-0000-0000-0000-000000000001",
    "weight": 2.5
  }' | pp

echo ""
echo "    ---"
echo ""

# ==========================================
# 2. POST /api/partner/v1/delivery/orders
# ==========================================
echo ">>> [2/4] POST /api/partner/v1/delivery/orders"
echo "    Testing: Create a delivery order"
echo ""

ORDER_RESPONSE=$(curl -s -X POST "$BASE_URL/api/partner/v1/delivery/orders" \
  -H "X-API-KEY: $API_KEY" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "pickup_coordinates": ["-6.8235", "39.2695"],
    "destination_coordinates": ["-6.8135", "39.2795"],
    "pickup_address": "Dar es Salaam, Ilala",
    "destination_address": "Dar es Salaam, Kinondoni",
    "parcel_category_id": "00000000-0000-0000-0000-000000000001",
    "weight": 2.5,
    "payer": "sender",
    "sender_name": "John Doe",
    "sender_phone": "0612345678",
    "sender_address": "Ilala, Dar es Salaam",
    "receiver_name": "Jane Doe",
    "receiver_phone": "0687654321",
    "receiver_address": "Kinondoni, Dar es Salaam"
  }')

echo "$ORDER_RESPONSE" | pp

# Extract order ID from response
ORDER_ID=$(echo "$ORDER_RESPONSE" | extract id)

echo ""
echo "    Order ID: $ORDER_ID"
echo "    ---"
echo ""

# ==========================================
# 3. GET /api/partner/v1/delivery/orders/{id}
# ==========================================
if [ -n "$ORDER_ID" ]; then
  echo ">>> [3/4] GET /api/partner/v1/delivery/orders/$ORDER_ID"
  echo "    Testing: Get order details"
  echo ""

  curl -s -X GET "$BASE_URL/api/partner/v1/delivery/orders/$ORDER_ID" \
    -H "X-API-KEY: $API_KEY" \
    -H "Accept: application/json" | pp

  echo ""
  echo "    ---"
  echo ""
else
  echo ">>> [3/4] GET /api/partner/v1/delivery/orders/{id}"
  echo "    SKIPPED - No order ID from step 2"
  echo ""
fi

# ==========================================
# 4. PUT /api/partner/v1/delivery/orders/{id}/cancel
# ==========================================
if [ -n "$ORDER_ID" ]; then
  echo ">>> [4/4] PUT /api/partner/v1/delivery/orders/$ORDER_ID/cancel"
  echo "    Testing: Cancel the order"
  echo ""

  curl -s -X PUT "$BASE_URL/api/partner/v1/delivery/orders/$ORDER_ID/cancel" \
    -H "X-API-KEY: $API_KEY" \
    -H "Accept: application/json" | pp

  echo ""
  echo "    ---"
  echo ""
else
  echo ">>> [4/4] PUT /api/partner/v1/delivery/orders/{id}/cancel"
  echo "    SKIPPED - No order ID from step 2"
  echo ""
fi

# ==========================================
# 5. GET /api/partner/v1/delivery/orders (list)
# ==========================================
echo ">>> [BONUS] GET /api/partner/v1/delivery/orders"
echo "    Testing: List all orders"
echo ""

curl -s -X GET "$BASE_URL/api/partner/v1/delivery/orders?limit=10&offset=1" \
  -H "X-API-KEY: $API_KEY" \
  -H "Accept: application/json" | pp

echo ""
echo "=========================================="
echo "  Tests complete!"
echo "=========================================="
