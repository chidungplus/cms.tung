@extends('layout::backend.master')

@section('breadcrumb')
    <a class="breadcrumb-item" href="{{ route('user.index') }}">{{ $display_name }}</a>
    <a class="breadcrumb-item active" href="{{ route('user.create') }}">@lang('global.add')</a>
@endsection

@section('content')
    <div class="br-section-wrapper">
        {{-- Bg header --}}
        <h6 class="tx-gray-800 tx-uppercase tx-bold tx-18 mg-b-10">
            <i class="fa fa-user-plus" aria-hidden="true"></i> &nbsp;
            @lang('global.add') {{ $display_name }}
        </h6>
        <hr> <br>

        {{-- Bg content --}}
        <form action="{{ route('user.store') }}" method="post" enctype="multipart/form-data" id="frm_create_user">
            @csrf
            <div class="form-group">
                <label for="" class="tx-bold">@lang('user.name')</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="@lang('user.please_enter_name')" >
            </div>

            <div class="form-group">
                <label for="" class="tx-bold">@lang('user.birthday')</label>
                <input type="text" name="birthday" id="birthday" class="form-control" placeholder="@lang('user.please_enter_birthday')" >
            </div>

            <div class="form-group">
                <label for="" class="tx-bold">@lang('user.email')</label>
                <input type="text" name="email" id="email" class="form-control" placeholder="@lang('user.please_enter_email')" >
            </div>

            <div class="form-group">
                <label for="" class="tx-bold">@lang('user.mobile')</label>
                <input type="text" name="mobile" id="mobile" class="form-control" placeholder="@lang('user.please_enter_mobile')" >
            </div>

            <div class="form-group">
                <label for="" class="tx-bold">@lang('user.gender')</label>
                <select class="form-control" name="gender" id="gender">
                    <option value="1">@lang('user.male')</option>
                    <option value="0">@lang('user.female')</option>
                </select>
            </div>

            <div class="form-group">
                <label for="" class="tx-bold">@lang('user.type')</label>
                <select class="form-control" name="type" id="type">
                    <option value="0">User</option>
                    <option value="1">Admin</option>
                </select>
            </div>

            <div class="form-group">
                <label for="" class="tx-bold">@lang('user.status')</label>
                <select class="form-control" name="status" id="status">
                    <option value="1">@lang('global.active')</option>
                    <option value="0">@lang('global.deactive')</option>
                </select>
            </div>

            <div class="col-sm-1 col-md-1 pd-0">
                <button type="submit" class="btn btn-info btn-block mg-b-20" id="btn-create">@lang('global.save_icon') &nbsp;@lang('global.save')</button>
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script src="{{ mix('build/js/user/user.js') }}"></script>
@endsection
