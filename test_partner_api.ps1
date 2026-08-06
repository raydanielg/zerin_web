# Partner API Test Script (PowerShell)
# Usage: .\test_partner_api.ps1

$BaseUrl = "https://zerinexpress.com"
$ApiKey  = "pk_j3cphoNr48vXfM4g2fBfJ0ZL"

$headers = @{
    "X-API-KEY"   = $ApiKey
    "Accept"      = "application/json"
}

Write-Host "==========================================" -ForegroundColor Cyan
Write-Host "  Partner API Test Script" -ForegroundColor Cyan
Write-Host "  Base URL: $BaseUrl" -ForegroundColor Cyan
Write-Host "  API Key:  $ApiKey" -ForegroundColor Cyan
Write-Host "==========================================" -ForegroundColor Cyan
Write-Host ""

# ==========================================
# 1. POST /api/partner/v1/delivery/quote
# ==========================================
Write-Host ">>> [1/4] POST /api/partner/v1/delivery/quote" -ForegroundColor Yellow
Write-Host "    Testing: Get delivery fare estimate"
Write-Host ""

$quoteBody = @{
    pickup_coordinates       = @(-6.8235, 39.2695)
    destination_coordinates  = @(-6.8135, 39.2795)
    pickup_address           = "Dar es Salaam, Ilala"
    destination_address      = "Dar es Salaam, Kinondoni"
    parcel_category_id       = "00000000-0000-0000-0000-000000000001"
    weight                   = 2.5
} | ConvertTo-Json -Depth 3

$quoteHeaders = $headers.Clone()
$quoteHeaders["Content-Type"] = "application/json"

try {
    $quoteRes = Invoke-RestMethod -Uri "$BaseUrl/api/partner/v1/delivery/quote" -Method POST -Headers $quoteHeaders -Body $quoteBody
    $quoteRes | ConvertTo-Json -Depth 10
} catch {
    Write-Host "ERROR: $($_.Exception.Message)" -ForegroundColor Red
    if ($_.ErrorDetails) { Write-Host $_.ErrorDetails.Message -ForegroundColor Red }
}

Write-Host ""
Write-Host "    ---"
Write-Host ""

# ==========================================
# 2. POST /api/partner/v1/delivery/orders
# ==========================================
Write-Host ">>> [2/4] POST /api/partner/v1/delivery/orders" -ForegroundColor Yellow
Write-Host "    Testing: Create a delivery order"
Write-Host ""

$orderBody = @{
    pickup_coordinates       = @(-6.8235, 39.2695)
    destination_coordinates  = @(-6.8135, 39.2795)
    pickup_address           = "Dar es Salaam, Ilala"
    destination_address      = "Dar es Salaam, Kinondoni"
    parcel_category_id       = "00000000-0000-0000-0000-000000000001"
    weight                   = 2.5
    payer                    = "sender"
    sender_name              = "John Doe"
    sender_phone             = "0612345678"
    sender_address           = "Ilala, Dar es Salaam"
    receiver_name            = "Jane Doe"
    receiver_phone           = "0687654321"
    receiver_address         = "Kinondoni, Dar es Salaam"
} | ConvertTo-Json -Depth 3

$orderId = $null

try {
    $orderRes = Invoke-RestMethod -Uri "$BaseUrl/api/partner/v1/delivery/orders" -Method POST -Headers $quoteHeaders -Body $orderBody
    $orderRes | ConvertTo-Json -Depth 10
    $orderId = $orderRes.data.id
    if (-not $orderId) { $orderId = $orderRes.data.trip_request_id }
} catch {
    Write-Host "ERROR: $($_.Exception.Message)" -ForegroundColor Red
    if ($_.ErrorDetails) { Write-Host $_.ErrorDetails.Message -ForegroundColor Red }
}

Write-Host ""
Write-Host "    Order ID: $orderId"
Write-Host "    ---"
Write-Host ""

# ==========================================
# 3. GET /api/partner/v1/delivery/orders/{id}
# ==========================================
if ($orderId) {
    Write-Host ">>> [3/4] GET /api/partner/v1/delivery/orders/$orderId" -ForegroundColor Yellow
    Write-Host "    Testing: Get order details"
    Write-Host ""

    try {
        $showRes = Invoke-RestMethod -Uri "$BaseUrl/api/partner/v1/delivery/orders/$orderId" -Method GET -Headers $headers
        $showRes | ConvertTo-Json -Depth 10
    } catch {
        Write-Host "ERROR: $($_.Exception.Message)" -ForegroundColor Red
        if ($_.ErrorDetails) { Write-Host $_.ErrorDetails.Message -ForegroundColor Red }
    }

    Write-Host ""
    Write-Host "    ---"
    Write-Host ""
} else {
    Write-Host ">>> [3/4] SKIPPED - No order ID from step 2"
    Write-Host ""
}

# ==========================================
# 4. PUT /api/partner/v1/delivery/orders/{id}/cancel
# ==========================================
if ($orderId) {
    Write-Host ">>> [4/4] PUT /api/partner/v1/delivery/orders/$orderId/cancel" -ForegroundColor Yellow
    Write-Host "    Testing: Cancel the order"
    Write-Host ""

    try {
        $cancelRes = Invoke-RestMethod -Uri "$BaseUrl/api/partner/v1/delivery/orders/$orderId/cancel" -Method PUT -Headers $headers
        $cancelRes | ConvertTo-Json -Depth 10
    } catch {
        Write-Host "ERROR: $($_.Exception.Message)" -ForegroundColor Red
        if ($_.ErrorDetails) { Write-Host $_.ErrorDetails.Message -ForegroundColor Red }
    }

    Write-Host ""
    Write-Host "    ---"
    Write-Host ""
} else {
    Write-Host ">>> [4/4] SKIPPED - No order ID from step 2"
    Write-Host ""
}

# ==========================================
# 5. GET /api/partner/v1/delivery/orders (list)
# ==========================================
Write-Host ">>> [BONUS] GET /api/partner/v1/delivery/orders" -ForegroundColor Yellow
Write-Host "    Testing: List all orders"
Write-Host ""

try {
    $listRes = Invoke-RestMethod -Uri "$BaseUrl/api/partner/v1/delivery/orders?limit=10&offset=1" -Method GET -Headers $headers
    $listRes | ConvertTo-Json -Depth 10
} catch {
    Write-Host "ERROR: $($_.Exception.Message)" -ForegroundColor Red
    if ($_.ErrorDetails) { Write-Host $_.ErrorDetails.Message -ForegroundColor Red }
}

Write-Host ""
Write-Host "==========================================" -ForegroundColor Cyan
Write-Host "  Tests complete!" -ForegroundColor Cyan
Write-Host "==========================================" -ForegroundColor Cyan
