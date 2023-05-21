<div class="view-profile left-widget">
    <div class="profile-cover">

        @php
            $userDetails=!empty(allUsersDetails()) ? allUsersDetails():'' ;
                $userCover=explode(',',!empty($userDetails->user_cover) && isset($userDetails->user_cover)?$userDetails->user_cover:'');
                $userProfile=explode(',',!empty($userDetails->user_profile) && isset($userDetails->user_cover)?$userDetails->user_cover:'');
        @endphp

        @if(!empty(allUsersDetails()->user_cover) && isset(allUsersDetails()->user_cover) )

            @if(!empty($userCover[0]) &&  isset($userCover[0]))
                {{--                @dd(asset('storage/community/profile-picture/' . $userProfile[0]))--}}
                <img
                    src="{{asset('storage/community/cover-picture/'.$userCover[0])}}"
                    alt="cover">

            @else
                <img src="{{asset('community-frontend/assets/images/community/home/smallCover.jpg')}}" alt="cover">

            @endif
        @else
            <img src="{{asset('community-frontend/assets/images/community/home/smallCover.jpg')}}" alt="cover">

        @endif
    </div>


{{--    @dd(allUsersDetails())--}}

    <div class="profile-title d-flex align-items-center">
{{--        @dd($userProfile)--}}

        @if(!empty(allUsersDetails()->userProfileImages[0]) && isset(allUsersDetails()->userProfileImages[0])?allUsersDetails()->userProfileImages[0]:'')

            @if(!empty(allUsersDetails()->userProfileImages[0]) && isset(allUsersDetails()->userProfileImages[0])?allUsersDetails()->userProfileImages[0]:'')
                <a href=""><img
                        src="{{asset("storage/community/profile-picture/".allUsersDetails()->userProfileImages[0]->user_profile)}}"
                        alt="image"></a>
            @else
                <a href=""><img
                        src="{{asset("community-frontend/assets/images/community/home/news-post/Athore01.jpg")}}"
                        alt="image">
                </a>
            @endif
        @endif


        <div class="profile-name">
            <h6><a href="#">{{Auth::user()->name}}</a></h6>
            <span
                class="locaiton">{{!empty(allUsersDetails()->birthplace) && isset(allUsersDetails()->birthplace)?allUsersDetails()->birthplace:''}}</span>
        </div>
    </div>
    <ul class="profile-statistics">
        <li><a href="#">
                <p class="statics-count">0</p>
                <p class="statics-name">Likes</p>
            </a></li>
        <li><a href="#">
                <p class="statics-count">{{!empty(countFollowing()[0]) && isset(countFollowing()[0])?countFollowing()[0]['userFollowings']:'0'}}</p>
                <p class="statics-name">Following</p>
            </a></li>
        <li><a href="#">
                <p class="statics-count">{{!empty(countFollowers()[0]) && isset(countFollowers()[0])?countFollowers()[0]['userFollowers']:'0'}}</p>
                <p class="statics-name">Followers</p>
            </a></li>
    </ul>


    <div class="profile-likes">
        <p><i class="fa fa-heart-o" aria-hidden="true"></i> New Likes This Weeks</p>

        <ul class="recent-likes-person">
            @foreach(myFriends() as $friend)
                {{--                @dd($friend)--}}
                <li>
                    <a href="#"><img src="{{asset("storage/community/profile-picture/".$friend->user_profile)}}"
                                     alt="img"></a>
                </li>
            @endforeach

        </ul>
        <a href="{{route('user.my-profile')}}" class="social-theme-btn">View Profile</a>
    </div>

</div>
