@extends('admin.layouts.master')


@section('admin.content')

    <div class="content-page">
        <div class="content">
            <h4 class="page-title">All Group Users</h4>
            <h4 class="page-title">Group Name: {{$allGroupUser[0]['group_name']}}</h4>
{{--            @dd($allGroupUser[0]['group_name'])--}}
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
                                <th>User Name</th>
                                <th>User Email</th>
                                <th>Action</th>

                            </tr>
                            </thead>


                            <tbody>


                            @foreach($allGroupUser as $group)
                                <tr>
                                    <td>{{$idx++}}</td>
                                    <td>{{$group->name}}</td>
                                    <td>{{$group->email}}</td>
                                    <td>
                                        <a href="{{route('community.groups.singleUser.details',$group->uId)}}" class="btn btn-warning">
                                            User Profile !</a>
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
