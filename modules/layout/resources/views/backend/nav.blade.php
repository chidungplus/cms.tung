<!-- ########## START: HEAD PANEL ########## -->
<div class="br-header">
    <div class="br-header-left">
        <div class="navicon-left hidden-md-down">
            <a id="btnLeftMenu" href="">
                <i class="fa fa-bars tx-18" aria-hidden="true"></i>
            </a>
        </div>
        <div class="navicon-left hidden-lg-up">
            <a id="btnLeftMenuMobile" href="">
                <i class="fa fa-bars tx-18" aria-hidden="true"></i>
            </a>
        </div>
    </div><!-- br-header-left -->
    <div class="br-header-right">
        <nav class="nav">
            <div class="dropdown pd-x-10">
                <a href="" class="nav-link pd-x-7 pos-relative" data-toggle="dropdown">
                    {{--<i class="icon ion-ios-email-outline tx-24"></i>--}}
                    <i class="fa fa-envelope-open-o tx-16" aria-hidden="true" style="margin-top: 10px"></i>

                    <!-- start: if statement -->
                    <span class="square-8 bg-danger pos-absolute t-15 r-0 rounded-circle"></span>
                    <!-- end: if statement -->
                </a>
                <div class="dropdown-menu dropdown-menu-header wd-300 pd-0-force">
                    <div class="d-flex align-items-center justify-content-between pd-y-10 pd-x-20 bd-b bd-gray-200">
                        <label class="tx-12 tx-info tx-uppercase tx-semibold tx-spacing-2 mg-b-0">@lang('global.message')</label>
                        <a href="" class="tx-11">+ @lang('global.new_message')</a>
                    </div><!-- d-flex -->

                    <div class="media-list">
                        <!-- lobr-header-rightop starts here -->
                        <a href="" class="media-list-link">
                            <div class="media pd-x-20 pd-y-15">
                                <img src="http://via.placeholder.com/280x280" class="wd-40 rounded-circle" alt="">
                                <div class="media-body">
                                    <div class="d-flex align-items-center justify-content-between mg-b-5">
                                        <p class="mg-b-0 tx-medium tx-gray-800 tx-14">Donna Seay</p>
                                        <span class="tx-11 tx-gray-500">2 minutes ago</span>
                                    </div><!-- d-flex -->
                                    <p class="tx-12 mg-b-0">@lang('global.message').</p>
                                </div>
                            </div><!-- media -->
                        </a>
                        <!-- loop ends here -->
                        <a href="" class="media-list-link read">
                            <div class="media pd-x-20 pd-y-15">
                                <img src="http://via.placeholder.com/280x280" class="wd-40 rounded-circle" alt="">
                                <div class="media-body">
                                    <div class="d-flex align-items-center justify-content-between mg-b-5">
                                        <p class="mg-b-0 tx-medium tx-gray-800 tx-14">Samantha Francis</p>
                                        <span class="tx-11 tx-gray-500">3 hours ago</span>
                                    </div><!-- d-flex -->
                                    <p class="tx-12 mg-b-0">My entire soul, like these sweet mornings of spring.</p>
                                </div>
                            </div><!-- media -->
                        </a>
                        <a href="" class="media-list-link read">
                            <div class="media pd-x-20 pd-y-15">
                                <img src="http://via.placeholder.com/280x280" class="wd-40 rounded-circle" alt="">
                                <div class="media-body">
                                    <div class="d-flex align-items-center justify-content-between mg-b-5">
                                        <p class="mg-b-0 tx-medium tx-gray-800 tx-14">Robert Walker</p>
                                        <span class="tx-11 tx-gray-500">5 hours ago</span>
                                    </div><!-- d-flex -->
                                    <p class="tx-12 mg-b-0">I should be incapable of drawing a single stroke at the present moment...</p>
                                </div>
                            </div><!-- media -->
                        </a>
                        <a href="" class="media-list-link read">
                            <div class="media pd-x-20 pd-y-15">
                                <img src="http://via.placeholder.com/280x280" class="wd-40 rounded-circle" alt="">
                                <div class="media-body">
                                    <div class="d-flex align-items-center justify-content-between mg-b-5">
                                        <p class="mg-b-0 tx-medium tx-gray-800 tx-14">Larry Smith</p>
                                        <span class="tx-11 tx-gray-500">Yesterday</span>
                                    </div><!-- d-flex -->
                                    <p class="tx-12 mg-b-0">When, while the lovely valley teems with vapour around me, and the meridian sun strikes...</p>
                                </div>
                            </div><!-- media -->
                        </a>
                        <div class="pd-y-10 tx-center bd-t">
                            <a href="" class="tx-12"><i class="fa fa-angle-down mg-r-5"></i> @lang('global.show_all_message')</a>
                        </div>
                    </div><!-- media-list -->
                </div><!-- dropdown-menu -->
            </div><!-- dropdown -->
            <div class="dropdown pd-x-10 dropdown-notifications">
                <a href="" class="nav-link pd-x-7 pos-relative" data-toggle="dropdown">
                    <i class="fa fa-bell-o tx-18" aria-hidden="true" style="margin-top: 10px; margin-right: 3px"></i>
                    <!-- start: if statement -->
                    <!-- end: if statement -->
                </a>
                <div class="dropdown-menu dropdown-menu-header wd-300 pd-0-force">
                    <div class="d-flex align-items-center justify-content-between pd-y-10 pd-x-20 bd-b bd-gray-200">
                        <label class="tx-12 tx-info tx-uppercase tx-semibold tx-spacing-2 mg-b-0">@lang('global.notification')</label>
                        <a href="" class="tx-11">@lang('global.mark_all_as_read')</a>
                    </div><!-- d-flex -->

                    <div class="media-list">
                        <a href="" class="media-list-link read">
                            <div class="media pd-x-20 pd-y-15">
                                <img src="https://api.adorable.io/avatars/73/avatar.png" class="img-circle" alt="50x50" style="width: 50px; height: 50px;">
                                <div class="media-body">
                                    <p class="tx-13 mg-b-0 tx-gray-700"><strong class="tx-medium tx-gray-800">Justin Bieber</strong></p>
                                    <span class="tx-12">October 03, 2017 8:45am</span>
                                </div>
                            </div>
                        </a>
                        <a href="" class="media-list-link read">
                            <div class="media pd-x-20 pd-y-15">
                                <img src="https://api.adorable.io/avatars/72/avatar.png" class="img-circle" alt="50x50" style="width: 50px; height: 50px;">
                                <div class="media-body">
                                    <p class="tx-13 mg-b-0 tx-gray-700"><strong class="tx-medium tx-gray-800">Justin Bieber</strong></p>
                                    <span class="tx-12">October 03, 2017 8:45am</span>
                                </div>
                            </div>
                        </a>
                        <a href="" class="media-list-link read">
                            <div class="media pd-x-20 pd-y-15">
                                <img src="https://api.adorable.io/avatars/71/avatar.png" class="img-circle" alt="50x50" style="width: 50px; height: 50px;">
                                <div class="media-body">
                                    <p class="tx-13 mg-b-0 tx-gray-700"><strong class="tx-medium tx-gray-800">Justin Bieber</strong></p>
                                    <span class="tx-12">October 03, 2017 8:45am</span>
                                </div>
                            </div>
                        </a>
                        <div class="pd-y-10 tx-center bd-t">
                            <a href="" class="tx-12"><i class="fa fa-angle-down mg-r-5"></i> @lang('global.show_all_notification')</a>
                        </div>
                    </div><!-- media-list -->
                </div><!-- dropdown-menu -->
            </div><!-- dropdown -->
            <div class="dropdown pd-x-10">
                <a href="" class="nav-link pd-x-7 pos-relative" data-toggle="dropdown">
                    <i class="fa fa-globe tx-20" aria-hidden="true" style="margin-top: 8px;"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-header wd-200 pd-0-force">
                    <div class="d-flex align-items-center justify-content-between pd-y-10 pd-x-20 bd-b bd-gray-200">
                        <label class="tx-12 tx-info tx-uppercase tx-semibold tx-spacing-2 mg-b-0">@lang('global.language')</label>
                    </div><!-- d-flex -->

                    <div class="media-list">
                        <a href="{{ route('layout.change_language', 'vi') }}" class="media-list-link read w-50 float-left" style="display: block; margin-top: 0px" >
                            <div class="media pd-x-20 pd-y-15">
                                <img src="{{ asset('images/lang-vi.png') }}" class="wd-40 rounded-circle" alt="" style="margin: 0 auto;" >
                            </div><!-- media -->
                        </a>
                        <a href="{{ route('layout.change_language', 'en') }}" class="media-list-link read w-50 float-right" style="display: block; margin-top: 0px" >
                            <div class="media pd-x-20 pd-y-15">
                                <img src="{{ asset('images/lang-en.png') }}" class="wd-40 rounded-circle" alt="" style="margin: 0 auto;">
                            </div><!-- media -->
                        </a>
                    </div><!-- media-list -->
                </div><!-- dropdown-menu -->
            </div>
            <div class="dropdown">
                <a href="" class="nav-link nav-link-profile" data-toggle="dropdown">
                    <span class="logged-name hidden-md-down">{{ Auth::guard('web')->user()->name }}</span>
                    <img src="{{ asset('images/user.jpg') }}" class="wd-32 rounded-circle" alt="">
                    <span class="square-10 bg-success"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-header wd-200">
                    <ul class="list-unstyled user-profile-nav">
                        <li><a href="{{ route('user.show', Auth::guard('web')->id()) }}"><i class="fa fa-user tx-16" aria-hidden="true"></i>&nbsp; @lang('global.profile')</a></li>
                        <li><a href="{{ route('user.setting', Auth::guard('web')->id()) }}"><i class="fa fa-gear tx-16" aria-hidden="true"></i>&nbsp; Đổi mật khẩu</a></li>
                        <li><a href="{{ route('user.logout') }}"><i class="fa fa-share tx-14" aria-hidden="true"></i>&nbsp; @lang('global.sign_out')</a></li>
                    </ul>
                </div><!-- dropdown-menu -->
            </div><!-- dropdown -->
        </nav>
        <div class="navicon-right">
            <a id="btnRightMenu" href="" class="pos-relative">
                <i class="fa fa-comments-o tx-18" aria-hidden="true"></i>
                <span class="square-8 bg-danger pos-absolute t-10 r--5 rounded-circle"></span>
            </a>
        </div><!-- navicon-right -->
    </div><!-- br-header-right -->
</div><!-- br-header -->
<!-- ########## END: HEAD PANEL ########## -->
