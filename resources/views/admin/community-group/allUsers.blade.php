@extends('admin.layouts.master')


@section('admin.content')

    <div class="content-page">
        <div class="content">
            <h4 class="page-title">All Users</h4>
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
                                <th>Group Name</th>
                                <th>Group Admin</th>
                                <th>Group Image</th>
                                <th>Group Description</th>
                                <th>Action</th>

                            </tr>
                            </thead>


                            <tbody>

                            @foreach($allGroups as $group)
                                <tr>
                                    <td>{{$idx++}}</td>
                                    <td>{{$group->group_name}}</td>
                                    <td>{{$group->ownerName}}</td>
                                    <td>Image</td>
                                    <td>{{Str::limit($group->group_details,30,'....')}}</td>

                                    <td>
                                        <a href="{{route('community.allUser.details.groups',$group->cGroupId)}}" class="btn btn-warning">
                                            Check Users !</a>


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
