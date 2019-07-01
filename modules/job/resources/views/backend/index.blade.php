@extends('layout::backend.master')

@section('breadcrumb')
    <a class="breadcrumb-item active" href="{{ route('job.index') }}">{{ $display_name }}</a>
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
            <button class="btn btn-info btn-block mg-b-20" onclick="$('#job_table').DataTable().ajax.reload()">
                <i class="fa fa-plus-circle" aria-hidden="true"></i> &nbsp;
                Reload danh sách
            </button>
        </div>

        <br>

        <div class="rounded table-responsive">
            <table class="table table-bordered mg-b-0" id="job_table">
                <thead>
                <tr>
                    <th class="wd-5p">ID</th>
                    <th class="wd-20p">Queue</th>
                    <th class="wd-10p">Attempts</th>
                    <th class="wd-15p">Reserved at</th>
                    <th class="wd-15p">Available at</th>
                    <th class="wd-15p">Created at</th>
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

            $('#job_table').DataTable({
                autoWidth: true,
                processing: true,
                serverSide: true,
                ordering: false,
                ajax: {
                    url: app_url + 'admin/job/get_list_job',
                    type: 'post'
                },
                searching: true,
                columns: [
                    {data: 'id', className: 'tx-center', searchable: false},
                    {data: 'queue'},
                    {data: 'attempts', className: 'tx-center'},
                    {data: 'reserved_at', className: 'tx-center'},
                    {data: 'available_at', className: 'tx-center'},
                    {data: 'created_at', className: 'tx-center'},
                ],
            });
        });
    </script>
@endsection
