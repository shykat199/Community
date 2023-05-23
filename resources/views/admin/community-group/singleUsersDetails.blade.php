@extends('admin.layouts.master')

@section('admin.content')

{{--    @dd($allGroupPost)--}}

@dd($singleUser)

    <div class="content-page">
        <div class="content">
            <div class="d-flex">

                <h4 class="page-title">{{!empty($singleUser) && isset($singleUser)?$singleUser[0]['name']:''}} Details</h4>
                <a href="{{route('community.groups.singleUser.profile',!empty($singleUser) && isset($singleUser)?$singleUser[0]['uId']:'')}}" class="btn btn-success mb-1 mt-1" style="margin-left: 5px;">GoTo Profile</a>
            </div>

            <div class="card border-success border">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">

                                <label for="exampleInputEmail1" class="form-label">User Name</label>
                                <input readonly type="email" class="form-control" value="{{!empty($singleUser) && isset($singleUser)?$singleUser[0]['name']:''}}" id="exampleInputEmail1" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">User Email</label>
                                <input readonly type="email" class="form-control" value="{{!empty($singleUser) && isset($singleUser)?$singleUser[0]['email']:''}}" id="exampleInputPassword1">
                            </div>


                        </div>
                        <div class="col">

                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Date Of Birth</label>
                                <input readonly type="email" class="form-control" value="{{!empty($singleUser) && isset($singleUser)?$singleUser[0]['dob']:''}}" id="?exampleInputEmail1" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Birth Place</label>
                                <input readonly type="text" class="form-control" value="{{!empty($singleUser) && isset($singleUser)?$singleUser[0]['birthplace']:''}}" id="exampleInputPassword1">
                            </div>


                        </div>
                    </div>
                    <div class="row">
                        <div class="col">

                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Phone</label>
                                <input readonly type="email" class="form-control" value="{{!empty($singleUser) && isset($singleUser)?$singleUser[0]['phone']:''}}" id="?exampleInputEmail1" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Gender</label>
                                <input readonly type="text" class="form-control" value="{{!empty($singleUser) && isset($singleUser)?$singleUser[0]['gender']:''}}" id="exampleInputPassword1">
                            </div>


                        </div>
                        <div class="col">

                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Relationship</label>
                                <input readonly type="email" class="form-control" value="{{!empty($singleUser) && isset($singleUser)?$singleUser[0]['relationship']:''}}" id="?exampleInputEmail1" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Blood Group</label>
                                <input readonly type="txt" class="form-control" value="{{!empty($singleUser) && isset($singleUser)?$singleUser[0]['blood']:''}}" id="exampleInputPassword1">
                            </div>


                        </div>
                    </div>
                    <div class="row">
                        <div class="col">

                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Website</label>
                                <input readonly type="email" class="form-control" value="{{!empty($singleUser) && isset($singleUser)?$singleUser[0]['website']:''}}" id="?exampleInputEmail1" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">About me</label>
                                <textarea readonly type="password" rows="7" class="form-control" id="exampleInputPassword1">{{!empty($singleUser) && isset($singleUser)?$singleUser[0]['about_me']:''}}</textarea>
                            </div>


                        </div>

                    </div>
                </div>

            </div>


        </div>
    </div>

@endsection
