<div class="view-profile left-widget">
    <div class="profile-cover">
        <img src="{{asset('community-frontend/assets/images/community/home/smallCover.jpg')}}" alt="cover">
    </div>

    <div class="profile-title d-flex align-items-center">
        <a href="#"><img src="{{asset("community-frontend/assets/images/community/home/user-0.jpg")}}" alt=""></a>
        <div class="profile-name">
            <h6><a href="#">{{Auth::user()->name}}</a></h6>
            <span class="locaiton">Washington</span>
        </div>
    </div>
    <ul class="profile-statistics">
        <li><a href="#">
                <p class="statics-count">59862</p>
                <p class="statics-name">Likes</p>
            </a></li>
        <li><a href="#">
                <p class="statics-count">8591</p>
                <p class="statics-name">Following</p>
            </a></li>
        <li><a href="#">
                <p class="statics-count">784514</p>
                <p class="statics-name">Followers</p>
            </a></li>
    </ul>

    <div class="profile-likes">
        <p><i class="fa fa-heart-o" aria-hidden="true"></i> New Likes This Weeks</p>
        <ul class="recent-likes-person">
            <li><a href="#"><img src="{{asset("community-frontend/assets/images/community/home/profileLikes/01.jpg")}}" alt="img"></a>
            </li>
            <li><a href="#"><img src="{{asset("community-frontend/assets/images/community/home/profileLikes/02.jpg")}}" alt="img"></a>
            </li>
            <li><a href="#"><img src="{{asset("community-frontend/assets/images/community/home/profileLikes/03.jpg")}}" alt="img"></a>
            </li>
            <li><a href="#"><img src="{{asset("community-frontend/assets/images/community/home/profileLikes/04.jpg")}}" alt="img"></a>
            </li>
            <li><a href="#"><img src="{{asset("community-frontend/assets/images/community/home/profileLikes/05.jpg")}}" alt="img"></a>
            </li>
            <li><a href="#"><img src="{{asset("community-frontend/assets/images/community/home/profileLikes/06.jpg")}}" alt="img"></a>
            </li>
        </ul>
        <a href="my-profile.html" class="social-theme-btn">View Profile</a>
    </div>

</div>
