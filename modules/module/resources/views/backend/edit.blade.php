@extends('layout::backend.master')

@section('breadcrumb')
    <a class="breadcrumb-item" href="{{ route('module.index') }}">{{$display_name}}</a>
@endsection

@section('content')
    <div class="br-section-wrapper">
        {{-- Bg header --}}
        <h6 class="tx-gray-800 tx-uppercase tx-bold tx-18 mg-b-10">
            <i class="fa fa-pencil-square-o" aria-hidden="true"></i> &nbsp;
            @lang('global.edit') {{ $display_name }}
        </h6>
        <hr> <br>

        {{-- Bg content --}}
        <form action="{{ route('module.update', $module->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" value="PATCH">

            <div class="form-group">
                <label for="" class="tx-bold">@lang('module.module_name')</label>
                <input value="{{ $module->display_name }}" type="text" name="display_name" id="display_name" class="form-control" placeholder="@lang('global.please_enter_content')" required="">
            </div>

            <div class="form-group">
                <label for="" class="tx-bold">@lang('module.note')</label>
                <textarea name="note" id="note" cols="30" rows="5" class="form-control" placeholder="@lang('global.please_enter_content')">{{ $module->note }}</textarea>
            </div>

            <div class="form-group">
                <label for="" class="tx-bold">@lang('module.module_category')</label>
                <select name="module_category_id" id="module_category_id" class="form-control">
                    @if ($module_cates) @foreach($module_cates as $module_cate)
                        <option value="{{$module_cate->id}}" @if ($module->module_category_id == $module_cate->id) selected @endif>  {{ $module_cate->name }}</option>
                    @endforeach @endif
                </select>
            </div>

            <div class="form-group">
                <label for="" class="tx-bold">@lang('global.status')</label>
                <select name="status" id="status" class="form-control">
                    <option value="1" @if($module->status == 1) selected @endif>@lang('global.active')</option>
                    <option value="0" @if($module->status == 0) selected @endif>@lang('global.deactive')</option>
                </select>
            </div>

            <div class="col-sm-1 col-md-1 pd-0">
                <button type="submit" class="btn btn-info btn-block mg-b-20">@lang('global.save_icon')
                     &nbsp;@lang('global.save')</button>
            </div>
        </form>
    </div>
@endsection

@section('script')

@endsection
