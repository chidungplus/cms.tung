@extends('layout::backend.master')

@section('breadcrumb')
    <a class="breadcrumb-item active" href="{{ route('module.index') }}">{{$display_name}}</a>
@endsection

@section('content')
    <div class="br-section-wrapper">
        {{-- Bg header --}}
        <h6 class="tx-gray-800 tx-uppercase tx-bold tx-18 mg-b-10">
            <i class="fa fa-folder-o" aria-hidden="true"></i> &nbsp;
            @lang('global.list') {{ $display_name }}
        </h6>
        <hr> <br>

        {{-- Bg content --}}
        {{--<div class="col-sm-1 col-md-1 pd-0 ">--}}
            {{--<button class="btn btn-info btn-block mg-b-20" onclick="window.location='{{ route('module.create') }}'">--}}
                {{--<i class="fa fa-plus-circle" aria-hidden="true"></i> &nbsp;--}}
                {{--@lang('global.add')--}}
            {{--</button>--}}
        {{--</div>--}}

        <div class="rounded table-responsive">
            <table class="table table-bordered mg-b-0" id="modules_table">
                <thead>
                    <tr>
                        <th class="wd-4p">@lang('global.order')</th>
                        <th class="wd-20p">@lang('module.module_name')</th>
                        <th class="wd-15p">@lang('module.module_category')</th>
                        <th class="wd-15p">@lang('module.note')</th>
                        <th class="wd-10p">@lang('global.status')</th>
                        <th class="wd-15p">@lang('global.created_at')</th>
                        <th class="wd-16p">@lang('global.action')</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ mix('build/js/module/module.js') }}"></script>
@endsection
