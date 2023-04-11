<div class="left-widget page-you-like">
    <div class="widget-title">
        <h5>Page You Like</h5>
    </div>
    <ul class="like-items">

        @foreach(allPages() as $page)

            <li>
                <div class="page-img"><a href="#"><img
                            src="{{asset("community-frontend/assets/images/community/home/page-like/page01.jpg")}}" alt="img"></a>
                </div>
                <div class="page-title"><a href="#">{{$page->page_name}}</a>
                    <span>Like {{$page->likeCounts}}</span>
                </div>
            </li>

        @endforeach



    </ul>
</div>
