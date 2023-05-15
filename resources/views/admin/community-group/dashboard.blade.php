@extends('admin.layouts.master')

@section('admin.content')

    <div class="content-page">
        <div class="content">
            <h4 class="page-title">Pages Dashboard</h4>
            <div class="">
                <div class="card mt-2">

                    <div class="card-body">

                        @if(\Illuminate\Support\Facades\Session::has('success'))
                            <div class="alert alert-success">
                                {{\Illuminate\Support\Facades\Session::get('success')}}
                            </div>
                        @endif

                        @if(\Illuminate\Support\Facades\Session::has('error'))
                            <div class="alert alert-success">
                                {{\Illuminate\Support\Facades\Session::get('error')}}
                            </div>
                        @endif

                            <div class="row">
                                <div class="col">
                                    <div class="card border-success border widget-flat">
                                        <div class="card-body">
                                            <div class="float-end">
                                                <i class="mdi mdi-account-multiple widget-icon"></i>
                                            </div>
                                            <h5 class="text-muted fw-normal mt-0" title="Number of Customers">All Group Count</h5>
                                            <h3 class="mt-3 mb-3"></h3>
                                            <p class="mb-0 text-muted">
                                                <span class="text-nowrap">Since last month</span>
                                            </p>
                                        </div> <!-- end card-body-->
                                    </div> <!-- end card-->
                                </div> <!-- end col-->
<!-- end col-->

                                <div class="col">
                                    <div class="card border-success border widget-flat">
                                        <div class="card-body">
                                            <div class="float-end">
                                                <i class="mdi mdi-cart-plus widget-icon"></i>
                                            </div>
                                            <h5 class="text-muted fw-normal mt-0" title="Number of Orders">Group Post Count</h5>
                                            <h3 class="mt-3 mb-3"></h3>
                                            <p class="mb-0 text-muted">
                                                <span class="text-nowrap">Since last month</span>
                                            </p>
                                        </div> <!-- end card-body-->
                                    </div> <!-- end card-->
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="card border-success border widget-flat">
                                        <div class="card-body">
                                            <div class="float-end">
                                                <i class="mdi mdi-account-multiple widget-icon"></i>
                                            </div>
                                            <h5 class="text-muted fw-normal mt-0" title="Number of Customers">All Comment Count</h5>
                                            <h3 class="mt-3 mb-3"></h3>
                                            <p class="mb-0 text-muted">
                                                <span class="text-nowrap">Since last month</span>
                                            </p>
                                        </div> <!-- end card-body-->
                                    </div> <!-- end card-->
                                </div> <!-- end col-->

                                <div class="col">

                                </div> <!-- end col-->
                                <div class="col">

                                </div> <!-- end col-->
                                <div class="col">

                                </div> <!-- end col-->

                            </div>



                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
