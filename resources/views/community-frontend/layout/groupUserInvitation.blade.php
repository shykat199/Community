<div class="left-widget page-you-like">
    <div class="widget-title">
        <h5>Group Invitation</h5>
        <a href="#">See All</a>
    </div>
    <ul class="like-items">
        {{--        @dd($id)--}}
        <input type="hidden" name="gId" id="gId" value="{{$id}}">
{{--        @dd(getGroupUserList())--}}

        @foreach(getAllGroupUserRequest($id) as $user)

            <li>
                <div class="page-img"><a href="#"><img
                            src="{{asset("community-frontend/assets/images/community/home/page-like/page01.jpg")}}"
                            alt="img"></a>
                </div>
                <div class="page-title">
                    <a href="#">{{$user->name}}</a>
                </div>
                <div class="d-flex mx-auto user">
                    <h6 class="me-2"><a class="text-success btnAccept" data-id="{{$user->Uid}}"
                                        data-idd="{{$user->id}}"><i class="fa fa-check-circle"
                                                                    aria-hidden="true"></i></a>
                    </h6>
                    <h6><a class="text-danger"><i class="fa fa-times-circle-o" aria-hidden="true"></i></a></h6>
                </div>
            </li>

        @endforeach

    </ul>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"
        integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function () {
        $('.btnAccept').on('click', function () {
            let elm = $(this);
            let gId = $('#gId').val();
            let userId = $(this).attr('data-id');
            let id = $(this).attr('data-idd');

            console.log(userId, id);

            if (gId !== '' && userId !== '') {
                $.ajax({
                    url: '{{route('user.group.accept.invitation')}}',
                    type: 'POST',
                    data: {
                        uId: userId,
                        gId: gId,
                        id: id,
                        '_token': '{{csrf_token()}}'
                    },
                    success: function (response) {
                        console.log(response);
                        if (response.success === true) {
                            toastr.success(response.msg);
                            elm.parents('li').hide();
                        } else {
                            toastr.error(response.msg);
                        }
                    },
                    error: function (err) {

                        toastr.error("Error with AJAX callback !");
                    }
                })
            }

        })
    })
</script>
