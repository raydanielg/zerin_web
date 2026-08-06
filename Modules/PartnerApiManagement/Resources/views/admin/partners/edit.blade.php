@section('title', translate('edit_partner'))

@extends('adminmodule::layouts.master')

@push('css_or_js')
@endpush

@section('content')
    <div class="main-content">
        <div class="container-fluid">
            <div class="row g-4">
                <div class="col-12">
                    <form action="{{ route('admin.partner.update', ['id' => $partner->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card">
                            <div class="card-body">
                                <h5 class="text-primary text-uppercase mb-4">{{ translate('edit_partner') }}</h5>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label for="name" class="mb-2">{{ translate('partner_name') }}</label>
                                            <input required type="text" value="{{old('name', $partner->name)}}"
                                                   id="name" name="name" class="form-control" tabindex="1">
                                        </div>
                                        <div class="mb-4">
                                            <label for="email" class="mb-2">{{ translate('email') }}</label>
                                            <input type="email" value="{{old('email', $partner->email)}}"
                                                   id="email" name="email" class="form-control" tabindex="2">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label for="webhook_url" class="mb-2">{{ translate('webhook_url') }}</label>
                                            <input type="url" value="{{old('webhook_url', $partner->webhook_url)}}"
                                                   id="webhook_url" name="webhook_url" class="form-control"
                                                   placeholder="Ex: https://example.com/webhooks/delivery" tabindex="3">
                                        </div>
                                        <div class="mb-4">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                       id="is_active" name="is_active" value="1"
                                                       {{$partner->is_active ? 'checked' : ''}}>
                                                <label class="form-check-label" for="is_active">{{ translate('active') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end gap-3">
                                    <a href="{{ route('admin.partner.index') }}" class="btn btn-secondary">{{ translate('cancel') }}</a>
                                    <button type="submit" class="btn btn-primary cmn_focus" tabindex="4">{{ translate('update') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
