@extends('layout::backend.master')

@section('breadcrumb')
    <a class="breadcrumb-item" href="{{ route('user.index') }}">{{ $display_name }}</a>
    <a class="breadcrumb-item active" href="{{ route('user.roleUser', $user->id) }}">@lang('global.role')</a>
    {{-- use lang in file global --}}
@endsection

@section('content')
    <div class="br-section-wrapper">
        {{-- Bg header --}}
        <h6 class="tx-gray-800 tx-uppercase tx-bold tx-18 mg-b-10">
            <i class="fa fa-user-o" aria-hidden="true"></i> &nbsp;
            @lang('global.list') @lang('global.role')
        </h6>
        <hr> <br>

        <div class="rounded table-responsive">

            <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}">

            <table class="table table-bordered mg-b-0" id="role_user_table">
                <thead>
                <tr>
                    <th class="wd-5p">@lang('global.order')</th>
                    <th class="wd-25p">@lang('global.display_name')</th>
                    <th class="wd-15p">@lang('global.description')</th>
                    <th class="wd-10p">@lang('global.created_at')</th>
                    <th class="wd-25p">@lang('global.action')</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ mix('build/js/user/user.js') }}"></script>
@endsection
