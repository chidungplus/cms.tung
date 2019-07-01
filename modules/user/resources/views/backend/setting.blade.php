@extends('layout::backend.master')

@section('breadcrumb')
    <a class="breadcrumb-item" href="{{ route('user.index') }}">{{ $display_name }}</a>
    <a class="breadcrumb-item active" href="{{ route('user.create') }}">Đổi mật khẩu</a>
@endsection

@section('content')
    <div class="br-section-wrapper">
        {{-- Bg header --}}
        <h6 class="tx-gray-800 tx-uppercase tx-bold tx-18 mg-b-10">
            <i class="fa fa-share" aria-hidden="true"></i> &nbsp;
            Đổi mật khẩu
        </h6>
        <hr> <br>

        {{-- Bg content --}}
        <form action="{{ route('user.profile') }}" method="post" enctype="multipart/form-data" id="frm_change_pw">
            @csrf

            <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}">

            <div class="form-group">
                <label for="" class="tx-bold">Mật khẩu cũ</label>
                <input value="" type="password" name="current_password" id="current_password" class="form-control" placeholder="Vui lòng nhập mật khẩu hiện tại" >
            </div>

            <div class="form-group">
                <label for="" class="tx-bold">Mật khẩu mới</label>
                <input value="" type="password" name="password" id="password" class="form-control" placeholder="Vui lòng nhập mật khẩu mới" >
            </div>

            <div class="form-group">
                <label for="" class="tx-bold">Mật khẩu xác nhận</label>
                <input value="" type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Vui lòng nhập mật khẩu xác nhận" >
            </div>

            <div class="col-sm-1 col-md-1 pd-0">
                <button type="submit" class="btn btn-info btn-block mg-b-20">@lang('global.save_icon') &nbsp;@lang('global.save')</button>
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script src="{{ mix('build/js/user/user.js') }}"></script>
@endsection
