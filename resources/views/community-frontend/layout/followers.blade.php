<div class="left-widget right-widget">

    <div class="widget-title">
        <h5>Who's Following</h5>
    </div>

    <ul class="like-items">

        @foreach(allUserFollowers() as $follower)

            <li>
                <div class="right-wdget-img"><a href="#"><img
                            src="{{asset("community-frontend/assets/images/community/home/right/birthday01.jpg")}}"
                            alt="img"></a>
                </div>
                <div class="page-title follower-title">
                    <a class="userName" href="#"
                       data-id="{{$follower->uId}}">{{$follower->userName}}
                    </a>

                    @if(!empty($follower->is_followed))
                        <a href="#" class="following-add btnFollow">Followed</a>
                    @else
                        <a href="#" class="following-add btnFollow">Follow</a>
                    @endif
                </div>
            </li>

        @endforeach


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
            if (userName !== '' && userId !== '') {

                $.ajax({
                    url:'{{route('community.user.follow')}}',
                    type:'POST',
                    data:{
                        userId:userId,
                        userName:userName,
                        '_token':'{{csrf_token()}}'
                    },
                    success:function (response){
                        console.log(response);
                        let msg = "";
                        if(response.status){
                            // let abc=$(this).val();

                            console.log(msg);
                        }

                    }
                })

            }
        })
    })
</script>
