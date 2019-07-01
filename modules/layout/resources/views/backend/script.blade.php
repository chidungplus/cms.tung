<script src="{{ asset('bower_components/jquery/dist/jquery.js') }}"></script>
<script src="{{ asset('bower_components/popper.js/dist/umd/popper.js') }}"></script>
<script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.js')}}"></script>
<script src="{{ asset('bower_components/moment/moment.js') }}"></script>
<script src="{{ asset('bower_components/jquery-ui/jquery-ui.js') }}"></script>
<script src="{{ asset('bower_components/jquery-switchbutton/jquery.switchButton.js') }}"></script>
<script src="{{ asset('bower_components/peity/jquery.peity.min.js') }}"></script>
<script src="{{ asset('bower_components/jquery.sparkline.bower/dist/jquery.sparkline.min.js') }}"></script>
<script src="{{ asset('bower_components/d3/d3.js') }}"></script>
<script src="{{ asset('bower_components/chart.js/dist/Chart.js') }}"></script>

<script src="{{ mix('build/js/global.js') }}"></script>
<script src="{{ mix('build/js/ResizeSensor.js') }}"></script>
<script src="{{ mix('build/js/dashboard.js') }}"></script>

<script src="{{ asset('bower_components/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('messages.js') }}"></script>
<script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('bower_components/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('bower_components/sweetalert2/dist/sweetalert2.min.js') }}"></script>
{{--<script src="{{ asset('bower_components/ajax/dist/ajax.min.js') }}"></script>--}}
<script src="{{ asset('bower_components/jquery-validation/dist/jquery.validate.min.js') }}"></script>
<script src="{{ asset('bower_components/datetimepicker/build/jquery.datetimepicker.full.js') }}"></script>

<script>
    $(function(){
        'use strict'

        // FOR DEMO ONLY
        // menu collapsed by default during first page load or refresh with screen
        // having a size between 992px and 1299px. This is intended on this page only
        // for better viewing of widgets demo.
        $(window).resize(function(){
            minimizeMenu();
        });

        minimizeMenu();

        function minimizeMenu() {
            if(window.matchMedia('(min-width: 992px)').matches && window.matchMedia('(max-width: 1299px)').matches) {
                // show only the icons and hide left menu label by default
                $('.menu-item-label,.menu-item-arrow').addClass('op-lg-0-force d-lg-none');
                $('body').addClass('collapsed-menu');
                $('.show-sub + .br-menu-sub').slideUp();
            } else if(window.matchMedia('(min-width: 1300px)').matches && !$('body').hasClass('collapsed-menu')) {
                $('.menu-item-label,.menu-item-arrow').removeClass('op-lg-0-force d-lg-none');
                $('body').removeClass('collapsed-menu');
                $('.show-sub + .br-menu-sub').slideDown();
            }
        }
    });

    $("span.peity-bar").peity('bar');
    $("span.peity-donut").peity('donut');

    var app_url = $('meta[name="website"]').attr('content');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // $.extend(true, $.fn.dataTable.defaults, {
    //     responsive: true,
    //     language: {
    //         searchPlaceholder: Lang.get('global.search'),
    //         sSearch: '',
    //         lengthMenu: '<label><select class="form-control">'+
    //             '<option value="10">10</option>'+
    //             '<option value="20">20</option>'+
    //             '<option value="30">30</option>'+
    //             '<option value="40">40</option>'+
    //             '<option value="50">50</option>'+
    //             '<option value="-1">All</option>'+
    //             '</select> </label> ' + Lang.get('global.records'),
    //     },
    //     ordering: false
    // });

    $.extend( true, $.fn.dataTable.defaults, {
        "language": {
            "responsive":     true,
            "searchPlaceholder": Lang.get('global.search'),
            "emptyTable":     Lang.get('datatable.emptyTable'),
            "search":         "",
            "info":           Lang.get('datatable.info'),
            "infoEmpty":      Lang.get('datatable.infoEmpty'),
            "zeroRecords":    Lang.get('datatable.zeroRecords'),
            "loadingRecords": Lang.get('datatable.loadingRecords'),
            "lengthMenu": '<label><select class="form-control input-inline">'+
                '<option value="30" selected>30</option>'+
                '<option value="50">50</option>'+
                '<option value="100">100</option>'+
                '<option value="200">200</option>'+
                '<option value="500">500</option>'+
                '</select></label> ' + Lang.get('datatable.record'),
            "paginate": {
                "first":      Lang.get('datatable.first'),
                "last":       Lang.get('datatable.last'),
                "next":       Lang.get('datatable.next'),
                "previous":   Lang.get('datatable.previous'),
            },
            "processing": Lang.get('datatable.processing')
        },
        "pageLength": "30",
        "info": true,
        'paging': true,
        "ordering" : false
    });

    $('body').tooltip({
        selector: '[data-tooltip="tooltip"]',
        trigger: "hover",
    });

    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "3000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",
        "marginTop": "100"
    }

    $('.checkbox_status').on('change', function () {
       $(this).parent().css('background', '#4fbe79');
       $(this).next().css('left', '30px');
    });

    $('.nav-link').click();

    $(document).ready(function () {
        $(document).ajaxStart(function () {
            $("#cover").show();
        }).ajaxStop(function () {
            $("#cover").hide();
        });
    });
