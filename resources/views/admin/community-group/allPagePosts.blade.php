@extends('admin.layouts.master')

@section('admin.content')

    <div class="content-page">
        <div class="content">
            <h4 class="page-title">Page Posts</h4>
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
                                <th>Page Post Description</th>
                                <th>Post Comments</th>
                                <th>Page User</th>
                                <th>Action</th>
                            </tr>
                            </thead>


                            <tbody>

                            @foreach($allGroupPosts as $pagePosts)
                                <tr>
                                    <td>{{$idx++}}</td>
                                    <td>{{$pagePosts->page_name}}</td>
                                    <td>{{Str::limit($pagePosts->post_description,49,'....')}}</td>
                                    <form action="{{route('community.page.posts.comment')}}" method="get">
                                        <input type="hidden" name="pagePostId" value="{{$pagePosts->id}}"/>
                                        <td><button type="submit" class="btn btn-info">Comment</button></td>
                                    </form>
                                    <td>{{$pagePosts->name}}</td>

                                    <td>
                                        <button class="btn btn-warning btnEdit" data-bs-toggle="modal" data-bs-target="#centermodal1"><i
                                                class=" fa-solid fa-pen-to-square"></i></button>
                                        <a href="" class="btn btn-danger"><i
                                                class=" fa-solid fa-trash"></i></a>
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
