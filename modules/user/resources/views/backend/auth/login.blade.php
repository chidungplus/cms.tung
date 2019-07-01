<!doctype html>
<html lang="{{ \App::getLocale() }}">
<head>

    @include('layout::backend.head')

    <link rel="stylesheet" href="{{ asset('bower_components/particles.js/demo/css/style.css') }}">
</head>
<body>
<div id="particles-js"></div>

<div class="d-flex align-items-center justify-content-center bg-br-primary ht-80p" id="div-login-form">
    <div class="login-wrapper wd-300 wd-xs-350 pd-25 pd-xs-40 bg-white rounded shadow-base">
        <div class="signin-logo tx-center tx-28 tx-bold tx-inverse"><span class="tx-normal">[</span> {{ env('APP_NAME') }} <span class="tx-normal">]</span></div>
        <div class="tx-center mg-b-40 tx-14"> {{ env('APP_DESCRIPTION') }} </div>

        {!! Form::open(['route' => 'user.login']) !!}
        <div class="form-group">
            {!! Form::label('email', trans('global.email'), ['class' => 'form-control-label tx-14 mg-b-5 tx-bold']) !!}
            {!! Form::text('email', '', ['class' => 'form-control', 'placeholder' => trans('global.please_enter_email')]) !!}

            @if( $errors->has('email'))
                {!! Form::label('error', $errors->first('email'), ['class' => 'form-control-label tx-12 mg-b-5 mg-t-5 tx-bold tx-span-error']) !!}
            @endif
        </div>

        <div class="form-group">
            {!! Form::label('password', trans('global.password'), ['class' => 'form-control-label tx-14 mg-b-5 tx-bold']) !!}
            {!! Form::password('password', ['class' => 'form-control', 'placeholder' => trans('global.please_enter_password')]) !!}

            @if( $errors->has('password'))
                {!! Form::label('error', $errors->first('password'), ['class' => 'form-control-label tx-12 mg-b-5 mg-t-5 tx-bold tx-span-error']) !!}
            @endif
        </div>

        <div class="form-group">
            <a href="{{ route('layout.index') }}" class="tx-info tx-12 d-block mg-t-10"> @lang('global.forgot_password') </a>
        </div>

        <div class="form-group">
            {!! Form::submit( trans('global.sign_in'), ['class' => 'form-control btn btn-info btn-block']) !!}
        </div>
        {!! Form::close() !!}
    </div><!-- login-wrapper -->
</div><!-- d-flex -->

@include('layout::backend.script')

<script src="{{ asset('bower_components/particles.js/particles.min.js') }}"></script>
<script src="{{ asset('bower_components/particles.js/demo/js/app.js') }}"></script>
<script src="{{ asset('bower_components/particles.js/demo/js/lib/stats.js') }}"></script>
</body>
</html>
