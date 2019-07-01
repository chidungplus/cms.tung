@extends('layout::backend.master')

@section('breadcrumb')
    <a class="breadcrumb-item active" href="{{ route('activity_log.index') }}">{{ $display_name }}</a>
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

        <div class="rounded table-responsive">
            <table class="table table-bordered mg-b-0" id="activity_log_table">
                <thead>
                    <tr>
                        <th class="wd-5p">@lang('global.order')</th>
                        <th>@lang('global.ip')</th>
                        <th>@lang('global.user')</th>
                        {{--<th>@lang('global.userType')</th>--}}
                        <th>@lang('global.route')</th>
                        <th>@lang('global.user_agent')</th>
                        {{--<th>@lang('global.locale')</th>--}}
                        {{--<th>@lang('global.referer')</th>--}}
                        <th>@lang('global.method')</th>
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

            $('#activity_log_table').DataTable({
                autoWidth: true,
                processing: true,
                serverSide: true,
                ordering: false,
                ajax: {
                    url: app_url + 'admin/activity_log/get_list_activity_log',
                    type: 'post'
                },
                searching: true,
                columns: [
                    {data: 'DT_RowIndex', className: 'tx-center', searchable: false},
                    {data: 'ipAddress', className: 'tx-center'},
                    {data: 'userId'},
                    // {data: 'userType'},
                    {data: 'route'},
                    {data: 'userAgent', className:'dt-agent tx-center'},
                    // {data: 'locale'},
                    // {data: 'referer'},
                    {data: 'methodType', className: 'tx-center'},
                ],
            });

            $('#activity_log_table').on('click', '.btn-edit', function () {
                window.location.href = app_url + 'admin/activity_log/' + $(this).data('id') + '/edit';
            });

            $('#activity_log_table').on('click', '.btn-delete', function (event) {
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
                            url: app_url + 'admin/activity_log/' + $(this).data('id'),
                            type: 'DELETE',
                            dataType: "JSON",
                            data: {
                                id: $(this).data('id')
                            },
                            success: function (res)
                            {
                                if (!res.err) {
                                    toastr.success(res.msg);
                                    $('#activity_log_table').DataTable().ajax.reload();
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
