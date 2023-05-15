<div class="left-widget">
    <div class="widget-title">
        <h5>Suggested Groups</h5>
        <a href="{{route('user.all.groups')}}">See All</a>
    </div>
    <ul class="suggested-option like-items">


        @if(empty($id))

            @foreach(allGroups($id=null) as $group)
                <li>

                    <div class="gropu-img"><a href="#"><img
                                src="{{asset("community-frontend/assets/images/community/home/suggested-group/group01.jpg")}}"
                                alt="img"></a></div>
                    <div class="page-title"><a href="#">{{$group->group_name}}</a>
                        <span>{{$group->userCount}}</span>
                        <a href="#" class="join-btn">Join community</a>
                    </div>
                </li>
            @endforeach
        @else
            @foreach(allGroups($id) as $group)

                <li>

                    <div class="gropu-img"><a href="#"><img
                                src="{{asset("community-frontend/assets/images/community/home/suggested-group/group01.jpg")}}"
                                alt="img"></a></div>
                    <div class="page-title"><a href="#">{{$group->group_name}}</a>
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
