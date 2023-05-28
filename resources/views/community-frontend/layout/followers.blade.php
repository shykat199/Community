<div class="left-widget right-widget">

    <div class="widget-title">
        <h5>Who's Following</h5>
    </div>

    <ul class="like-items">
        @php
            $user_id=isset($user_id)?\Illuminate\Support\Facades\Crypt::decrypt($user_id):'';
        @endphp

        @if($user_id)
            {{--            allUserFollowers($user_id) --}}
{{--                    @dd(allUserFollowers($user_id))--}}

            @forelse(allUserFollowers($user_id) as $follower)

                <li>
                    <div class="right-wdget-img">
                        @if(!empty($follower->users->userProfileImages[0]) && isset($follower->users->userProfileImages[0])?$follower->users->userProfileImages[0]:'')

                            @if(!empty($follower->users->userProfileImages[0]) && isset($follower->users->userProfileImages[0])?$follower->users->userProfileImages[0]:'')
                                <a href=""><img
                                        src="{{asset("storage/community/profile-picture/".$follower->users->userProfileImages[0]->user_profile)}}"
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
                    <div class="page-title follower-title">
                        <a class="userName" href="#"
                           data-id="{{$follower->uId}}">{{$follower->userName}}
                        </a>

                        @if(!empty($follower->is_followed))
                            <a href="#" class="following-add unfolloww" data-followId="{{$follower->flowId}}">UnFollow</a>
                        @else
                            <a href="#" class="following-add btnFollow">Follow</a>
                        @endif
                    </div>
                </li>

            @empty

                <h5>No Followers</h5>

            @endforelse

        @else
{{--                        @dd(allUserFollowers())--}}
            @forelse(allUserFollowers() as $follower)
                <li>
                    <div class="right-wdget-img">

                        @if(!empty($follower->users->userProfileImages[0]) && isset($follower->users->userProfileImages[0])?$follower->users->userProfileImages[0]:'')

                            @if(!empty($follower->users->userProfileImages[0]) && isset($follower->users->userProfileImages[0])?$follower->users->userProfileImages[0]:'')
                                <a href=""><img
                                        src="{{asset("storage/community/profile-picture/".$follower->users->userProfileImages[0]->user_profile)}}"
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
                    <div class="page-title follower-title">
                        <a class="userName" href="#"
                           data-id="{{$follower->uId}}">{{$follower->userName}}
                        </a>

                        @if(empty($follower->is_followed))
                            <a href="#" class="following-add unfolloww" data-userId="{{$follower->uId}}" data-followId="{{$follower->flowId}}">UnFollow</a>
                        @else
                            <a href="#" class="following-add btnFollow">Follow</a>
                        @endif
                    </div>
                </li>
            @empty
                <h5>No Followers</h5>
            @endforelse
        @endif
    </ul>
</div>

<script>
    $(document).ready(function () {
        $(".btnFollow").on('click', function (e) {
            e.preventDefault();
            let userName = $(this).siblings('.userName').text();
            let userId = $(this).siblings('.userName').data('id');
            // let abc=$(this).text();
            // console.log(abc)

            console.log(userId);
            // return false
            if (userName !== '' && userId !== '') {

                $.ajax({
                    url: '{{route('community.user.follow')}}',
                    type: 'POST',
                    data: {
                        userId: userId,
                        userName: userName,
                        '_token': '{{csrf_token()}}'
                    },
                    success: function (response) {
                        console.log(response);
                        let msg = "";
                        if (response.status) {
                            // let abc=$(this).val();

                            console.log(msg);
                        }

                    }
                })

            }
        })
    })
</script>
