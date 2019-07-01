@extends('layout::backend.master')

@section('breadcrumb')
    <a class="breadcrumb-item" href="{{ route('customer.index') }}">{{ $display_name }}</a>
    <a class="breadcrumb-item active" href="{{ route('customer.create') }}">@lang('global.edit')</a>
@endsection

@section('content')
    <div class="br-section-wrapper">
        {{-- Bg header --}}
        <h6 class="tx-gray-800 tx-uppercase tx-bold tx-18 mg-b-10">
            <i class="fa fa-edit" aria-hidden="true"></i> &nbsp;
            @lang('global.edit') {{ $display_name }}
        </h6>
        <hr> <br>

        {{-- Bg content --}}
        <form action="{{ route('customer.update', $customer->id) }}" method="patch" enctype="multipart/form-data" id="frm_edit_customer">
            @csrf

            <input type="hidden" name="customer_id" id="customer_id" value="{{ $customer->id }}">

            <div class="form-group">
                <label for="" class="tx-bold">@lang('user.name')</label>
                <input value="{{ $customer->name }}" type="text" name="name" id="name" class="form-control" placeholder="@lang('user.please_enter_name')" >
            </div>

            <div class="form-group">
                <label for="" class="tx-bold">@lang('user.birthday')</label>
                <input value="{{ $customer->birthday }}" type="text" name="birthday" id="birthday" class="form-control" placeholder="@lang('user.please_enter_birthday')" >
            </div>

            <div class="form-group">
                <label for="" class="tx-bold">@lang('user.email')</label>
                <input disabled="" readonly value="{{ $customer->email }}" type="text" name="" id="" class="form-control" placeholder="@lang('user.please_enter_email')" >
            </div>

            <div class="form-group">
                <label for="" class="tx-bold">@lang('user.mobile')</label>
                <input value="{{ $customer->mobile }}" type="text" name="mobile" id="mobile" class="form-control" placeholder="@lang('user.please_enter_mobile')" >
            </div>

            <div class="form-group">
                <label for="" class="tx-bold">@lang('user.gender')</label>
                <select class="form-control" name="gender" id="gender">
                    <option value="1" @if ($customer->gender == 1) selected @endif>@lang('user.male')</option>
                    <option value="0" @if ($customer->gender == 0) selected @endif>@lang('user.female')</option>
                </select>
            </div>

            <div class="form-group">
                <label for="" class="tx-bold">@lang('user.type')</label>
                <select class="form-control" name="type" id="type">
                    <option value="0" @if ($customer->type == 0) selected @endif>@lang('global.customer_normal')</option>
                    <option value="1" @if ($customer->type == 1) selected @endif>@lang('global.customer_vip')</option>
                </select>
            </div>

            <div class="form-group">
                <label for="" class="tx-bold">@lang('user.status')</label>
                <select class="form-control" name="status" id="status">
                    <option value="1" @if ($customer->status == 1) selected @endif>@lang('global.active')</option>
                    <option value="0" @if ($customer->status == 0) selected @endif>@lang('global.deactive')</option>
                </select>
            </div>

            <div class="col-sm-1 col-md-1 pd-0">
                <button type="submit" class="btn btn-info btn-block mg-b-20" id="btn-update">@lang('global.save_icon') &nbsp;@lang('global.save')</button>
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script src="{{ mix('build/js/customer/customer.js') }}"></script>
@endsection
