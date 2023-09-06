@extends('admin.layouts.master')


@section('admin.content')

    <div class="content-page">
        <div class="content">
            <h4 class="page-title">All States</h4>
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
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#centermodal">Add New State &nbsp; &nbsp; <i
                                    class="fa-solid fa-circle-plus"></i></button>
                        </div>

                        {{--                            @dd($allCountries)--}}

                        {{--Start Add Country Center Modal--}}
                        <div class="modal fade" id="centermodal" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myCenterModalLabel">Add New State</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-hidden="true"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{route('store.user.state')}}" method="post">
                                            @csrf
                                            <label class="form-label" for="validationCustom01">Country Name</label>
                                            <select class="js-example-basic-single country" name="country">
                                                <option selected value="">Select Country</option>
                                                {{--                                                    @dd($allCountries)--}}
                                                @foreach($allCountries as $country)

                                                    <option
                                                        value="{{$country->id}}">{{$country->country}}
                                                    </option>
                                                @endforeach

                                            </select>

                                            @error('country')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror

                                            <label class="form-label" for="validationCustom01">State Name</label>
                                            <input type="text" name="state" class="form-control" id="validationCustom01"
                                                   placeholder="State Name....">

                                            @error('state')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                                    Close
                                                </button>
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
                                <th>State Name</th>
                                <th>Country Name</th>
                                <th>Action</th>
                            </tr>
                            </thead>


                            <tbody>

{{--                            @dd($allStates)--}}

                            @foreach($allStates as $state)
                                <tr>
                                    <td>{{$idx++}}</td>

                                    <td class="state_name" data-id="{{$state->id}}">{{$state->name}}</td>
                                    <td class="country_id" >{{$state->countries->country}} </td>
                                    <td>
                                        <button data-cid="{{$state->countries->id}}" class="btn btn-warning btnEdit" data-bs-toggle="modal"
                                                data-bs-target="#centermodal1"><i
                                                class=" fa-solid fa-pen-to-square"></i></button>
                                        {{--                                        <a href="" class="btn btn-warning">Edit</a>--}}
                                        <a href="{{route('user.delete.state',$state->id)}}" class="btn btn-danger">Delete</a>
                                    </td>
                                </tr>
                            @endforeach

                            {{--Start Edit Category Center Modal--}}
                            <div class="modal fade" id="centermodal1" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myCenterModalLabel">Edit State</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-hidden="true"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{route('updte.user.state')}}" method="post">
                                                <input type="hidden" id="sid" value="" name="stateId">
                                                @csrf
                                                <label class="form-label" for="validationCustom01">Country Name</label>
                                                <select class="js-example-basic-single country1" name="country">
                                                    <option selected value="">Select Country</option>
{{--                                                                                                        @dd($allCountries)--}}
                                                    @foreach($allCountries as $country)

                                                        <option
                                                            value="{{$country->id}}">{{$country->country}}
                                                        </option>
                                                    @endforeach

                                                </select>

                                                @error('country')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror

                                                <label class="form-label" for="validationCustom01">State Name</label>
                                                <input type="text" name="state" class="form-control" id="sname"
                                                       placeholder="State Name....">

                                                @error('state')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                                        Close
                                                    </button>
                                                    <button type="submit" class="btn btn-primary">Save changes</button>
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"
            integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function () {
            $('.btnEdit').on('click', function () {
                let currentRow = $(this).closest('tr');
                let state_name = currentRow.find('.state_name').html();
                let state_id = currentRow.find('.state_name').data('id');
                let country_id = $(this).attr('data-cid');


                $("#sname").val(state_name);
                $("#sid").val(state_id);
                $(".country1").val(country_id).change();

            })
        })
    </script>

    <script>
        $(document).ready(function () {
            $('.js-example-basic-single').select2();
        });
        $(document).ready(function () {
            $('.js-example-basic-multiple').select2();
        });
    </script>

@endsection
