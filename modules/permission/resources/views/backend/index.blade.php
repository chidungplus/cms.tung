@extends('layout::backend.master')

@section('breadcrumb')
    <a class="breadcrumb-item active" href="{{ route('permission.index') }}">{{$display_name}}</a>
    {{-- use lang in file global --}}
@endsection

@section('content')
    <div class="br-section-wrapper">
        {{-- Bg header --}}
        <h6 class="tx-gray-800 tx-uppercase tx-bold tx-18 mg-b-10">
            <i class="fa fa-paper-plane-o" aria-hidden="true"></i> &nbsp;
            @lang('global.list_permission')
        </h6>
        <hr> <br>

        <div class="rounded table-responsive">
            <table class="table table-bordered mg-b-0" id="permission_table">
                <thead>
                <tr>
                    <th class="wd-5p">@lang('global.order')</th>
                    <th class="wd-25p">@lang('global.name')</th>
                    <th class="wd-30p">@lang('global.display_name')</th>
                    <th class="wd-25p">@lang('global.created_at')</th>
                    {{--<th class="wd-15p">@lang('global.action')</th>--}}
                </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ mix('build/js/permission/permission.js') }}"></script>
@endsection
