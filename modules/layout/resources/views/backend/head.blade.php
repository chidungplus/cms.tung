<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


<!-- Twitter -->
<meta name="twitter:site" content="">
<meta name="twitter:creator" content="">
<meta name="twitter:card" content="">
<meta name="twitter:title" content="ZentCMS">
<meta name="twitter:description" content="">
<meta name="twitter:image" content="">

<!-- Facebook -->
<meta property="og:url" content="">
<meta property="og:title" content="ZentCMS">
<meta property="og:description" content="">

<meta property="og:image" content="">
<meta property="og:image:secure_url" content="">
<meta property="og:image:type" content="">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="600">

<!-- Meta -->
<meta name="description" content="{{ env('APP_DESCRIPTION') }}">
<meta name="author" content="{{ env('AUTHOR') }}">
<meta name="website" content="{{ asset('') }}">

<title>{{ env('APP_NAME') }}</title>

<!-- vendor css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
{{--<link href="{{ asset('bower_components/font-awesome/css/font-awesome.css') }}" rel="stylesheet">--}}
{{--<link href="{{ asset('bower_components/ionicons/css/ionicons.min.css') }}" rel="stylesheet">--}}
<link href="{{ asset('bower_components/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet">
{{--<link href="{{ asset('bower_components/jquery-switchButton/jquery.switchButton.css') }}" rel="stylesheet">--}}
<link href="{{ asset('bower_components/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<link href="{{ asset('bower_components/toastr/toastr.min.css') }}" rel="stylesheet">
<link href="{{ asset('bower_components/sweetalert2/dist/sweetalert2.min.css') }}" rel="stylesheet">
<link href="{{ asset('bower_components/datetimepicker/jquery.datetimepicker.css') }}" rel="stylesheet">
<!-- ZentCMS CSS -->
<link rel="stylesheet" href="{{ mix('build/css/global.css') }}">
<link rel="stylesheet" href="{{ mix('build/css/custom.css') }}">

<link rel="shortcut icon" type="image/png" href="{{ asset('images/favicon-main.png') }}"/>

<style>
    .toast {
        opacity: 1 !important;
        margin-left: 50px !important;
    }

    .modal-backdrop {
  position: fixed;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  z-index: 1030;
  background-color: #333333;
  opacity:0.8; // I ADDED THIS LINE 
    }
}
</style>

