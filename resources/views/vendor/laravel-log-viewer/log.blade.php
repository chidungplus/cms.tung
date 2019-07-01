@extends('layout::backend.master')

@section('breadcrumb')
    <a class="breadcrumb-item active" href="">{{ App\Models\Module::getDisplayName('system_log') }}</a>
    {{-- use lang in file global --}}
@endsection

@section('content')
    <div class="br-section-wrapper">
        {{-- Bg header --}}
        <h6 class="tx-gray-800 tx-uppercase tx-bold tx-18 mg-b-10">
            <i class="fa fa-flag-o" aria-hidden="true"></i> &nbsp;
            @lang('global.list') {{ App\Models\Module::getDisplayName('system_log') }}
        </h6>
        <hr> <br>

        <div class="p-3">
            @if($current_file)
                <a href="?dl={{ \Illuminate\Support\Facades\Crypt::encrypt($current_file) }}{{ ($current_folder) ? '&f=' . \Illuminate\Support\Facades\Crypt::encrypt($current_folder) : '' }}">
                    <span class="fa fa-download"></span> @lang('global.download_file')
                </a>

                <a id="clean-log" href="?clean={{ \Illuminate\Support\Facades\Crypt::encrypt($current_file) }}{{ ($current_folder) ? '&f=' . \Illuminate\Support\Facades\Crypt::encrypt($current_folder) : '' }}">
                    <span class="fa fa-trash"></span> @lang('global.clean_file')
                </a>

                <a id="delete-log" href="?del={{ \Illuminate\Support\Facades\Crypt::encrypt($current_file) }}{{ ($current_folder) ? '&f=' . \Illuminate\Support\Facades\Crypt::encrypt($current_folder) : '' }}">
                    <span class="fa fa-trash"></span> @lang('global.delete_file')
                </a>
                @if(count($files) > 1)
                    -
                    <a id="delete-all-log" href="?delall=true{{ ($current_folder) ? '&f=' . \Illuminate\Support\Facades\Crypt::encrypt($current_folder) : '' }}">
                        <span class="fa fa-trash-alt"></span> Delete all files
                    </a>
                @endif
            @endif
        </div>
        <div class="rounded table-responsive">
            @if ($logs === null)
                <div>
                    Log file >50M, please download it.
                </div>
            @else
                <table class="table table-bordered mg-b-0 table-responsive" id="system_log_table">
                    <thead>
                        <tr>
                            <th class="wd-5p">@lang('global.order')</th>
                            <th class="wd-35p">@lang('global.level')</th>
                            <th class="wd-55p">@lang('global.content')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($logs)) @foreach ($logs as $key => $log)
                            <tr>
                                <td align="center">{{ $key + 1 }}</td>
                                <td align="center">
                                    <ul>
                                        <li>{{ $log['level'] }}</li>
                                        <li>{{ $log['context'] }}</li>
                                        <li>{{ date('H:i', strtotime($log['date'])) }}</li>
                                        <li>{{ date('d-m-Y', strtotime($log['date'])) }}</li>
                                    </ul>
                                </td>
                                <td>{!! (string)$log['text'] !!}</td>
                            </tr>
                            @endforeach @endif
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection

@section('script')
    <script>
        // after create cms, you need create file js, then move all contents to it.
        // please use laravel mix to manager you js
        // webpack.mix.js

        $(document).ready(function () {
            $('#system_log_table').DataTable();
        });
    </script>
@endsection
