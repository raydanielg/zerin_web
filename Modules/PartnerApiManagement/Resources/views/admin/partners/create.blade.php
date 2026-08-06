@section('title', translate('add_new_partner'))

@extends('adminmodule::layouts.master')

@push('css_or_js')
@endpush

@section('content')
    <div class="main-content">
        <div class="container-fluid">
            <div class="row g-4">
                <div class="col-12">
                    <form action="{{ route('admin.partner.store') }}" method="POST">
                        @csrf
                        <div class="card">
                            <div class="card-body">
                                <h5 class="text-primary text-uppercase mb-4">{{ translate('add_new_partner') }}</h5>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label for="name" class="mb-2">{{ translate('partner_name') }}</label>
                                            <input required type="text" value="{{old('name')}}"
                                                   id="name" name="name" class="form-control"
                                                   placeholder="Ex: Acme Shop" tabindex="1">
                                        </div>
                                        <div class="mb-4">
                                            <label for="email" class="mb-2">{{ translate('email') }}</label>
                                            <input type="email" value="{{old('email')}}"
                                                   id="email" name="email" class="form-control"
                                                   placeholder="Ex: partner@example.com" tabindex="2">
                                        </div>
                                        <div class="mb-4">
                                            <label for="phone" class="mb-2">{{ translate('phone') }}</label>
                                            <input type="text" value="{{old('phone')}}"
                                                   id="phone" name="phone" class="form-control"
                                                   placeholder="Ex: 255700000000" tabindex="3">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label for="webhook_url" class="mb-2">{{ translate('webhook_url') }}</label>
                                            <input type="url" value="{{old('webhook_url')}}"
                                                   id="webhook_url" name="webhook_url" class="form-control"
                                                   placeholder="Ex: https://example.com/webhooks/delivery" tabindex="4">
                                            <small class="text-muted">{{ translate('webhook_url_description') }}</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle"></i>
                                    {{ translate('partner_create_notice') }}
                                </div>

                                <div class="d-flex justify-content-end gap-3">
                                    <a href="{{ route('admin.partner.index') }}" class="btn btn-secondary">{{ translate('cancel') }}</a>
                                    <button type="submit" class="btn btn-primary cmn_focus" tabindex="5">{{ translate('submit') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
