@extends('layout::backend.master')

@section('breadcrumb')
    <a class="breadcrumb-item" href="{{ route('account_group.index') }}">{{ $display_name }}</a>
    <a class="breadcrumb-item" href="{{ route('account_group.listAccount', $groups->id) }}">{{ ucfirst($groups->name) }}</a>
    <a class="breadcrumb-item active" href="#">Thêm tài khoản vào nhóm</a>
@endsection

@section('content')
    <div class="br-section-wrapper">
        {{-- Bg header --}}
        <h6 class="tx-gray-800 tx-uppercase tx-bold tx-18 mg-b-10">
            <i class="fa fa-plus" aria-hidden="true"></i> &nbsp;
            Thêm tài khoản vào nhóm
        </h6>
        <hr> <br>

        {{-- Bg content --}}
        <form action="{{ route('account.store') }}" method="post" enctype="multipart/form-data" id="frm_create_account">
            @csrf

            <input type="hidden" id="group_id" value="{{ $groups->id }}">

            <div class="form-group">
                <label for="" class="tx-bold">Nhóm tài khoản</label>
                <select class="form-control" name="group_account_id" id="group_account_id">
                    @if ( isset($groups))
                        <option value="{{ $groups->id }}">{{ $groups->name }}</option>
                    @endif
                </select>
            </div>

            <div class="form-group">
                <label for="" class="tx-bold">Danh sách tài khoản</label>
                <textarea name="accounts" id="accounts" rows="10" class="form-control" placeholder="@lang('global.please_enter_content')"></textarea>
            </div>

            <span>VD: abcd1234|09999</span>

            <div class="col-sm-1 col-md-1 pd-0 mg-t-20">
                <button type="submit" class="btn btn-info btn-block mg-b-20" id="btn-create"><i class="fa fa-floppy-o" aria-hidden="true"></i> &nbsp;@lang('global.save')</button>
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script>
        $('#frm_create_account').on('submit', function (event) {
            event.preventDefault();

            var form = $('#frm_create_account');

            $('span[class=error]').remove();

            if (!form.valid()) {
                return false;
            }

            createAccount(form.serialize());
        });

        $('#frm_create_account').validate({
            errorElement: "span",
            rules: {
                group_account_id: {
                    required: true
                },
                accounts: {
                    required: true
                }
            },
            messages: {
                group_account_id: {
                    required: Lang.get('global.please_enter_content')
                },
                accounts: {
                    required: Lang.get('global.please_enter_content')
                }
            },
        });

        function createAccount(data) {
            $.ajax({
                url: app_url + 'admin/account',
                type: 'POST', // GET, POST, PUT, PATCH, DELETE,
                data: {
                    data: data
                },
                success: function (res)
                {
                    if (!res.err) {
                        toastr.success(res.msg);

                        setTimeout(function () {
                            window.location.href = app_url + 'admin/account_group/account/' + $('#group_id').val();
                        }, 2000);

                        $('#btn-create').attr("disabled", "disabled");
                    } else {
                        toastr.error(res.msg);
                    }
                }
            });
        }
    </script>
@endsection
