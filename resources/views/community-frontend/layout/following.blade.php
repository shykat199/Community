<div class="left-widget right-widget">

    <div class="widget-title">
        <h5>Your's Following</h5>
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

                    <a class="following-add btnFollow">Unfollow</a>

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
                            console.log(msg);
                        }

                    }
                })

            }


        })
    })
</script>
