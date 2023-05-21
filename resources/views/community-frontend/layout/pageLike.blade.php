<div class="left-widget page-you-like">
    <div class="widget-title">
        <h5>Page You Like</h5>
        <a href="{{route('user.all.pages')}}">See All</a>
    </div>
    <ul class="like-items">
        {{--        @dd($id)--}}

        @if(empty($id))

            @foreach(allPages($id=null) as $page)

                <li>
                    <div class="page-img"><a href="{{route('user.page.details',\Illuminate\Support\Facades\Crypt::encrypt($page->pId))}}"><img
                                src="{{asset("community-frontend/assets/images/community/home/page-like/page01.jpg")}}"
                                alt="img"></a>
                    </div>
                    <div class="page-title"><a href="{{route('user.page.details',\Illuminate\Support\Facades\Crypt::encrypt($page->pId))}}">{{$page->page_name}}</a>
                        <span>Like {{$page->likeCounts}}</span>
                    </div>
                </li>

            @endforeach
        @else

            @foreach(allPages($id) as $page)

                <li>
                    <div class="page-img"><a href="{{route('user.page.details',\Illuminate\Support\Facades\Crypt::encrypt($page->pId))}}"><img
                                src="{{asset("community-frontend/assets/images/community/home/page-like/page01.jpg")}}"
                                alt="img"></a>
                    </div>
                    <div class="page-title"><a href="{{route('user.page.details',\Illuminate\Support\Facades\Crypt::encrypt($page->pId))}}">{{$page->page_name}}</a>
                        <span>Like {{$page->likeCounts}}</span>
                    </div>
                </li>

            @endforeach

        @endif

        {{--        @foreach(allPages() as $page)--}}

        {{--            <li>--}}
        {{--                <div class="page-img"><a href="#"><img--}}
        {{--                            src="{{asset("community-frontend/assets/images/community/home/page-like/page01.jpg")}}" alt="img"></a>--}}
        {{--                </div>--}}
        {{--                <div class="page-title"><a href="#">{{$page->page_name}}</a>--}}
        {{--                    <span>Like {{$page->likeCounts}}</span>--}}
        {{--                </div>--}}
        {{--            </li>--}}

        {{--        @endforeach--}}


    </ul>
</div>
