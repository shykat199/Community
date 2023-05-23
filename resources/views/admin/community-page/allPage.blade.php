@extends('admin.layouts.master')


@section('admin.content')

    <div class="content-page">
        <div class="content">
            <h4 class="page-title">Groups</h4>
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
                                <th>Group Like</th>
                                <th>Group Follow</th>
                                <th>Action</th>
                            </tr>
                            </thead>


                            <tbody>

{{--                            @dd($pageOwners)--}}

                            @foreach($pageOwners as $page)
                                <tr>
                                    <td>{{$idx++}}</td>
                                    <td>{{$page->page_name}}</td>
                                    <td>{{$page->ownerName}}</td>
                                    <td><img src="{{asset('storage/community/page-post/profile/'.$page->page_profile_photo)}}" alt="" style="height: 40px; width: 50px;"></td>

{{--                                    <td>{{$page->page_profile_photo}}</td>--}}
                                    <td>{{Str::limit($page->page_details,40,'....')}}</td>
                                    <td>{{$page->likeCounts}}</td>
                                    <td>{{$page->followCounts}}</td>
                                    <td>

                                        <a href="{{route('user.page.all.post',$page->id)}}" class="btn btn-warning">Click Post</a>
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
