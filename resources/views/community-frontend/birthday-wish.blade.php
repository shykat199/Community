@extends('community-frontend.layout.frontend_master')

@section('frontend.others.birthday')

    <!-- birthday hero start  -->
    <div class="main-profile">
        <div class="row">
            <div class="col-lg-12">
                <div class="full-profile-box">
                    <div class="full-profile-cover">
                        <img
                            src="{{asset("community-frontend/assets/images/community/myProfile/my-profile-cover.jpg")}}"
                            alt="cover">
                        <div class="page-name">
                            Birthday
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- birthday hero end  -->

@endsection

@section('frontend.content')

    <!-- all notification area start  -->
    <div class="privacy-page-wrap common-box">
        <!-- birthday title start  -->
        <h5 class="setting-title">Today Birthday</h5>
        <!-- birthday title end  -->
        <!-- today Birthday list start  -->
        <ul class="like-items birthday-widget">
            @if(count($todayBirthdays)>0)
                @foreach($todayBirthdays as $todayBirthday)
                    <li class="single-wish">
                        <div class="right-wdget-img"><a href="#"><img
                                    src="{{asset("community-frontend/assets/images/community/home/right/birthday01.jpg")}}"
                                    alt="img"></a></div>
                        <div class="page-title">
                            <a href="#">{{$todayBirthday->userName}}</a>
                            <span class="date">{{\Carbon\Carbon::now()->format('d F , Y')}}</span>
                            <form action="{{route('user.friend.birthday.wishMessage')}}" class="birthday-wish"
                                  method="post">
                                @csrf
                                <button type="button" class="emoji-btn"><i class="fa fa-meh-o" aria-hidden="true"></i>
                                </button>
                                <input type="text" name="message" placeholder="Write something">
                                <input type="hidden" name="wished_user_id" value="{{$todayBirthday->Uid}}"
                                       placeholder="Write something">
                                <button type="submit" class="social-theme-btn wish-send-btn">Send</button>
                            </form>
                        </div>
                    </li>

                @endforeach
            @else
                <span>No Data Found</span>
            @endif



        </ul>

        <!-- upcoming birthdays  start -->
        <div class="upcoming-birthday-wrap">
            <h5 class="setting-title">Upcoming Birthdayy</h5>
            <div class="upcoming-birthday-list">
                <div class="row">
                    @foreach(getUpComingBirthday() as $recentBirthday)

                        <div class="col-lg-4 col-md-4">
                            <div class="single-info">
                                <div class="page-img"><a href="#"><img
                                            src="{{asset("community-frontend/assets/images/community/home/right/birthday01.jpg")}}"
                                            alt="img"></a></div>
                                <div class="page-title">
                                    <a href="#">{{$recentBirthday->userName}}</a>
                                    <span
                                        class="date">{{\Carbon\Carbon::parse($recentBirthday->dob)->format('d F')}}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>

        <!-- Monthly birthdays  start -->

        @foreach(allMonths() as $months)

            <div class="upcoming-birthday-wrap">
                <h5 class="setting-title">{{$months}}</h5>
                <div class="upcoming-birthday-list">
                    <div class="row">
                        @foreach($getAllBirthdays as $birthday)
                            {{--                            @dd($birthday)--}}
                            @if(\Carbon\Carbon::parse($birthday->dob)->format('F') === $months)
                                <div class="col-lg-4 col-md-4">
                                    <div class="single-info">
                                        <div class="page-img"><a href="#"><img
                                                    src="{{asset("community-frontend/assets/images/community/home/right/birthday01.jpg")}}"
                                                    alt="img"></a></div>
                                        <div class="page-title">
                                            <a href="#">{{$birthday->name}}</a>
                                            <span
                                                class="date">{{Carbon\Carbon::parse($birthday->dob)->format('d F')}}</span>
                                        </div>
                                    </div>
                                </div>

                            @endif

                        @endforeach
                    </div>
                </div>
            </div>

        @endforeach


        <!-- upcoming birthdays  end -->

    </div>
    <!-- all notification area start  -->

    @include('community-frontend.layout.liveChat')

@endsection
