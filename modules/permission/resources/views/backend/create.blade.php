@extends('layout::backend.master')

@section('breadcrumb')
    <a class="breadcrumb-item" href="{{ route('permission.index') }}">Permission</a>
    <a class="breadcrumb-item active" href="{{ route('module.create') }}">@lang('global.add')</a>
@endsection

@section('content')
    <div class="br-section-wrapper">
        {{-- Bg header --}}
        <h6 class="tx-gray-800 tx-uppercase tx-bold tx-18 mg-b-10">
            <i class="menu-item-icon icon ion-ios-pricetag-outline tx-20 mg-r-5"></i>
            @lang('global.add')
        </h6>
        <hr> <br>

        {{-- Bg content --}}
        <form action="{{ route('permission.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="" class="tx-bold">@lang('global.name')</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="@lang('global.please_enter_content')" required="">
            </div>

            <div class="form-group">
                <label for="" class="tx-bold">@lang('global.content')</label>
                <textarea name="content" id="content" rows="5" class="form-control" placeholder="@lang('global.please_enter_content')" required=""></textarea>
            </div>

            <div class="form-group">
                <label for="" class="tx-bold">@lang('global.status')</label>
                <select class="form-control" name="status" id="status">
                    <option value="1">@lang('global.show')</option>
                    <option value="0">@lang('global.hide')</option>
                </select>
            </div>

            <div class="col-sm-2 col-md-2 pd-0">
                <button type="submit" class="btn btn-info btn-block mg-b-20">@lang('global.save')</button>
            </div>
        </form>
    </div>
@endsection

@section('script')
@endsection
