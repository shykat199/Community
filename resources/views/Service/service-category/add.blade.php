@extends('Admin.layouts.master')

@section('admin.content')

    <div class="content-page">
        <div class="content">

    <div class="container float-right">
        <div class="card">
            <div class="card-header">

            </div>
            <div class="card-body">

                @if(\Illuminate\Support\Facades\Session::has('success'))
                    <div class="alert alert-success">
                        {{\Illuminate\Support\Facades\Session::get('success')}}
                    </div>
                @endif



                <form action="{{route('category.post')}}" method="post" enctype="multipart/form-data">
                    @method('POST')
                    @csrf
                    {{-- <div class="card-body">
                      <div class="form-group">
                        <label for="exampleInputtitle">user_id</label>
                        <input name="user_id" type="user_id" class="form-control" id="exampleInputuser_id" placeholder="Enter user_id">
                      </div>
                      @error('user_id')
                      <span class="text-danger">{{$message}}</span>
                      @enderror --}}


                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputtitle">Title</label>
                            <input name="name" type="name" class="form-control" id="exampleInputTitle" placeholder="Enter name of service">
                        </div>
                        @error('name')
                        <span class="text-danger">{{$message}}</span>
                        @enderror


                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">Check me out</label>
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
        </div>
    </div>

@endsection
