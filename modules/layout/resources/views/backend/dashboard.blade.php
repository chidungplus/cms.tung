@extends('layout::backend.master')

@section('breadcrumb')

@endsection

@section('pageheader')
    {{--<div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">--}}
        {{--<h4 class="tx-gray-800 mg-b-5">@lang('global.welcome') @lang('global.admin').</h4>--}}
    {{--</div>--}}
@endsection

@section('content')
    <div class="pd-20">
    <div class="row row-sm">
        <div class="col-sm-6 col-xl-3">
            <div class="bg-teal rounded overflow-hidden">
                <div class="pd-25 d-flex align-items-center">
                    <i class="ion ion-earth tx-60 lh-0 tx-white op-7"></i>
                    <div class="mg-l-20">
                        <p class="tx-10 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10">Today's Visits</p>
                        <p class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1">1,975,224</p>
                        <span class="tx-11 tx-roboto tx-white-6">24% higher yesterday</span>
                    </div>
                </div>
            </div>
        </div><!-- col-3 -->
        <div class="col-sm-6 col-xl-3 mg-t-20 mg-sm-t-0">
            <div class="bg-danger rounded overflow-hidden">
                <div class="pd-25 d-flex align-items-center">
                    <i class="ion ion-bag tx-60 lh-0 tx-white op-7"></i>
                    <div class="mg-l-20">
                        <p class="tx-10 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10">Today Sales</p>
                        <p class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1">$329,291</p>
                        <span class="tx-11 tx-roboto tx-white-6">$390,212 before tax</span>
                    </div>
                </div>
            </div>
        </div><!-- col-3 -->
        <div class="col-sm-6 col-xl-3 mg-t-20 mg-xl-t-0">
            <div class="bg-primary rounded overflow-hidden">
                <div class="pd-25 d-flex align-items-center">
                    <i class="ion ion-monitor tx-60 lh-0 tx-white op-7"></i>
                    <div class="mg-l-20">
                        <p class="tx-10 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10">% Unique Visits</p>
                        <p class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1">54.45%</p>
                        <span class="tx-11 tx-roboto tx-white-6">23% average duration</span>
                    </div>
                </div>
            </div>
        </div><!-- col-3 -->
        <div class="col-sm-6 col-xl-3 mg-t-20 mg-xl-t-0">
            <div class="bg-br-primary rounded overflow-hidden">
                <div class="pd-25 d-flex align-items-center">
                    <i class="ion ion-clock tx-60 lh-0 tx-white op-7"></i>
                    <div class="mg-l-20">
                        <p class="tx-10 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10">Bounce Rate</p>
                        <p class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1">32.16%</p>
                        <span class="tx-11 tx-roboto tx-white-6">65.45% on average time</span>
                    </div>
                </div>
            </div>
        </div><!-- col-3 -->
    </div><!-- row -->

    <div class="row row-sm widget-1 mg-t-20">
        <div class="col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">Today's Sales</h6>
                    <a href=""><i class="icon ion-android-more-horizontal"></i></a>
                </div><!-- card-header -->
                <div class="card-body">
                    <span class="peity-bar" data-peity='{ "fill": ["#8E4246"], "height": 35, "width": 60 }'>1,2,1,3,2,10,4,12,7</span>
                    <span>$1,850</span>
                </div><!-- card-body -->
                <div class="card-footer">
                    <div>
                        <span class="tx-11">Gross Sales</span>
                        <h6 class="tx-inverse">$2,210</h6>
                    </div>
                    <div>
                        <span class="tx-11">No. of Items</span>
                        <h6 class="tx-inverse">68</h6>
                    </div>
                    <div>
                        <span class="tx-11">Tax Return</span>
                        <h6 class="tx-danger">$320</h6>
                    </div>
                </div><!-- card-footer -->
            </div><!-- card -->
        </div><!-- col-3 -->
        <div class="col-sm-6 col-lg-3 mg-t-1 mg-sm-t-0">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">This Week's Sales</h6>
                    <a href=""><i class="icon ion-android-more-horizontal"></i></a>
                </div><!-- card-header -->
                <div class="card-body">
                    <span class="peity-bar" data-peity='{ "fill": ["#1C7973"], "height": 35, "width": 60 }'>4,3,5,7,12,10,4,5,11,7</span>
                    <span class="tx-medium tx-inverse tx-32">$3,324</span>
                </div><!-- card-body -->
                <div class="card-footer">
                    <div>
                        <span class="tx-11">Gross Sales</span>
                        <h6 class="tx-inverse">$5,471</h6>
                    </div>
                    <div>
                        <span class="tx-11">Purchase</span>
                        <h6 class="tx-inverse">211</h6>
                    </div>
                    <div>
                        <span class="tx-11">Tax Return</span>
                        <h6 class="tx-danger">$1,988</h6>
                    </div>
                </div><!-- card-footer -->
            </div><!-- card -->
        </div><!-- col-3 -->
        <div class="col-sm-6 col-lg-3 mg-t-1 mg-lg-t-0">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">This Month's Sales</h6>
                    <a href=""><i class="icon ion-android-more-horizontal"></i></a>
                </div><!-- card-header -->
                <div class="card-body">
                    <span class="peity-bar" data-peity='{ "fill": ["#336490"], "height": 35, "width": 60 }'>8,6,5,9,8,4,9,3,5,9</span>
                    <span>$12,324</span>
                </div><!-- card-body -->
                <div class="card-footer">
                    <div>
                        <span class="tx-11">Gross Sales</span>
                        <h6 class="tx-inverse">$18,433</h6>
                    </div>
                    <div>
                        <span class="tx-11">Purchase</span>
                        <h6 class="tx-inverse">654</h6>
                    </div>
                    <div>
                        <span class="tx-11">Tax Return</span>
                        <h6 class="tx-danger">$3,314</h6>
                    </div>
                </div><!-- card-footer -->
            </div><!-- card -->
        </div><!-- col-3 -->
        <div class="col-sm-6 col-lg-3 mg-t-1 mg-lg-t-0">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">Overall Sales</h6>
                    <a href=""><i class="icon ion-android-more-horizontal"></i></a>
                </div><!-- card-header -->
                <div class="card-body">
                    <span class="peity-bar" data-peity='{ "fill": ["#9C7846"], "height": 35, "width": 60 }'>3,12,7,9,2,3,4,5,2</span>
                    <span>$32,324</span>
                </div><!-- card-body -->
                <div class="card-footer">
                    <div>
                        <span class="tx-11">Gross Sales</span>
                        <h6 class="tx-inverse">$56,433</h6>
                    </div>
                    <div>
                        <span class="tx-11">Purchases</span>
                        <h6 class="tx-inverse">1,654</h6>
                    </div>
                    <div>
                        <span class="tx-11">Tax Return</span>
                        <h6 class="tx-danger">$15,354</h6>
                    </div>
                </div><!-- card-footer -->
            </div><!-- card -->
        </div><!-- col-3 -->
    </div><!-- row -->

    <div class="row row-sm mg-t-20">
        <div class="col-sm-6 col-lg-4">
            <div class="card  bd-0">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                    <h6 class="card-title tx-uppercase tx-12 mg-b-0">Hardware Monitoring</h6>
                    <span class="tx-12 tx-uppercase">February 2017</span>
                </div><!-- card-header -->
                <div class="card-body">
                    <p class="tx-sm tx-inverse tx-medium mg-b-0">Hardware Monitoring</p>
                    <p class="tx-12">Intel Dothraki G125H 2.5GHz</p>
                    <div class="row align-items-center">
                        <div class="col-3 tx-12">CPU1</div><!-- col-3 -->
                        <div class="col-9">
                            <div class="progress rounded-0 mg-b-0">
                                <div class="progress-bar bg-info wd-50p lh-3" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">50%</div>
                            </div><!-- progress -->
                        </div><!-- col-9 -->
                    </div><!-- row -->
                    <div class="row align-items-center mg-t-5">
                        <div class="col-3 tx-12">CPU2</div><!-- col-3 -->
                        <div class="col-9">
                            <div class="progress rounded-0 mg-b-0">
                                <div class="progress-bar bg-pink wd-90p lh-3" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100">90%</div>
                            </div><!-- progress -->
                        </div><!-- col-9 -->
                    </div><!-- row -->
                    <p class="tx-11 mg-b-0 mg-t-15">Notice: Lorem ipsum dolor sit amet.</p>
                </div><!-- card-body -->
            </div><!-- card -->
        </div><!-- col-4 -->
        <div class="col-sm-6 col-lg-4 mg-t-20 mg-sm-t-0">
            <div class="card  bd-0">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                    <h6 class="card-title tx-uppercase tx-12 mg-b-0">Sales Monitoring</h6>
                    <span class="tx-12 tx-uppercase">March 2017</span>
                </div><!-- card-header -->
                <div class="card-body">
                    <p class="tx-sm tx-inverse tx-medium mg-b-0">Bracket Online Store</p>
                    <p class="tx-12"><a href="">http://bracketstore.com</a></p>
                    <div class="row align-items-center">
                        <div class="col-3 tx-12 tx-bold">Men</div><!-- col-3 -->
                        <div class="col-9">
                            <div class="progress rounded-0 mg-b-0">
                                <div class="progress-bar bg-teal wd-50p lh-3" role="progressbar" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100">55%</div>
                            </div><!-- progress -->
                        </div><!-- col-9 -->
                    </div><!-- row -->
                    <div class="row align-items-center mg-t-5">
                        <div class="col-3 tx-12 tx-bold">Women</div><!-- col-3 -->
                        <div class="col-9">
                            <div class="progress rounded-0 mg-b-0">
                                <div class="progress-bar bg-info wd-45p lh-3" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100">45%</div>
                            </div><!-- progress -->
                        </div><!-- col-9 -->
                    </div><!-- row -->
                    <p class="tx-11 mg-b-0 mg-t-15">Notice: Lorem ipsum dolor sit amet.</p>
                </div><!-- card-body -->
            </div><!-- card -->
        </div><!-- col-4 -->
        <div class="col-sm-6 col-lg-4 mg-t-20 mg-lg-t-0">
            <div class="card  bd-0">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                    <h6 class="card-title tx-uppercase tx-12 mg-b-0">Site Traffic Monitoring</h6>
                    <span class="tx-12 tx-uppercase">April 2017</span>
                </div><!-- card-header -->
                <div class="card-body">
                    <p class="tx-sm tx-inverse tx-medium mg-b-0">Bracket Online Store</p>
                    <p class="tx-12"><a href="">http://bracketstore.com</a></p>
                    <div class="row align-items-center">
                        <div class="col-4 tx-12 tx-inverse tx-medium">Visits</div>
                        <div class="col-8">
                            <div class="progress rounded-0 mg-b-0">
                                <div class="progress-bar bg-pink wd-25p lh-3" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
                            </div><!-- progress -->
                        </div><!-- col-8 -->
                    </div><!-- row -->
                    <div class="row align-items-center mg-t-5">
                        <div class="col-4 tx-12 tx-inverse tx-medium">Impressions</div>
                        <div class="col-8">
                            <div class="progress rounded-0 mg-b-0">
                                <div class="progress-bar bg-indigo wd-45p lh-3" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100">45%</div>
                            </div><!-- progress -->
                        </div><!-- col-8 -->
                    </div><!-- row -->
                    <p class="tx-11 mg-b-0 mg-t-15">Notice: Lorem ipsum dolor sit amet.</p>
                </div><!-- card-body -->
            </div><!-- card -->
        </div><!-- col-4 -->
    </div><!-- row -->
    <div class="card  bd-0 mg-t-20">
        <div class="card-header bg-transparent pd-x-25 pd-y-15 bd-b-0 d-flex justify-content-between align-items-center">
            <h6 class="card-title tx-uppercase tx-12 mg-b-0">Storage Overview</h6>
            <a href="" class="tx-gray-500 hover-info lh-0"><i class="icon ion-android-more-horizontal tx-24 lh-0"></i></a>
        </div><!-- card-header -->
        <div class="card-body pd-x-25 pd-b-25 pd-t-0">
            <div class="row no-gutters">
                <div class="col-sm-6 col-lg-3">
                    <div class="card card-body rounded-0">
                        <h6 class="tx-inverse tx-14 mg-b-5">Engineering Dept</h6>
                        <span class="tx-12">Path: /nas1/volume1</span>
                        <div class="tx-center mg-y-20">
                            <span class="peity-donut" data-peity='{ "fill": ["#17A2B8", "#E9ECEF"],  "innerRadius": 50, "radius": 80 }'>45/100</span>
                        </div>
                        <p class="tx-10 tx-uppercase tx-medium mg-b-0 tx-spacing-1">Storage Size</p>
                        <h2 class="tx-inverse tx-bold tx-lato">
                            <span>0.98TB</span>
                        </h2>
                        <div class="d-flex justify-content-between tx-12">
                            <div>
                                <span class="square-10 bg-info mg-r-5"></span> 396 GB used
                                <h5 class="mg-b-0 mg-t-5 tx-bold tx-inverse tx-lato">45%</h5>
                            </div>
                            <div>
                                <span class="square-10 bg-gray-300 mg-r-5"></span> 594 GB free
                                <h5 class="mg-b-0 mg-t-5 tx-bold tx-inverse tx-lato">65%</h5>
                            </div>
                        </div><!-- d-flex -->
                    </div><!-- card -->
                </div><!-- col-3 -->
                <div class="col-sm-6 col-lg-3 mg-t--1 mg-sm-t-0 mg-lg-l--1">
                    <div class="card card-body rounded-0 bd-lg-l-0">
                        <h6 class="tx-inverse tx-14 mg-b-5">Sales Dept</h6>
                        <span class="tx-12">Path: /nas1/volume2</span>
                        <div class="tx-center mg-y-20">
                            <span class="peity-donut" data-peity='{ "fill": ["#6F42C1", "#E9ECEF"],  "innerRadius": 50, "radius": 80 }'>70/100</span>
                        </div>
                        <p class="tx-10 tx-uppercase tx-medium mg-b-0 tx-spacing-1">Storage Size</p>
                        <h2 class="tx-inverse tx-bold tx-lato">
                            <span>0.98TB</span>
                        </h2>
                        <div class="d-flex justify-content-between tx-12">
                            <div>
                                <span class="square-10 bg-purple mg-r-5"></span> 698 GB used
                                <h5 class="mg-b-0 mg-t-5 tx-inverse tx-lato tx-bold">69%</h5>
                            </div>
                            <div>
                                <span class="square-10 bg-gray-300 mg-r-5"></span> 291 GB free
                                <h5 class="mg-b-0 mg-t-5 tx-inverse tx-lato tx-bold">29%</h5>
                            </div>
                        </div><!-- d-flex -->
                    </div><!-- card -->
                </div><!-- col-3 -->
                <div class="col-sm-6 col-lg-3 mg-t--1 mg-lg-t-0 mg-lg-l--1">
                    <div class="card card-body rounded-0">
                        <h6 class="tx-inverse tx-14 mg-b-5">Admin Dept</h6>
                        <span class="tx-12">Path: /nas1/volume3</span>
                        <div class="tx-center mg-y-20">
                            <span class="peity-donut" data-peity='{ "fill": ["#20C997", "#E9ECEF"],  "innerRadius": 50, "radius": 80 }'>60/100</span>
                        </div>
                        <p class="tx-10 tx-uppercase tx-medium mg-b-0 tx-spacing-1">Storage Size</p>
                        <h2 class="tx-inverse tx-bold tx-lato">
                            <span>1.95TB</span>
                        </h2>
                        <div class="d-flex justify-content-between tx-12">
                            <div>
                                <span class="square-10 bg-teal mg-r-5"></span> 404 GB used
                                <h5 class="mg-b-0 mg-t-5 tx-inverse tx-bold tx-lato">21%</h5>
                            </div>
                            <div>
                                <span class="square-10 bg-gray-300 mg-r-5"></span> 1.59 GB free
                                <h5 class="mg-b-0 mg-t-5 tx-inverse tx-bold tx-lato">79%</h5>
                            </div>
                        </div><!-- d-flex -->
                    </div><!-- card -->
                </div><!-- col-3 -->
                <div class="col-sm-6 col-lg-3 mg-t--1 mg-lg-t-0 mg-lg-l--1">
                    <div class="card card-body rounded-0">
                        <h6 class="tx-inverse tx-14 mg-b-5">Finance Dept</h6>
                        <span class="tx-12">Path: /nas1/volume4</span>
                        <div class="tx-center mg-y-20">
                            <span class="peity-donut" data-peity='{ "fill": ["#0866C6", "#E9ECEF"],  "innerRadius": 50, "radius": 80 }'>75/100</span>
                        </div>
                        <p class="tx-10 tx-uppercase tx-medium mg-b-0 tx-spacing-1">Storage Size</p>
                        <h2 class="tx-inverse tx-bold tx-lato">
                            <span>1.95TB</span>
                        </h2>
                        <div class="d-flex justify-content-between tx-12">
                            <div>
                                <span class="square-10 bg-primary mg-r-5"></span> 404 GB used
                                <h5 class="mg-b-0 mg-t-5 tx-inverse tx-bold tx-lato">21%</h5>
                            </div>
                            <div>
                                <span class="square-10 bg-gray-300 mg-r-5"></span> 1.59 GB free
                                <h5 class="mg-b-0 mg-t-5 tx-inverse tx-bold tx-lato">79%</h5>
                            </div>
                        </div><!-- d-flex -->
                    </div><!-- card -->
                </div><!-- col-3 -->
            </div><!-- row -->
        </div><!-- card-body -->
    </div><!-- card -->
    </div>
@endsection
