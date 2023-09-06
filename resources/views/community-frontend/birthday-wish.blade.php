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

{{--                @dd($todayBirthday)--}}

                    @if($todayBirthday->message===null)
                        <li class="single-wish">
                            {{--                            @dd($todayBirthday)--}}
                            <div class="right-wdget-img">

                                @if(!empty($todayBirthday->userProfileImages[0]) && isset($todayBirthday->userProfileImages[0])?$todayBirthday->userProfileImages[0]:'')

                                    @if(!empty($todayBirthday->userProfileImages[0]) && isset($todayBirthday->userProfileImages[0])?$todayBirthday->userProfileImages[0]:'')
                                        <a href=""><img
                                                src="{{asset("storage/community/profile-picture/".$todayBirthday->userProfileImages[0]->user_profile)}}"
                                                alt="image"></a>
                                    @else
                                        <a href=""><img
                                                src="{{asset("community-frontend/assets/images/community/home/news-post/Athore01.jpg")}}"
                                                alt="image"></a>
                                    @endif
                                @else

                                    <a href=""><img
                                            src="{{asset("community-frontend/assets/images/community/home/news-post/Athore01.jpg")}}"
                                            alt="image"></a>
                                @endif

                            </div>
                            <div class="page-title">
                                <a href="#">{{$todayBirthday->userName}}</a>
                                <span class="date">{{\Carbon\Carbon::now()->format('d F , Y')}}</span>
                                <form action="{{route('user.friend.birthday.wishMessage')}}" class="birthday-wish"
                                      method="post">
                                    @csrf
                                    <button type="button" class="emoji-btn"><i class="fa fa-meh-o"
                                                                               aria-hidden="true"></i>
                                    </button>
                                    <input type="text" name="message" placeholder="Write something">
                                    <input type="hidden" name="wished_user_id" value="{{$todayBirthday->Uid}}"
                                           placeholder="Write something">
                                    <button type="submit" class="social-theme-btn wish-send-btn">Send</button>
                                </form>
                            </div>

                        </li>
                    @endif



                @endforeach
            @else
                <span>No Data Found</span>
            @endif


        </ul>

        <!-- upcoming birthdays  start -->
        <div class="upcoming-birthday-wrap">
            <h5 class="setting-title">Upcoming Birthday</h5>
            <div class="upcoming-birthday-list">
                <div class="row">
                    @foreach(getUpComingBirthday() as $recentBirthday)

                        <div class="col-lg-4 col-md-4">
                            <div class="single-info">
                                <div class="page-img">

                                    @if(!empty($todayBirthday->userProfileImages[0]) && isset($todayBirthday->userProfileImages[0])?$todayBirthday->userProfileImages[0]:'')

                                        @if(!empty($todayBirthday->userProfileImages[0]) && isset($todayBirthday->userProfileImages[0])?$todayBirthday->userProfileImages[0]:'')
                                            <a href=""><img
                                                    src="{{asset("storage/community/profile-picture/".$todayBirthday->userProfileImages[0]->user_profile)}}"
                                                    alt="image"></a>
                                        @else
                                            <a href=""><img
                                                    src="{{asset("community-frontend/assets/images/community/home/news-post/Athore01.jpg")}}"
                                                    alt="image"></a>
                                        @endif
                                    @else

                                        <a href=""><img
                                                src="{{asset("community-frontend/assets/images/community/home/news-post/Athore01.jpg")}}"
                                                alt="image"></a>
                                    @endif

{{--                                    <a href="#"><img--}}
{{--                                            src="{{asset("community-frontend/assets/images/community/home/right/birthday01.jpg")}}"--}}
{{--                                            alt="img"></a>--}}

                                </div>
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
                        {{--                        @dd($getAllBirthdays)--}}
                        {{--                        @dd(\Carbon\Carbon::parse($getWishedBirthday->created_at)->format('Y') )--}}
                        @foreach($getAllBirthdays as $birthday)
                            {{--                                                        @dd(\Carbon\Carbon::parse($birthday->created_at)->format('Y')===\Carbon\Carbon::now()->format('Y')?'exist':'')--}}
                            @if(\Carbon\Carbon::parse($birthday->dob)->format('F') === $months)
                                <div class="col-lg-4 col-md-4">
                                    <div class="single-info">
                                        <div class="page-img">

                                            @if(!empty($birthday->users->userProfileImages[0]) && isset($birthday->users->userProfileImages[0])?$birthday->users->userProfileImages[0]:'')

                                                @if(!empty($birthday->users->userProfileImages[0]) && isset($birthday->users->userProfileImages[0])?$birthday->users->userProfileImages[0]:'')
                                                    <a href=""><img
                                                            src="{{asset("storage/community/profile-picture/".$birthday->users->userProfileImages[0]->user_profile)}}"
                                                            alt="image"></a>
                                                @else
                                                    <a href=""><img
                                                            src="{{asset("community-frontend/assets/images/community/home/news-post/Athore01.jpg")}}"
                                                            alt="image"></a>
                                                @endif
                                            @else

                                                <a href=""><img
                                                        src="{{asset("community-frontend/assets/images/community/home/news-post/Athore01.jpg")}}"
                                                        alt="image"></a>
                                            @endif


                                        </div>
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
