@extends('admin.layouts.master')

@section('admin.content')
{{--    @dd($userPost)--}}
    <div class="content-page">
        <div class="content">
            <h4 class="page-title">Owner Name: {{isset($allGroupPost[0])?$allGroupPost[0]->name:''}}</h4>
{{--            <h4 class="page-title">Group Owner: {{isset($allGroupPost[0])?$allGroupPost[0]->group_name:''}}</h4>--}}
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
                                <th>Post Description</th>
                                <th>Post Owner</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>


                            <tbody>
{{--                            @dd($allGroupPost)--}}
                            @foreach($userPost as $group)
                                <tr>
                                    <td>{{$idx++}}</td>
                                    <td>{{\Illuminate\Support\Str::limit($group->post_description,60,'...')}}</td>
                                    <td>{{$group->name}}</td>
                                    <td>{{\Carbon\Carbon::parse($group->created_at)->format('d-M-Y')}}</td>
{{--                                    <td>{{Str::limit($group->group_details,40,'....')}}</td>--}}
{{--                                    <td>{{$group->userCount}}</td>--}}
                                    <td>
                                        <a href="{{route('community.user.check-post-comment',$group->uPostId)}}" class="btn btn-warning">Check Comments !</a>
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
