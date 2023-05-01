<div class="view-profile left-widget">
    <div class="profile-cover">
        {{--                @dd($getPageDetails)--}}

        @if(!empty($getPageDetails->pageCover) && isset($getPageDetails->pageCover))

            @if(!empty($getPageDetails->pageCover) &&  isset($getPageDetails->pageCover))
                <img
                    src="{{asset('storage/community/cover-picture/'.$getPageDetails->pageCover)}}"
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
        @if(!empty($getPageDetails->pageProfile) && isset($getPageDetails->pageProfile))

            @if(!empty($getPageDetails->pageProfile) &&  isset($getPageDetails->pageProfile))
                <img
                    src="{{asset('storage/community/profile-picture/'.$getPageDetails->pageProfile)}}"
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
                    <a href="#">{{$getPageDetails->page_name}}</a>
                </h6>
            </div>
            <div class="profile-name">
                <h6>
                    <a href="#"
                       class="mutual-friend">Owner: {{!empty($getPageDetails->admin) && isset($getPageDetails->admin)? $getPageDetails->admin:'Admin'}}</a>
                </h6>
            </div>
        </div>
    </div>
    <ul class="profile-statistics">
        <li><a href="#">

                <p class="statics-count">{{pageLikeCount($getPageDetails->pId)?pageLikeCount($getPageDetails->pId):0}}</p>
                <p class="statics-name">Likes</p>
            </a>
        </li>
        {{--        <li><a href="#">--}}
        {{--                <p class="statics-count">{{!empty(countFollowing()[0]) && isset(countFollowing()[0])?countFollowing()[0]['userFollowings']:'0'}}</p>--}}
        {{--                <p class="statics-name">Following</p>--}}
        {{--            </a>--}}
        {{--        </li>--}}
{{--        @dd(pageFollowCount($getPageDetails->pId))--}}
        <li><a href="#">
                <p class="statics-count">{{pageFollowCount($getPageDetails->pId)?pageFollowCount($getPageDetails->pId):0}}</p>
                <p class="statics-name">Followers</p>
            </a>
        </li>
    </ul>


    <div class="profile-likes">

        <div>
            <p>{{!empty($getPageDetails->page_details) && isset($getPageDetails->page_details)?$getPageDetails->page_details:'No Group Details'}}</p>
        </div>

    </div>

</div>
