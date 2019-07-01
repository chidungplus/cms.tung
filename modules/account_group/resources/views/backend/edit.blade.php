@extends('layout::backend.master')

@section('breadcrumb')
    <a class="breadcrumb-item" href="{{ route('account_group.index') }}">{{ $display_name }}</a>
    <a class="breadcrumb-item active" href="{{ route('account_group.create') }}">@lang('global.edit')</a>
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
        <form action="{{ route('account_group.update', $account_group->id) }}" method="post" enctype="multipart/form-data" id="frm_edit_account_group">
            @csrf
            <input type="hidden" name="_method" value="PATCH">
            <input type="hidden" name="account_group_id" id="account_group_id" value="{{ $account_group->id }}">

            <div class="form-group">
                <label for="" class="tx-bold">@lang('global.name')</label>
                <input value="{{ $account_group->name }}" type="text" name="name" id="name" class="form-control" placeholder="@lang('global.please_enter_content')" required="">
            </div>

            <div class="form-group">
                <label for="" class="tx-bold">@lang('global.content')</label>
                <textarea name="content" id="content" rows="5" class="form-control" placeholder="@lang('global.please_enter_content')" required="">{{ $account_group->content }}</textarea>
            </div>

            <div class="form-group">
                <label for="" class="tx-bold">@lang('global.status')</label>
                <select class="form-control" name="status" id="status">
                    <option value="1" @if($account_group->status == 1) selected @endif>@lang('global.show')</option>
                    <option value="0" @if($account_group->status == 0) selected @endif>@lang('global.hide')</option>
                </select>
            </div>

            <div class="col-sm-1 col-md-1 pd-0">
                <button type="submit" class="btn btn-info btn-block mg-b-20" id="btn-create"><i class="fa fa-floppy-o" aria-hidden="true"></i> &nbsp;@lang('global.save')</button>
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script>
        $('#frm_edit_account_group').on('submit', function (event) {
            event.preventDefault();

            var form = $('#frm_edit_account_group');

            $('span[class=error]').remove();

            if (!form.valid()) {
                return false;
            }

            updateAccountGroup(form.serialize());
        });

        $('#frm_edit_account_group').validate({
            errorElement: "span",
            rules: {
                name: {
                    required: true
                },
                content: {
                    required: true
                }
            },
            messages: {
                name: {
                    required: Lang.get('global.please_enter_content')
                },
                content: {
                    required: Lang.get('global.please_enter_content')
                }
            },
        });

        function updateAccountGroup(data) {
            $.ajax({
                url: app_url + 'admin/account_group/' + $('#user_id').val(),
                type: 'PATCH', // GET, POST, PUT, PATCH, DELETE,
                data: {
                    data: data
                },
                success: function (res)
                {
                    if (!res.err) {
                        toastr.success(res.msg);

                        setTimeout(function () {
                            window.location.href = app_url + 'admin/account_group';
                        }, 2000);

                        $('#btn-update').attr("disabled", "disabled");
                    } else {
                        toastr.error(res.msg);
                    }
                }
            });
        }
    </script>
@endsection
