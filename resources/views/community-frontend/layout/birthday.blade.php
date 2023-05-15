<div class="left-widget right-widget">
    <div class="widget-title">
        <h5>Upcoming Birthdays</h5>
        <a href="#">See All</a>
    </div>
{{--    @dd(getUpComingBirthday())--}}
    <ul class="like-items">
        @foreach(getUpComingBirthday() as $birthday)
            <li>
                <div class="right-wdget-img"><a href="#"><img
                            src="{{asset("community-frontend/assets/images/community/home/right/birthday01.jpg")}}" alt="img"></a>
                </div>
                <div class="page-title"><a href="#">{{$birthday->userName}}</a>
                    <span>{{\Carbon\Carbon::parse($birthday->dob)->format('d F')}}</span>
                </div>
            </li>
        @endforeach


    </ul>
</div>
