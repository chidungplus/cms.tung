@extends('layout::backend.master')

@section('breadcrumb')
    <a class="breadcrumb-item active" href="{{ route('user.index') }}">{{ $display_name }}</a>
    {{-- use lang in file global --}}
@endsection

@section('content')
    <div class="br-section-wrapper">
        {{-- Bg header --}}
        <h6 class="tx-gray-800 tx-uppercase tx-bold tx-18 mg-b-10">
            <i class="fa fa-user-o" aria-hidden="true"></i> &nbsp;
            @lang('global.list') {{ $display_name }}
        </h6>
        <hr> <br>

        {{-- Bg content --}}
        <div class="col-sm-2 col-md-2 pd-0 mg-b-20">
            @permission('user-create')
                <button class="btn btn-info btn-block" onclick="window.location='{{ route('user.create') }}'">
                    <i class="fa fa-plus-circle" aria-hidden="true"></i> &nbsp;
                    @lang('global.add')
                </button>
            @endpermission
        </div>

        <div class="rounded table-responsive">
            <table class="table table-bordered mg-b-0" id="user_table">
                <thead>
                    <tr>
                        <th class="wd-5p">@lang('global.order')</th>
                        <th class="wd-20p">@lang('global.name')</th>
                        <th calss="wd-10p">@lang('global.email')</th>
                        <th class="wd-15p">@lang('global.birthday')</th>
                        <th class="wd-10p">@lang('global.gender')</th>
                        <th class="wd-10p">@lang('global.type')</th>
                        <th class="wd-10p">@lang('global.status')</th>
                        <th class="wd-20p">@lang('global.action')</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ mix('build/js/user/user.js') }}"></script>
@endsection
