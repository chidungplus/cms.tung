@extends('layout::backend.master')

@section('breadcrumb')
    <a class="breadcrumb-item" href="{{ route('account_group.index') }}">{{ $display_name }}</a>
    <a class="breadcrumb-item" href="#">{{ ucfirst($groups->name) }}</a>
    <a class="breadcrumb-item active" href="#">Danh sách tài khoản</a>
@endsection

@section('content')
    <div class="br-section-wrapper">

        {{-- Bg header --}}
        <h6 class="tx-gray-800 tx-uppercase tx-bold tx-18 mg-b-10">
            <i class="fa fa-bars" aria-hidden="true"></i> &nbsp;
            Danh sách tài khoản nhóm {{ ucfirst($groups->name) }}
        </h6>
        <hr> <br>

        <div class="row row-sm mg-t-20">
            <div class="col-sm-6 col-lg-3 mg-b-10">
                <div class="card  bd-0">
                    <div class="card-header bg-transparent d-flex justify-content-between align-items-center bg-whitesmoke">
                        <h6 class="card-title tx-uppercase tx-12 mg-b-0">Tổng số tài khoản</h6>
                        <a href="{{ route('download',[$groups->id, 2]) }}"><i class="fa fa-download" aria-hidden="true"></i> &nbsp;Download</a>
                    </div><!-- card-header -->
                    <div class="card-body">
                        <span id="all_account">{{ $number['all_account'] }}</span>
                    </div><!-- card-body -->
                </div><!-- card -->
            </div><!-- col-4 -->
            <div class="col-sm-6 col-lg-3 mg-b-10">
                <div class="card  bd-0">
                    <div class="card-header bg-transparent d-flex justify-content-between align-items-center bg-whitesmoke">
                        <h6 class="card-title tx-uppercase tx-12 mg-b-0">Đã thực hiện đổi mật khẩu</h6>
                        <a href="{{ route('download',[$groups->id, 1]) }}"><i class="fa fa-download" aria-hidden="true"></i> &nbsp;Download</a>
                    </div><!-- card-header -->
                    <div class="card-body">
                        <span id="changed">{{ $number['changed'] }}</span>
                    </div><!-- card-body -->
                </div><!-- card -->
            </div><!-- col-4 -->
            <div class="col-sm-6 col-lg-3 mg-b-10">
                <div class="card  bd-0">
                    <div class="card-header bg-transparent d-flex justify-content-between align-items-center bg-whitesmoke">
                        <h6 class="card-title tx-uppercase tx-12 mg-b-0">Chưa thực hiện đổi mật khẩu</h6>
                        <a href="{{ route('download',[$groups->id, -1]) }}"><i class="fa fa-download" aria-hidden="true"></i> &nbsp;Download</a>
                    </div><!-- card-header -->
                    <div class="card-body">
                        <span id="not_changed">{{ $number['not_changed'] }}</span>
                    </div><!-- card-body -->
                </div><!-- card -->
            </div><!-- col-4 -->
            <div class="col-sm-6 col-lg-3 mg-b-10">
                <div class="card  bd-0">
                    <div class="card-header bg-transparent d-flex justify-content-between align-items-center bg-whitesmoke">
                        <h6 class="card-title tx-uppercase tx-12 mg-b-0">Đổi thành công</h6>
                        <a href="{{ route('download',[$groups->id, 0]) }}"><i class="fa fa-download" aria-hidden="true"></i> &nbsp;Download</a>
                    </div><!-- card-header -->
                    <div class="card-body">
                        <span id="not_changed">{{ $number['success'] }}</span>
                    </div><!-- card-body -->
                </div><!-- card -->
            </div><!-- col-4 -->
        </div><!-- row -->
        <hr>
        <br>

        {{-- Bg content --}}
        @if ($permission)
            <div class="btn-group">
                <button type="button" class="btn btn-info mg-r-20" onclick="window.location='{{ route('account_group.createAccount', $groups->id) }}'">
                    <i class="fa fa-plus-circle" aria-hidden="true"></i> &nbsp;
                    Thêm tài khoản
                </button>

                <button type="button" class="btn btn-success" id="btn-change-password" >
                    <i class="fa fa-unlock" aria-hidden="true"></i> &nbsp;
                    Đổi mật khẩu
                </button>
            </div>
        @endif

        <div class="rounded table-responsive">
            <br>
            <table class="table table-bordered mg-b-0" id="account_table">
                <thead>
                <tr>
                    <th class="wd-5p">STT</th>
                    <th class="wd-10p">User name</th>
                    <th class="wd-10p">Mật khẩu</th>
                    <th class="wd-10p">Mật khẩu mới</th>
                    <th class="wd-5p">Email</th>
                    <th class="wd-5p">SDT</th>
                    <th class="wd-15p">@lang('global.status')</th>
                    <th class="wd-20p">Message</th>
                    <th class="wd-15p">@lang('global.created_at')</th>
                    <th class="wd-10p">@lang('global.action')</th>
                </tr>
                </thead>
            </table>
        </div>

        <input type="hidden" id="group_account_id" value="{{ $groups->id }}">
    </div>

    <!-- The Modal -->
    <div class="modal" id="mdl-change-pw">
        <div class="modal-dialog" style="width: 700px;">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title">Đổi mật khẩu</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body"
                    <div class="table-responsive">
                        <table class="bd table table-bordered mg-b-0">
                            <thead>
                                <tr>
                                    <td class="wd-50p">Số tài khoản cần đổi mật khẩu</td>
                                    <td><span id="number_account"></span></td>
                                </tr>
                                <tr>
                                    <td>Thời gian ước tính</td>
                                    <td><span id="time"></span></td>
                                </tr>
                            </thead>
                        </table>

                        <br>

                        <div class="form-group">
                            <input required="required" class="form-control" type="text" id="password_new" name="password_new" placeholder="Nhập mật khẩu mới">
                            <span class="err-password-new mg-t-15 tx-12 tx-bold" style="color: red;"></span>
                        </div>
                        
                        <div class="form-group" align="center">
{{--                            <img src="{{ asset('images/loading.svg') }}" alt="" style="display: none" id="loading-change">--}}
                        </div>
                    </div>



                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" data-value="{{ $groups->id }}" id="btn-submit-change-pw">Submit</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
                    </div>
                </div>

            </div>
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
                    type: 'post',
                    data: {
                        group_account_id: $('#group_account_id').val()
                    }
                },
                searching: true,
                columns: [
                    {data: 'DT_RowIndex', className: 'tx-center', searchable: false},
                    {data: 'username'},
                    {data: 'password'},
                    {data: 'password_new'},
                    {data: 'email'},
                    {data: 'mobile'},
                    {data: 'status', className: 'tx-center'},
                    {data: 'message'},
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

                                    countAccount($('#group_account_id').val());
                                } else {
                                    toastr.error(res.msg);
                                }
                            }
                        });
                    }
                });
            });

            function countAccount(group_account_id){
                $.ajax({
                    url: app_url + 'admin/account_group/count_account',
                    type: 'POST', // GET, POST, PUT, PATCH, DELETE,
                    data: {
                        group_account_id: group_account_id
                    },
                    success: function (res)
                    {
                        if (!res.err) {
                            $('span#all_account').text(res.number.all_account);
                            $('span#changed').text(res.number.changed);
                            $('span#not_changed').text(res.number.not_changed);
                        }
                    }
                });
            }
        });
        
        $('#btn-change-password').on('click', function (event) {
            event.preventDefault();
            $('#mdl-change-pw').modal('show');
            $('span#number_account').text("");
            $('span#time').text("");
            $('#loading-change').hide();

            // get info group need change password
            $.ajax({
                url: app_url + 'admin/account_group/get_info_change_password',
                type: 'POST', // GET, POST, PUT, PATCH, DELETE,
                data: {
                    group_account_id: $('#group_account_id').val()
                },
                success: function (res)
                {
                    if (!res.err) {
                        $('span#number_account').text(res.number);
                        $('span#time').text(res.time);
                    }
                }
            });
        });

        var click = false;

        $('#mdl-change-pw').on('click', '#btn-submit-change-pw', function (event) {
            event.preventDefault();

            if (click == true)
            {
                return false;
            }

            $password_new = $('#password_new').val();

            if ($password_new === "")
            {
                $('span.err-password-new').text('Vui lòng nhập mật khẩu mới.');
                return false;
            } else {
                $('span.err-password-new').hide();
            }

            click = false;

            $('#loading-change').show();

            // submit change password all account in group
            $.ajax({
                url: app_url + 'admin/account_group/change_password',
                type: 'POST', // GET, POST, PUT, PATCH, DELETE,
                data: {
                    group_account_id: $('#group_account_id').val(),
                    password_new: $password_new
                },
                success: function (res)
                {
                    if (!res.err) {
                        toastr.success(res.msg);
                        setTimeout(function () {
                            window.location.reload();
                        }, 3000);
                    }
                }
            });
        });
    </script>
@endsection
