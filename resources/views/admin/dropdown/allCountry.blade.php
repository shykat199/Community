@extends('admin.layouts.master')


@section('admin.content')

    <div class="content-page">
        <div class="content">
            <h4 class="page-title">All Country</h4>
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

                            <div class="mb-2">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#centermodal">Add New Country &nbsp; &nbsp; <i class="fa-solid fa-circle-plus"></i></button>
                            </div>

                            {{--Start Add Country Center Modal--}}
                            <div class="modal fade" id="centermodal" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myCenterModalLabel">Add New Country</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{route('store.user.country')}}" method="post">
                                                @csrf
                                                <label class="form-label" for="validationCustom01">Country Name</label>
                                                <input type="text" name="country" class="form-control" id="validationCustom01"
                                                       placeholder="Country Name....">

                                                @error('country')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{--End Add Country Modal--}}


                        <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                            <thead>
                            <tr>
                                <th>#ID</th>
                                <th>Country Name</th>
                                <th>Action</th>
                            </tr>
                            </thead>


                            <tbody>

                            @foreach($allCountries as $country)
                                <tr>
                                    <td>{{$idx++}}</td>

                                    <td class="country_name" data-id="{{$country->id}}">{{$country->country}}</td>
{{--                                    <td>{{$country->country}}</td>--}}
                                    <td>
                                        <button class="btn btn-warning btnEdit" data-bs-toggle="modal" data-bs-target="#centermodal1"><i class=" fa-solid fa-pen-to-square"></i></button>
{{--                                        <a href="" class="btn btn-warning">Edit</a>--}}
                                        <a href="{{route('user.delete.country',$country->id)}}" class="btn btn-danger">Delete</a>
                                    </td>
                                </tr>
                            @endforeach

                            {{--Start Edit Category Center Modal--}}
                            <div class="modal fade" id="centermodal1" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myCenterModalLabel">Update Country Name</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="" method="post">
                                                @csrf

                                                <input type="hidden" name="company_id" id="c_id">

                                                <label class="form-label" for="validationCustom01">Country Name</label>
                                                <input type="text" name="bus_company"  class="form-control" id="c_name"
                                                       placeholder="Company Name....">

                                                @error('company_name')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--End Edit Category Modal--}}
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function (){
            $('.btnEdit').on('click',function (){
                let currentRow=$(this).closest('tr');
                let country_name=currentRow.find('.country_name').html();
                let country_id=currentRow.find('.company_name').data('id');

                $("#c_name").val(country_name);
                $("#c_id").val(country_id);
            })
        })
    </script>

@endsection