</script>

@if (Session::has('create_success'))
<script>
    $(document).ready(function() {
        toastr.success('{{ Session::get('create_success') }}');
    });
</script>
@endif

@if (Session::has('update_success'))
    <script>
        $(document).ready(function() {
            toastr.success('{{ Session::get('update_success') }}');
        });
    </script>
@endif

@if (Session::has('delete_success'))
    <script>
        $(document).ready(function() {
            toastr.error('{{ Session::get('delete_success') }}');
        });
    </script>
@endif

<script src="https://js.pusher.com/4.3/pusher.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<script type="text/javascript">
    var notificationsWrapper   = $('.dropdown-notifications');
    var notificationsToggle    = notificationsWrapper.find('a[data-toggle]');
    var notificationsCountElem = notificationsToggle.find('i[data-count]');
    var notificationsCount     = parseInt(notificationsCountElem.data('count'));
    var notifications          = notificationsWrapper.find('.media-list');


    // Enable pusher logging - don't include this in production
    // Pusher.logToConsole = true;

    var pusher = new Pusher('{{env('PUSHER_APP_KEY')}}', {
        cluster: 'ap1',
        encrypted: true
    });

    // Subscribe to the channel we specified in our Laravel Event
    var channel = pusher.subscribe('Notify');

    // Bind a function to a Event (the full Laravel class)
    channel.bind('send-message', function(data) {
        var existingNotifications = notifications.html();
        var avatar = Math.floor(Math.random() * (71 - 20 + 1)) + 20;
        var newNotificationHtml = `
            <a href="" class="media-list-link read">
                <div class="media pd-x-20 pd-y-15">
                    <img src="https://api.adorable.io/avatars/71/\`+avatar+\`.png" class="img-circle" alt="50x50" style="width: 50px; height: 50px;">
                    <div class="media-body">
                        <p class="tx-13 mg-b-0 tx-gray-700"><strong class="tx-medium tx-gray-800">`+data.title+`</strong> `+data.content+`</p>
                        <span class="tx-12">October 03, 2017 8:45am</span>
                    </div>
                </div>
            </a>
        `;

        var msg = data.title;
        // notifications.html(newNotificationHtml + existingNotifications);

        notificationsCount += 1;

        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
        
        var items = Array('warning', 'error', 'info', 'success');

        var item = items[Math.floor(Math.random()*items.length)];

        if ({{ Auth::guard('web')->check() && Auth::guard('web')->user()->id == 1}})
        {
            toastr.info(data);
        }
    });

</script>

