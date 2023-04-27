<div class="view-profile left-widget">
    <div class="profile-cover">
{{--                @dd($getGroupDetails)--}}

        @if(!empty($getGroupDetails->cover_photo) && isset($getGroupDetails->cover_photo))

            @if(!empty($getGroupDetails->cover_photo) &&  isset($getGroupDetails->cover_photo))
                <img
                    src="{{asset('storage/community/cover-picture/'.$getGroupDetails->cover_photo)}}"
                    alt="cover">

            @else
                <img src="{{asset('community-frontend/assets/images/community/home/smallCover.jpg')}}" alt="cover">

            @endif
        @else
            <img src="{{asset('community-frontend/assets/images/community/home/smallCover.jpg')}}" alt="cover">

        @endif
    </div>


    {{--@dd(allUsersDetails())--}}

    <div class="profile-title d-flex align-items-center">
        @if(!empty($getGroupDetails->groupProfile) && isset($getGroupDetails->groupProfile))

            @if(!empty($getGroupDetails->groupProfile) &&  isset($getGroupDetails->groupProfile))
                <img
                    src="{{asset('storage/community/profile-picture/'.$getGroupDetails->groupProfile)}}"
                    alt="cover"
                    style="height: 100px;width: 80px;">
            @else
                <img src="{{asset('community-frontend/assets/images/community/home/smallCover.jpg')}}" alt="cover">

            @endif
        @else
            <img src="{{asset('community-frontend/assets/images/community/home/user-0.jpg')}}" alt="cover">

        @endif
        <div>
        <div class="profile-name">
            <h6>
                <a href="#">{{$getGroupDetails->group_name}}</a>
            </h6>
        </div>
        <div class="profile-name">
            <h6>
                <a href="#" class="mutual-friend">Owner: {{!empty($getGroupDetails->admin) && isset($getGroupDetails->admin)? $getGroupDetails->admin:'Admin'}}</a>
            </h6>
        </div>
        </div>
    </div>
    <ul class="profile-statistics">
        <li><a href="#">
                <p class="statics-count">{{!empty($getGroupDetails->userCount) && isset($getGroupDetails->userCount)?$getGroupDetails->userCount:'0'}}</p>
                <p class="statics-name">Member</p>
            </a>
        </li>
        {{--        <li><a href="#">--}}
        {{--                <p class="statics-count">{{!empty(countFollowing()[0]) && isset(countFollowing()[0])?countFollowing()[0]['userFollowings']:'0'}}</p>--}}
        {{--                <p class="statics-name">Following</p>--}}
        {{--            </a>--}}
        {{--        </li>--}}
        <li><a href="#">
                <p class="statics-count">{{!empty(countFollowers()[0]) && isset(countFollowers()[0])?countFollowers()[0]['userFollowers']:'0'}}</p>
                <p class="statics-name">Followers</p>
            </a>
        </li>
    </ul>


    <div class="profile-likes">

        <div>
            <p>{{!empty($getGroupDetails->group_details) && isset($getGroupDetails->group_details)?$getGroupDetails->group_details:'No Group Details'}}</p>
        </div>

    </div>

</div>
