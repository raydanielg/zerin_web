@section('title', translate('partner_details'))

@extends('adminmodule::layouts.master')

@push('css_or_js')
@endpush

@section('content')
    <div class="main-content">
        <div class="container-fluid">
            <div class="row g-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="text-primary text-uppercase mb-0">{{ translate('partner_details') }}</h5>
                                <div class="d-flex gap-2">
                                    @can('partner_edit')
                                        <a href="{{ route('admin.partner.edit', $partner->id) }}" class="btn btn-outline-info btn-action">
                                            <i class="bi bi-pencil-fill"></i> {{ translate('edit') }}
                                        </a>
                                    @endcan
                                    <a href="{{ route('admin.partner.index') }}" class="btn btn-secondary">{{ translate('back') }}</a>
                                </div>
                            </div>

                            @if(session('api_secret') || session('webhook_secret'))
                                <div class="alert alert-warning">
                                    <i class="bi bi-exclamation-triangle-fill"></i>
                                    {{ translate('save_credentials_now_warning') }}
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td class="text-muted fw-bold" style="width:180px">{{ translate('partner_name') }}</td>
                                            <td>{{ $partner->name }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted fw-bold">{{ translate('email') }}</td>
                                            <td>{{ $partner->email ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted fw-bold">{{ translate('status') }}</td>
                                            <td>
                                                @if($partner->is_active)
                                                    <span class="badge bg-success">{{ translate('active') }}</span>
                                                @else
                                                    <span class="badge bg-danger">{{ translate('inactive') }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted fw-bold">{{ translate('linked_customer_id') }}</td>
                                            <td><code>{{ $partner->customer_id }}</code></td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted fw-bold">{{ translate('created_at') }}</td>
                                            <td>{{ $partner->created_at?->format('Y-m-d H:i:s') }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td class="text-muted fw-bold" style="width:180px">{{ translate('api_key') }}</td>
                                            <td><code>{{ $partner->api_key }}</code></td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted fw-bold">{{ translate('api_secret') }}</td>
                                            <td>
                                                @if($apiSecret)
                                                    <code class="text-danger">{{ $apiSecret }}</code>
                                                @else
                                                    <span class="text-muted">{{ translate('hidden_for_security') }}</span>
                                                    @can('partner_edit')
                                                        <form action="{{ route('admin.partner.regenerate-secret', $partner->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-outline-warning btn-sm ms-2"
                                                                    onclick="return confirm('{{ translate('regenerate_api_secret_confirm') }}')">
                                                                <i class="bi bi-arrow-repeat"></i> {{ translate('regenerate') }}
                                                            </button>
                                                        </form>
                                                    @endcan
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted fw-bold">{{ translate('webhook_url') }}</td>
                                            <td>{{ $partner->webhook_url ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted fw-bold">{{ translate('webhook_secret') }}</td>
                                            <td>
                                                @if($webhookSecret)
                                                    <code class="text-danger">{{ $webhookSecret }}</code>
                                                @else
                                                    <span class="text-muted">{{ translate('hidden_for_security') }}</span>
                                                    @can('partner_edit')
                                                        <form action="{{ route('admin.partner.regenerate-webhook-secret', $partner->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-outline-warning btn-sm ms-2"
                                                                    onclick="return confirm('{{ translate('regenerate_webhook_secret_confirm') }}')">
                                                                <i class="bi bi-arrow-repeat"></i> {{ translate('regenerate') }}
                                                            </button>
                                                        </form>
                                                    @endcan
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="mt-4">
                                <h6 class="text-primary text-uppercase">{{ translate('webhook_info') }}</h6>
                                <div class="alert alert-light border">
                                    <p class="mb-1"><strong>{{ translate('webhook_header') }}:</strong> <code>X-Webhook-Signature</code></p>
                                    <p class="mb-1"><strong>{{ translate('signature_algorithm') }}:</strong> HMAC-SHA256</p>
                                    <p class="mb-0"><strong>{{ translate('payload_example') }}:</strong></p>
                                    <pre class="bg-light p-3 rounded mt-1"><code>{
  "event": "delivery.status_updated",
  "order_id": "uuid",
  "reference": "100123",
  "status": "accepted",
  "driver_id": "uuid",
  "updated_at": "2025-01-01T10:00:00+00:00"
}</code></pre>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
