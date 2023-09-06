<div class="left-widget right-widget">
    <div class="widget-title">
        <h5>Upcoming Birthdays</h5>
        <a href="#">See All</a>
    </div>
{{--    @dd(getUpComingBirthday())--}}
    <ul class="like-items">
        @foreach(getUpComingBirthday() as $birthday)
            <li>
                <div class="right-wdget-img">
                    @if(!empty($friend->userProfileImages[0]) && isset($friend->userProfileImages[0])?$friend->userProfileImages[0]:'')

                        @if(!empty($friend->userProfileImages[0]) && isset($friend->userProfileImages[0])?$friend->userProfileImages[0]:'')
                            <a href=""><img
                                    src="{{asset("storage/community/profile-picture/".$friend->userProfileImages[0]->user_profile)}}"
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
                <div class="page-title"><a href="#">{{$birthday->userName}}</a>
                    <span>{{\Carbon\Carbon::parse($birthday->dob)->format('d F')}}</span>
                </div>
            </li>
        @endforeach


    </ul>
</div>
