@extends('layout::backend.master')

@section('breadcrumb')
    <a class="breadcrumb-item" href="{{ route('role.index') }}">{{ $display_name }}</a>
    <a class="breadcrumb-item active" href="{{ route('role.create') }}">@lang('global.add')</a>
@endsection

@section('content')
    <div class="br-section-wrapper">
        {{-- Bg header --}}
        <h6 class="tx-gray-800 tx-uppercase tx-bold tx-18 mg-b-10">
            <i class="fa fa-plus" aria-hidden="true"></i> &nbsp;
            @lang('global.add') {{ $display_name }}
        </h6>
        <hr> <br>

        {{-- Bg content --}}
        <form action="{{ route('role.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="" class="tx-bold">@lang('global.name')</label>
                <input value="" type="text" name="display_name" id="display_name" class="form-control" placeholder="@lang('global.please_enter_content')" required="">
            </div>

            <div class="form-group">
                <label for="" class="tx-bold">@lang('global.description')</label>
                <textarea name="description" id="description" rows="5" class="form-control" placeholder="@lang('global.please_enter_content')" required=""></textarea>
            </div>

            <div class="col-sm-1 col-md-1 pd-0">
                <button type="submit" class="btn btn-info btn-block mg-b-20"><i class="fa fa-floppy-o" aria-hidden="true"></i> &nbsp;@lang('global.save')</button>
            </div>
        </form>
    </div>
@endsection

@section('script')
@endsection
