<div class="left-widget page-you-like">
    <div class="widget-title">
        <h5>All Users</h5>
        <a href="#">See All</a>
    </div>
    <ul class="like-items">

        <input type="hidden" name="gId" id="gId" value="{{$id}}">


        @foreach(getGroupUserList($id) as $user)
            <li>
                <div class="page-img"><a href="#"><img
                            src="{{asset("community-frontend/assets/images/community/home/page-like/page01.jpg")}}"
                            alt="img"></a>
                </div>

                <div class="page-title">
                    <a href="#">{{$user->name}} {{$user->group_user_role==1 ? '(Admin)':''}}</a>
                </div>

                @php
                    $isAdmin=\App\Models\Community\Group\CommunityUserGroupPivot::select('group_user_role')->where('user_id','=',Auth::id())
                    ->where('group_id','=',$user->group_id)->first();

                @endphp

                @if(!empty($isAdmin->group_user_role) && isset($isAdmin->group_user_role) && $isAdmin->group_user_role == 1)
                    @if($user->group_user_role == 3 || $user->group_user_role == 2)
                        <div class="d-flex mx-auto user">
                            <h6 class="me-2">
                                <a class="text-danger btnRemove" data-id="{{$user->Uid}}"
                                   data-idd="{{$user->pivotId}}"><i class="fa fa-trash" aria-hidden="true"></i>
                                </a>
                            </h6>
                        </div>

                    @endif

                @endif
            </li>

        @endforeach

    </ul>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"
        integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function () {
        $('.btnRemove').on('click', function () {
            let elm = $(this);
            let gId = $('#gId').val();
            let userId = $(this).attr('data-id');
            let pivotId = $(this).attr('data-idd');
            console.log(pivotId);

            if (pivotId!=='') {
                $.ajax({
                    url: '{{route('user.group.remove')}}',
                    type: 'POST',
                    data: {
                        uId: userId,
                        gId: gId,
                        pivotId: pivotId,
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
