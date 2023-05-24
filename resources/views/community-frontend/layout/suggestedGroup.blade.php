<div class="left-widget">
    <div class="widget-title">
        <h5>Suggested Groups</h5>
        <a href="{{route('user.all.groups')}}">See All</a>
    </div>
    <ul class="suggested-option like-items">


        @if(empty($id))
            @foreach(allGroups($id=null) as $group)
                <li>

                    <div class="gropu-img">

                        @if($group->group_profile_photo)
                            <a href="{{route('user.page.details',\Illuminate\Support\Facades\Crypt::encrypt($group->pId))}}"><img
                                    src="{{asset("storage/community/group-post/profile/".$group->group_profile_photo)}}"
                                    alt="img">
                            </a>
                        @else
                            <a href="{{route('user.page.details',\Illuminate\Support\Facades\Crypt::encrypt($group->pId))}}"><img
                                    src="{{asset('community-frontend/assets/images/community/home/page-like/page03.jpg')}}"
                                    alt="img">
                        @endif
                    </div>
                    <div class="page-title"><a href="{{route('user.group.details',\Illuminate\Support\Facades\Crypt::encrypt($group->cGroupId))}}">{{$group->group_name}}</a>
                        <span>{{$group->userCount}}</span>
                        <a href="#" class="join-btn">Join community</a>
                    </div>
                </li>
            @endforeach
        @else
            @foreach(allGroups($id) as $group)

                <li>

                    <div class="gropu-img">
                        @if($group->group_profile_photo)
                            <a href="{{route('user.page.details',\Illuminate\Support\Facades\Crypt::encrypt($group->pId))}}"><img
                                    src="{{asset("storage/community/group-post/profile/".$group->group_profile_photo)}}"
                                    alt="img">
                            </a>
                        @else
                            <a href="{{route('user.page.details',\Illuminate\Support\Facades\Crypt::encrypt($group->pId))}}"><img
                                    src="{{asset('community-frontend/assets/images/community/home/page-like/page03.jpg')}}"
                                    alt="img">
                        @endif
                    </div>
                    <div class="page-title"><a href="{{route('user.group.details',\Illuminate\Support\Facades\Crypt::encrypt($group->cGroupId))}}">{{$group->group_name}}</a>
                        <span>{{$group->userCount}}</span>
                        <a href="#" class="join-btn">Join community</a>
                    </div>
                </li>
            @endforeach
        @endif

        {{--        @foreach(allGroups($id=null) as $group)--}}
        {{--            <li>--}}

        {{--                <div class="gropu-img"><a href="#"><img--}}
        {{--                            src="{{asset("community-frontend/assets/images/community/home/suggested-group/group01.jpg")}}"--}}
        {{--                            alt="img"></a></div>--}}
        {{--                <div class="page-title"><a href="#">{{$group->group_name}}</a>--}}
        {{--                    <span>{{$group->userCount}}</span>--}}
        {{--                    <a href="#" class="join-btn">Join community</a>--}}
        {{--                </div>--}}
        {{--            </li>--}}
        {{--        @endforeach--}}


    </ul>
</div>
