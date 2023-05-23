@extends('admin.layouts.master')


@section('admin.content')

    <div class="content-page">
        <div class="content">
            <h4 class="page-title">All Cities</h4>
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
                                    data-bs-target="#centermodal">Add New City &nbsp; &nbsp; <i
                                    class="fa-solid fa-circle-plus"></i></button>
                        </div>

                        <div class="modal fade" id="centermodal" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myCenterModalLabel">Add New City</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-hidden="true"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{route('store.user.city')}}" method="post">

                                            @csrf
                                            <label class="form-label" for="validationCustom01">Country Name</label>
                                            <select class="js-example-basic-single country-dropdown" id="country-dropdown1" name="country">
                                                <option selected value="">Select Country</option>
                                                {{--                                                    @dd($allCountries)--}}
                                                @foreach($allCountries as $country)

                                                    <option value="{{$country->id}}">{{$country->country}}
                                                    </option>
                                                @endforeach

                                            </select>

                                            @error('country')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror

                                            <label class="form-label" for="validationCustom01">State Name</label>
                                            <select class="js-example-basic-single state-dropdown" id="state-dropdown1" name="state">
                                                <option selected value="">Select Country</option>

                                            </select>

                                            @error('country')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror

                                            <label class="form-label" for="validationCustom01">City Name</label>
                                            <input type="text" name="city" class="form-control" id="validationCustom01"
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
                                <th>Country Name</th>
                                <th>State Name</th>
                                <th>City Name</th>
                                <th>Action</th>
                            </tr>
                            </thead>


                            <tbody>

{{--                            @dd($allCities)--}}

                            @foreach($allCities as $city)
                                <tr>
                                    <td>{{$idx++}}</td>

                                    <td class="country_name" data-id="{{$city->states->countries->id}}">{{$city->states->countries->country}}</td>
                                    <td class="state_name" >{{$city->states->name}} </td>
                                    <td class="city_name" >{{$city->city}} </td>
                                    <td>
                                        <button data-cityId="{{$city->id}}" data-cid="{{$city->states->countries->id}}" data-sid="{{$city->states->id}}" class="btn btn-warning btnEdit" data-bs-toggle="modal"
                                                data-bs-target="#centermodal1"><i
                                                class=" fa-solid fa-pen-to-square"></i></button>
                                        <a href="{{route('user.delete.city',$city->id)}}" class="btn btn-danger">Delete</a>
                                    </td>
                                </tr>
                            @endforeach

                            {{--Start Edit Category Center Modal--}}
                            <div class="modal fade" id="centermodal1" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myCenterModalLabel">Edit New City</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-hidden="true"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{route('update.user.city')}}" method="post">
                                                @csrf
                                                <input type="hidden" value="" name="cityId" id="cityId">
                                                <label class="form-label" for="validationCustom01">Country Name</label>
                                                <select class="js-example-basic-single  country-dropdown" id="country-dropdown2" name="country">
                                                    <option selected value="">Select Country</option>
                                                    {{--                                                    @dd($allCountries)--}}
                                                    @foreach($allCountries as $country)

                                                        <option value="{{$country->id}}">
                                                            {{$country->country}}
                                                        </option>
                                                    @endforeach

                                                </select>

                                                @error('country')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror

                                                <label class="form-label" for="validationCustom01">State Name</label>

                                                <select class="js-example-basic-single  state-dropdown" id="state-dropdown" name="state">

                                                    <option selected value="">Select State</option>

                                                    @foreach($allStates as $state)

                                                        <option value="{{$state->id}}">
                                                            {{$state->name}}
                                                        </option>
                                                    @endforeach

                                                </select>

                                                @error('country')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror

                                                <label class="form-label" for="validationCustom01">City Name</label>
                                                <input type="text" name="city" class="form-control" id="c-name"
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
                let city_name = currentRow.find('.city_name').html();
                let country_id = $(this).attr('data-cid');
                let state_id = $(this).attr('data-sid');
                let city_id = $(this).attr('data-cityId');

                console.log(state_id);

                $("#c-name").val(city_name);
                $("#cityId").val(city_id);
                $(".country-dropdown").val(country_id).change();
                $(".state-dropdown").val(state_id).change();

            })


            $('.country-dropdown').on('change', function () {
                let country_id = this.value;
                // console.log(idCountry);
                $(".state-dropdown").html('');
                // return false;
                $.ajax({
                    url: "{{route('get.state.on-country-change')}}",
                    type: "GET",
                    data: {
                        country_id: country_id,
                        {{--_token: '{{csrf_token()}}'--}}
                    },
                    dataType: 'json',
                    success: function (result) {
                        $('.state-dropdown').html('<option value="">-- Select State --</option>');
                        $.each(result.getStates, function (key, value) {
                            $(".state-dropdown").append('<option value="' + value
                                .id + '">' + value.name + '</option>');
                        });
                        // $('#city-dropdown').html('<option value="">-- Select City --</option>');
                    }
                });
            });


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
