<script>


    //send friend request
    $(document).on('click', '.sendRequest', function (e) {
        e.preventDefault();
        let userId = $(this).attr('data-userId');
        let userRequest = $(this);
        // // userRequest.html('Cancel Request');
        // console.log(userId);
        // return false;

        if (userId !== '') {
            $.ajax({
                url: '{{route('community.user.sendRequest')}}',
                type: "POST",
                data: {
                    userId: userId,
                    '_token': '{{csrf_token()}}',
                },
                success: function (response) {
                    if (response.status === true) {
                        userRequest.html('Cancel Request');
                        // userRequest.addClass('cancelRequest');
                    }
                }
            })
        }

    })

    //cancel friend request
    $(document).on('click', '.cancelRequest', function (e) {
        e.preventDefault();
        let reqId = $(this).attr('data-reqId');
        let userRequest = $(this);
        // userRequest.html('Cancel Request');
        // console.log(reqId);
        // return false;

        if (reqId !== '') {
            $.ajax({
                url: '{{route('community.user.cancelRequest')}}',
                type: "GET",
                data: {
                    reqId: reqId,
                },
                success: function (response) {
                    if (response.status === true) {
                        userRequest.html('Add Friend');
                    }
                }
            })
        }

    })

    //accept request
    $(document).on('click', '.addBtn', function (e) {
        e.preventDefault();
        let tldId = $(this).attr('data-reqId');
        let userId = $(this).attr('data-userId');

        let hideDiv = $(this).parents('.row').find('.removeDiv-' + userId);


        if (tldId !== '') {
            $.ajax({
                url: '{{route('community.user.acceptRequest')}}',
                type: 'POST',
                data: {
                    tldId: tldId,
                    userId: userId,
                    '_token': '{{csrf_token()}}'
                },
                success: function (response) {
                    console.log(response);
                    let msg = "";
                    if (response.status) {
                        if (response.status === true) {
                            $hideDiv.hide();
                        }

                    }

                }
            })
        }

    })

    //store user follower
    $(".btnFollow").on('click', function (e) {
        e.preventDefault();

        let userId = $(this).attr('data-userId');

        if (userId !== '') {

            $.ajax({
                url: '{{route('community.user.follow')}}',
                type: 'POST',
                data: {
                    userId: userId,
                    // userName: userName,
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

    //dlt user follower
    $(".unfolloww").on('click', function (e) {
        e.preventDefault();

        let id = $(this).attr('data-followId');
        let userId = $(this).attr('data-userId');
        let hideDev = $(this);

        // console.log(id);
        // return false;

        if (id !== '') {

            $.ajax({
                url: '{{route('community.user.unFollow')}}',
                type: 'GET',
                data: {
                    userId: id,
                    userid: userId,
                },
                success: function (response) {
                    console.log(response);
                    let msg = "";
                    if (response.status === true) {

                        hideDev.html('');
                        hideDev.html(`<a data-userId="${userId}" href="javascript:void(0)"><i class="fa fa-user-o" aria-hidden="true"></i></a>`);
                    }

                }
            })

        }
    })





    //search friend
    $(document).on('keyup', '#inputSearch', function (e) {
        e.preventDefault();
        let search = $(this).val();
        console.log(search);

        // return false;
        if (search !== '') {
            $.ajax({
                url: '{{route('community.user.search-friend')}}',
                method: "GET",
                data: {
                    search: search,
                },
                success: function (response) {
                    if (response.status === true) {

                        $('.row').html(response.html);

                    }
                }
            })
        }

    })


</script>
