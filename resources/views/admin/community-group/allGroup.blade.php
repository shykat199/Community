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
                                <th>Group Name</th>
                                <th>Group Owner</th>
                                <th>Group Image</th>
                                <th>Group Description</th>
                                <th>Group User Count</th>
                                <th>Action</th>
                            </tr>
                            </thead>


                            <tbody>
{{--                            @dd($allGroups)--}}
                            @foreach($allGroups as $group)
                                <tr>
                                    <td>{{$idx++}}</td>
                                    <td>{{$group->group_name}}</td>
                                    <td>{{$group->ownerName}}</td>
                                    <td><img src="{{asset('storage/community/group-post/profile/'.$group->group_profile_photo)}}" alt="" style="height: 40px; width: 50px;"></td>
                                    <td>{{Str::limit($group->group_details,40,'....')}}</td>
                                    <td>{{$group->userCount}}</td>
                                    <td>
                                        <a href="{{route('user.group.all.post',$group->cGroupId)}}" class="btn btn-warning">Click !</a>
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
