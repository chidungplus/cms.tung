@extends('layout::backend.master')

@section('breadcrumb')
    <a class="breadcrumb-item active" href="{{ route('account.index') }}">{{ $display_name }}</a>
    {{-- use lang in file global --}}
@endsection

@section('content')
    <div class="br-section-wrapper">
        {{-- Bg header --}}
        <h6 class="tx-gray-800 tx-uppercase tx-bold tx-18 mg-b-10">
            <i class="fa fa-flag-o" aria-hidden="true"></i> &nbsp;
            @lang('global.list') {{ $display_name }}
        </h6>
        <hr> <br>

        {{-- Bg content --}}
        <div class="col-sm-2 col-md-2 pd-0">
            <button class="btn btn-info btn-block mg-b-20" onclick="window.location='{{ route('account.create') }}'">
                <i class="fa fa-plus-circle" aria-hidden="true"></i> &nbsp;
                @lang('global.add')
            </button>
        </div>

        <br>

        <div class="rounded table-responsive">
            <table class="table table-bordered mg-b-0" id="account_table">
                <thead>
                <tr>
                    <th class="wd-5p">STT</th>
                    <th class="wd-25p">Nhóm tài khoản</th>
                    <th class="wd-25p">User name</th>
                    <th class="wd-10p">Password</th>
                    <th class="wd-20p">@lang('global.status')</th>
                    <th class="wd-20p">@lang('global.created_at')</th>
                    <th class="wd-15p">@lang('global.action')</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@section('script')
    <script>
        // after create cms, you need create file js, then move all contents to it.
        // please use laravel mix to manager you js
        // webpack.mix.js

        $(document).ready(function () {

            $('#account_table').DataTable({
                autoWidth: true,
                processing: true,
                serverSide: true,
                ordering: false,
                ajax: {
                    url: app_url + 'admin/account/get_list_account',
                    type: 'post'
                },
                searching: true,
                columns: [
                    {data: 'DT_RowIndex', className: 'tx-center', searchable: false},
                    {data: 'group_account_id'},
                    {data: 'username'},
                    {data: 'password'},
                    {data: 'status', className: 'tx-center'},
                    {data: 'created_at', className: 'tx-center'},
                    {data: 'action', className: 'tx-center'},
                ],
            });

            $('#account_table').on('click', '.btn-edit', function () {
                window.location.href = app_url + 'admin/account/' + $(this).data('id') + '/edit';
            });

            $('#account_table').on('click', '.btn-delete', function (event) {
                event.preventDefault();

                swal({
                    title: Lang.get('global.are_you_sure_to_delete'),
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#00b297',
                    cancelButtonColor: '#d33',
                    confirmButtonText: Lang.get('global.confirm'),
                    cancelButtonText: Lang.get('global.cancle')
                }).then((result) => {
                    if (result.value) {

                        $.ajax({
                            url: app_url + 'admin/account/' + $(this).data('id'),
                            type: 'DELETE',
                            dataType: "JSON",
                            data: {
                                id: $(this).data('id')
                            },
                            success: function (res)
                            {
                                if (!res.err) {
                                    toastr.success(res.msg);
                                    $('#account_table').DataTable().ajax.reload();
                                } else {
                                    toastr.error(res.msg);
                                }
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
