<div class="left-widget page-you-like">
    <div class="widget-title">
        <h5>Page You Like</h5>
        <a href="{{route('user.all.pages')}}">See All</a>
    </div>
    <ul class="like-items">
        {{--        @dd($id)--}}

        @if(empty($id))
{{--            @dd(allPages($id=null))--}}
            @foreach(allPages($id=null) as $page)

                <li>
                    <div class="page-img">

                        @if($page->page_profile_photo)
                            <a href="{{route('user.page.details',\Illuminate\Support\Facades\Crypt::encrypt($page->pId))}}"><img
                                    src="{{asset("storage/community/page-post/profile/".$page->page_profile_photo)}}"
                                    alt="img">
                            </a>
                        @else
                            <a href="{{route('user.page.details',\Illuminate\Support\Facades\Crypt::encrypt($page->pId))}}"><img
                                    src="{{asset('community-frontend/assets/images/community/home/page-like/page03.jpg')}}"
                                    alt="img">
                        @endif
                    </div>
                    <div class="page-title"><a href="{{route('user.page.details',\Illuminate\Support\Facades\Crypt::encrypt($page->pId))}}">{{$page->page_name}}</a>
                        <span>Like {{$page->likeCounts}}</span>
                    </div>
                </li>

            @endforeach
        @else

            @dd(allPages($id))
            @foreach(allPages($id) as $page)



                <li>
                    <div class="page-img">

                        @if($page->page_profile_photo)
                            <a href="{{route('user.page.details',\Illuminate\Support\Facades\Crypt::encrypt($page->pId))}}"><img
                                    src="{{asset("storage/community/page-post/profile/".$page->page_profile_photo)}}"
                                    alt="img">
                            </a>
                        @else
                            <a href="{{route('user.page.details',\Illuminate\Support\Facades\Crypt::encrypt($page->pId))}}"><img
                                    src="{{asset('community-frontend/assets/images/community/home/page-like/page03.jpg')}}"
                                    alt="img">
                        @endif


                    </div>
                    <div class="page-title"><a href="{{route('user.page.details',\Illuminate\Support\Facades\Crypt::encrypt($page->pId))}}">{{$page->page_name}}</a>
                        <span>Like {{$page->likeCounts}}</span>
                    </div>
                </li>

            @endforeach

        @endif

    </ul>
</div>
