@extends('layout::backend.master')

@section('breadcrumb')
    <a class="breadcrumb-item active" href="{{ route('account_group.index') }}">{{ $display_name }}</a>
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
            <button class="btn btn-info btn-block mg-b-20" onclick="window.location='{{ route('account_group.create') }}'">
                <i class="fa fa-plus-circle" aria-hidden="true"></i> &nbsp;
                Tạo nhóm
            </button>

            {{--<button class="btn btn-success btn-block mg-b-20" onclick="window.location='{{ route('account_group.password') }}'">--}}
                {{--<i class="fa fa-unlock-alt" aria-hidden="true"></i> &nbsp;--}}
                {{--@lang('global.change_password')--}}
            {{--</button>--}}
        </div>

        <div class="col-sm-2 col-md-2 pd-0">

        </div>

        <br>

        <div class="rounded table-responsive">
            <table class="table table-bordered mg-b-0" id="account_group_table">
                <thead>
                <tr>
                    <th class="wd-5p">@lang('global.order')</th>
                    <th class="wd-10p">@lang('global.name')</th>
                    <th class="wd-10p">Ghi chú</th>
                    <th class="wd-10p">Tổng số tài khoản</th>
                    <th class="wd-10p">Đã thực hiện đổi mật khẩu</th>
                    <th class="wd-10p">Chưa thực hiện đổi mật khẩu</th>
                    <th class="wd-10p">Người tạo</th>
                    <th class="wd-15p">@lang('global.created_at')</th>
                    <th class="wd-20p">@lang('global.action')</th>
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

            $('#account_group_table').DataTable({
                autoWidth: true,
                processing: true,
                serverSide: true,
                ordering: false,
                ajax: {
                    url: app_url + 'admin/account_group/get_list_account_group',
                    type: 'post'
                },
                searching: true,
                columns: [
                    {data: 'DT_RowIndex', className: 'tx-center', searchable: false},
                    {data: 'name'},
                    {data: 'content'},
                    {data: 'all_account', className: 'tx-center'},
                    {data: 'changed_account', className: 'tx-center'},
                    {data: 'not_changed_account', className: 'tx-center'},
                    {data: 'user_created_id', className: 'tx-center'},
                    {data: 'created_at', className: 'tx-center'},
                    {data: 'action', className: 'tx-center'},
                ],
            });

            $('#account_group_table').on('click', '.btn-edit', function () {
                window.location.href = app_url + 'admin/account_group/' + $(this).data('id') + '/edit';
            });

            $('#account_group_table').on('click', '.btn-list-account', function () {
                window.location.href = app_url + 'admin/account_group/account/' + $(this).data('id');
            });

            $('#account_group_table').on('click', '.btn-delete', function (event) {
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
                            url: app_url + 'admin/account_group/' + $(this).data('id'),
                            type: 'DELETE',
                            dataType: "JSON",
                            data: {
                                id: $(this).data('id')
                            },
                            success: function (res)
                            {
                                if (!res.err) {
                                    toastr.success(res.msg);
                                    $('#account_group_table').DataTable().ajax.reload();
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
