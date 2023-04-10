@extends('admin.layouts.master')


@section('admin.content')

    <div class="content-page">
        <div class="content">
            <h4 class="page-title">Pages</h4>
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

                            @php
                                $idx=1;
                            @endphp


                        <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                            <thead>
                            <tr>
                                <th>#ID</th>
                                <th>Page Name</th>
                                <th>Page Owner</th>
                                <th>Page Image</th>
                                <th>Page Description</th>
                                <th>Page User Count</th>
                                <th>Page Like</th>
                                <th>Page Follow</th>
                                <th>Action</th>
                            </tr>
                            </thead>


                            <tbody>

                            @foreach($pageOwners as $page)
                                <tr>
                                    <td>{{$idx++}}</td>
                                    <td>{{$page->page_name}}</td>
                                    <td>{{$page->name}}</td>
                                    <td>{{$page->page_profile_photo}}</td>
                                    <td>{{Str::limit($page->page_details,40,'....')}}</td>
                                    <td>$320,800</td>
                                    <td>$320,800</td>
                                    <td>{{$page->followCount}}</td>
                                    <td>
                                        <a href="" class="btn btn-warning">Click !</a>
                                    </td>
                                </tr>
                            @endforeach


                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
