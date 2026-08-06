@section('title', translate('partner_management'))

@extends('adminmodule::layouts.master')

@push('css_or_js')
@endpush

@section('content')
    <div class="main-content">
        <div class="container-fluid">
            <div class="row g-4">
                <div class="col-12">
                    <h2 class="fs-22 text-capitalize">{{ translate('partner_list') }}</h2>

                    <div class="d-flex flex-wrap justify-content-between align-items-center my-3 gap-3">
                        <ul class="nav nav--tabs p-1 rounded bg-white" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link {{!request()->has('status') || request()->get('status')==='all'?'active':''}}"
                                   href="{{url()->current()}}?status=all">
                                    {{ translate('all') }}
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link {{request()->get('status')=='active'?'active':''}}"
                                   href="{{url()->current()}}?status=active">
                                    {{ translate('active') }}
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link {{request()->get('status')=='inactive'?'active':''}}"
                                   href="{{url()->current()}}?status=inactive">
                                    {{ translate('inactive') }}
                                </a>
                            </li>
                        </ul>

                        <div class="d-flex align-items-center gap-2">
                            <span class="text-muted text-capitalize">{{ translate('total_partners') }} : </span>
                            <span class="text-primary fs-16 fw-bold" id="total_record_count">{{ $partners->total() }}</span>

                            @can('partner_add')
                                <a href="{{ route('admin.partner.create') }}" class="btn btn-primary">
                                    <i class="bi bi-plus-lg"></i> {{ translate('add_new_partner') }}
                                </a>
                            @endcan
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="table-top d-flex flex-wrap gap-10 justify-content-between">
                                <form action="javascript:;" class="search-form search-form_style-two" method="GET">
                                    <div class="input-group search-form__input_group">
                                        <span class="search-form__icon">
                                            <i class="bi bi-search"></i>
                                        </span>
                                        <input type="search" class="theme-input-style search-form__input"
                                               value="{{request()->get('search')}}" name="search" id="search"
                                               placeholder="{{translate('search_by_name_email_or_api_key')}}" tabindex="1">
                                    </div>
                                    <button type="submit" class="btn btn-primary search-submit"
                                            data-url="{{url()->full()}}" tabindex="2">{{ translate('search') }}</button>
                                </form>
                            </div>

                            <div class="table-responsive mt-3 text-center">
                                <table class="table table-borderless align-middle">
                                    <thead class="table-light align-middle">
                                    <tr>
                                        <th>{{ translate('SL') }}</th>
                                        <th class="text-capitalize">{{ translate('partner_name') }}</th>
                                        <th class="text-capitalize">{{ translate('email') }}</th>
                                        <th class="text-capitalize">{{ translate('api_key') }}</th>
                                        <th class="text-capitalize">{{ translate('webhook_url') }}</th>
                                        @can('partner_edit')
                                            <th class="status">{{ translate('status') }}</th>
                                        @endcan
                                        <th class="text-center action">{{ translate('action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse ($partners as $key => $partner)
                                        <tr id="hide-row-{{$partner->id}}" class="record-row">
                                            <td>{{ $partners->firstItem() + $key }}</td>
                                            <td>{{ $partner->name }}</td>
                                            <td>{{ $partner->email ?? '-' }}</td>
                                            <td><code>{{ $partner->api_key }}</code></td>
                                            <td>
                                                @if($partner->webhook_url)
                                                    <span class="text-truncate d-inline-block" style="max-width:200px" title="{{ $partner->webhook_url }}">
                                                        {{ $partner->webhook_url }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            @can('partner_edit')
                                                <td class="status">
                                                    <label class="switcher mx-auto">
                                                        <input class="switcher_input status-change"
                                                               data-url="{{ route('admin.partner.status') }}"
                                                               id="{{ $partner->id }}"
                                                               type="checkbox"
                                                               {{$partner->is_active?'checked':''}}>
                                                        <span class="switcher_control"></span>
                                                    </label>
                                                </td>
                                            @endcan
                                            <td class="action">
                                                <div class="d-flex justify-content-center gap-2 align-items-center">
                                                    @can('partner_view')
                                                        <a href="{{route('admin.partner.show', ['id'=>$partner->id])}}"
                                                           class="btn btn-outline-info btn-action" data-bs-toggle="tooltip"
                                                           data-bs-title="{{ translate('view_details') }}">
                                                            <i class="bi bi-eye-fill"></i>
                                                        </a>
                                                    @endcan
                                                    @can('partner_edit')
                                                        <a href="{{route('admin.partner.edit', ['id'=>$partner->id])}}"
                                                           class="btn btn-outline-info btn-action" data-bs-toggle="tooltip"
                                                           data-bs-title="{{ translate('edit') }}">
                                                            <i class="bi bi-pencil-fill"></i>
                                                        </a>
                                                    @endcan
                                                    @can('partner_delete')
                                                        <button data-id="delete-{{ $partner->id }}"
                                                                data-message="{{ translate('want_to_delete_this_partner?') }}"
                                                                type="button"
                                                                class="btn btn-outline-danger btn-action form-alert">
                                                            <i class="bi bi-trash-fill"></i>
                                                        </button>
                                                        <form action="{{ route('admin.partner.delete', ['id'=>$partner->id]) }}"
                                                              id="delete-{{ $partner->id }}" method="post">
                                                            @csrf
                                                            @method('delete')
                                                        </form>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7">
                                                <div class="d-flex flex-column justify-content-center align-items-center gap-2 py-3">
                                                    <img src="{{ dynamicAsset('public/assets/admin-module/img/empty-icons/no-data-found.svg') }}"
                                                         alt="" width="100">
                                                    <p class="text-center">{{translate('no_data_available')}}</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-end">
                                {!! $partners->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
