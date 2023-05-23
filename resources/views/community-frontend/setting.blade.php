@extends('community-frontend.layout.frontend_master')

@section('frontend.user_setting')

    <!-- my profile start -->
    <div class="main-profile">
        <div class="row">
            <div class="col-lg-12">
                <div class="full-profile-box">
                    <div class="full-profile-cover">
                        <img
                            src="{{asset("community-frontend/assets/images/community/myProfile/my-profile-cover.jpg")}}"
                            alt="cover">
                        <div class="page-name">
                            Account Setting
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- my profile end -->
@endsection

@section('frontend.content')
    <!-- news feed content start  -->
    <div class="news-feed-content">
        <div class="setting-page-wrap">
            <ul class="nav nav-tabs setting-tab-btn" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane"
                            type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Profile
                        Information
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="edu-tab" data-bs-toggle="tab" data-bs-target="#edu-tab-pane"
                            type="button" role="tab" aria-controls="edu-tab-pane" aria-selected="false">Education
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="work-tab" data-bs-toggle="tab" data-bs-target="#work-tab-pane"
                            type="button" role="tab" aria-controls="work-tab-pane" aria-selected="false">Work Information
                    </button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="interest-tab" data-bs-toggle="tab" data-bs-target="#interest-tab-pane"
                            type="button" role="tab" aria-controls="interest-tab-pane" aria-selected="false">Interest
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="social-tab" data-bs-toggle="tab" data-bs-target="#social-tab-pane"
                            type="button" role="tab" aria-controls="social-tab-pane" aria-selected="false">Social Links
                    </button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane"
                            type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Security
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane"
                            type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">Privacy
                    </button>
                </li>
                {{--                <li class="nav-item" role="presentation">--}}
                {{--                    <button class="nav-link" id="notificaiton-tab" data-bs-toggle="tab"--}}
                {{--                            data-bs-target="#notification-tab-pane" type="button" role="tab"--}}
                {{--                            aria-controls="contact-tab-pane" aria-selected="false">Notification--}}
                {{--                    </button>--}}
                {{--                </li>--}}
                {{--                <li class="nav-item" role="presentation">--}}
                {{--                    <button class="nav-link" id="message-tab" data-bs-toggle="tab" data-bs-target="#message-tab-pane"--}}
                {{--                            type="button" role="tab" aria-controls="message-tab-pane" aria-selected="false">Message--}}
                {{--                    </button>--}}
                {{--                </li>--}}
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="closeAccount-tab" data-bs-toggle="tab"
                            data-bs-target="#closeAccount-tab-pane" type="button" role="tab"
                            aria-controls="message-tab-pane" aria-selected="false">Close Account
                    </button>
                </li>
            </ul>

            {{--Profile Information--}}


            <div class="setting-tab-content">
                <div class="tab-content" id="myTabContent">

                    <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab"
                         tabindex="0">
                        {{--                        @dd($userInfo)--}}
                        <form class="setting-form-wrapper profile-information"
                              action="{{route('user.my-profile.profile-information')}}" method="post">
                            @csrf

                            <h5 class="setting-title">Profile Information</h5>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label for="firstName">First Name</label>
                                    <input type="text" value="{{(isset($userInfo[0]))?$userInfo[0]['fname']:''}}"
                                           id="firstName" name="fname" placeholder="First Name">
                                </div>
                                <div class="col-lg-6">
                                    <label for="lastName">Last Name</label>
                                    <input type="text" value="{{(isset( $userInfo[0]))?$userInfo[0]['lname']:''}}"
                                           id="lastName" name="lname" placeholder="Last Name">
                                </div>
                                <div class="col-lg-6">
                                    <label for="forMail">Email</label>
                                    <input type="email" value="{{(isset( $userInfo[0]))?$userInfo[0]['email']:''}}"
                                           id="forMail" name="email" placeholder="Email">
                                </div>
                                <div class="col-lg-6">
                                    <label for="forBackupMail">Backup Email</label>
                                    <input type="email" value="" id="forBackupMail" name="bmail"
                                           placeholder="Backup Email">
                                </div>
                                <div class="col-lg-6">
                                    <label for="birthDay">Date of Birth</label>
                                    <input type="text" name="dob" class="form-control"
                                           id="datepicker"
                                           value="{{isset($userInfo[0])? \Carbon\Carbon::parse($userInfo[0]['dob'])->format('d-m-Y'):''}}"
                                           placeholder="">

                                </div>

                                <div class="col-lg-6">
                                    <label for="poneNumber">Phone Number</label>
                                    <input type="number" value="{{(isset( $userInfo[0]))?$userInfo[0]['phone']:''}}"
                                           id=":'poneNumber" name="pnumber" placeholder="Phone Number">
                                </div>
                                <div class="col-lg-6">
                                    <label for="relation">Occupation</label>
                                    <select name="occupation" class="js-example-basic-single" id="relation">
                                        <option value="" selected>Occupation</option>
                                        <option
                                            value="Software Developer" {{isset($userInfo[0]) && $userInfo[0]['occupation']==='Software Developer'?'selected':''}}>
                                            Software Developer
                                        </option>
                                        <option
                                            value="Biomedical Engineer" {{isset($userInfo[0]) && $userInfo[0]['occupation']==='Biomedical Engineer'?'selected':''}}>
                                            Biomedical Engineer
                                        </option>
                                        <option
                                            value="Civil Engineer" {{isset($userInfo[0]) && $userInfo[0]['occupation']==='Civil Engineer'?'selected':''}}>
                                            Civil Engineer
                                        </option>
                                        <option
                                            value="General Practitioner" {{isset($userInfo[0]) && $userInfo[0]['occupation']==='General Practitioner'?'selected':''}}>
                                            General Practitioner
                                        </option>
                                        <option
                                            value="Technician" {{isset($userInfo[0]) && $userInfo[0]['occupation']==='Technician'?'selected':''}}>
                                            Technician
                                        </option>
                                    </select>
                                </div>
                                <div class="col-lg-6">
                                    <label for="gender">Gender</label>
                                    <select name="" id="gender">
                                        <option selected>Gender</option>
                                        <option >Male</option>
                                        <option >Female</option>
                                    </select>
                                </div>
                                <div class="col-lg-6">
                                    <label for="gender">Gender</label>
                                    <select name="gender" class="js-example-basic-single" id="gender">
                                        <option value="" selected>Gender</option>
                                        <option
                                            value="Male" {{isset($userInfo[0])&& $userInfo[0]['gender']==='Male'?'selected':''}}>
                                            Male
                                        </option>
                                        <option
                                            value="Female" {{isset($userInfo[0])&& $userInfo[0]['gender']==='Female'?'selected':''}}>
                                            Female
                                        </option>
                                        <option
                                            value="Other" {{isset($userInfo[0])&& $userInfo[0]['gender']==='Other'?'selected':''}}>
                                            Other
                                        </option>
                                    </select>
                                </div>
                                <div class="col-lg-6">
                                    <label for="relation">Relation Status</label>
                                    <select name="relation" class="js-example-basic-single" id="relation">
                                        <option value="" selected>Relation Status</option>
                                        <option
                                            value="Married" {{isset($userInfo[0]) && $userInfo[0]['relationship']==='Married'?'selected':''}}>
                                            Married
                                        </option>
                                        <option
                                            value="Single" {{isset($userInfo[0]) && $userInfo[0]['relationship']==='Single'?'selected':''}}>
                                            Single
                                        </option>
                                    </select>
                                </div>
                                <div class="col-lg-6">
                                    <label for="bloodGroup">Blood Group</label>
                                    <select name="bloodGroup" class="js-example-basic-single" id="bloodGroup">
                                        <option value="" selected>Blood Group</option>
                                        @foreach(bloodGroups() as $group)
                                            <option
                                                value="{{$group}}"{{isset($userInfo[0]) && $userInfo[0]['blood']===$group?'selected':''}}>{{$group}}</option>
                                        @endforeach

                                    </select>
                                </div>


                                <div class="col-lg-6">
                                    <label for="website">Website</label>
                                    <input type="text" value="{{(isset( $userInfo[0]))?$userInfo[0]['website']:''}}"
                                           id="website" name="website" placeholder="Website">
                                </div>

                                <div class="col-lg-6">

                                    <label for="country">Country</label>
{{--                                    @dd($userInfo[0]['country'])--}}
                                    <select class="js-example-basic-single country-dropdown" id="country-dropdown1" name="country">
                                        <option selected value="">Select Country</option>
                                        {{--                                                    @dd($allCountries)--}}
                                        @foreach($allCountries as $country)

                                            <option value="{{$country->country}}" {{isset($userInfo[0]['country']) && $userInfo[0]['country']===$country->country?'selected':''}}>{{$country->country}}
                                            </option>
                                        @endforeach

                                    </select>

                                </div>

                                {{--                                @dd($userInfo)--}}
                                <div class="col-lg-6">
                                    <label for="address">Address</label>
                                    <input type="text" id="address"
                                           value="{{isset($userInfo[0])?$userInfo[0]['birthplace']:''}}" name="address"
                                           placeholder="Address">
                                </div>

                                <div class="col-lg-6">
                                    <label for="state">State</label>
                                    <select class="js-example-basic-single state-dropdown" id="state-dropdown1" name="state">
                                        <option selected value="">Select State</option>

                                    </select>

                                </div>


                                <div class="col-lg-6">
                                    <label for="language">Language</label>
                                    @php
                                        $languges=[];
                                        foreach ($userLanguage->languages as $key=> $value){
                                            $languges[]=$value->language_name;
                                        }
                                    @endphp
                                    <select class="js-example-basic-multiple" name="language[]" multiple="multiple">
                                        <option selected value="">Select language</option>
                                        @foreach(allLanguages() as $language)
                                            <option
                                                value="{{$language}}" {{in_array($language, $languges)?'selected':''}}>{{$language}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-lg-6">
                                    <label for="city">City</label>

                                    <select class="js-example-basic-single city-dropdown1" id="city-dropdown1" name="city">
                                        <option selected value="">Select City</option>

                                    </select>

                                </div>


                                <div class="col-lg-6">
                                    <label for="address">About Me</label>
                                    <textarea name="about_me" rows="5"
                                              cols="38">"{{isset($userInfo[0])?$userInfo[0]['about_me']:''}}</textarea>
                                </div>
                                <div class="col-12 mt-2">
                                    <button type="submit" class="social-theme-btn save-btn">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
{{--                    @dd($userEducation)--}}
                    <div class="tab-pane fade" id="edu-tab-pane" role="tabpanel" aria-labelledby="edu-tab"
                         tabindex="0">

                        <form class="setting-form-wrapper profile-information"
                              action="{{route('user.my-profile.profile.education')}}" method="post">
                            @csrf

                            <h5 class="setting-title">Education Information</h5>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label for="instituteName">Institute Name</label>
                                    <input type="text" value="" id="instituteName" name="instituteName"
                                           placeholder="Institute Name">
                                </div>
                                <div class="col-lg-6">
                                    <label for="degreeName">Degree Name</label>
                                    <input type="text" value="" id="degreeName" name="degreeName"
                                           placeholder="Degree Name">
                                </div>

                                <div class="col-lg-6">
                                    <label for="startingDate">Starting year</label>
                                    <input type="text" name="startingDate" class="form-control datepicker"
                                           value=""
                                           placeholder="">

                                </div>
                                <div class="col-lg-6">
                                    <label for="passingDate">Passing year</label>
                                    <input type="text" name="passingDate" class="form-control datepicker"
                                           value=""
                                           placeholder="">

                                </div>
                                <div class="col-lg-6">
                                    <label for="institute">About Institute</label>
                                    <textarea class="form-control editor" placeholder="Enter the Description"
                                              name="institute"></textarea>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input"  name="is_present" type="checkbox" id="flexSwitchCheckDefault">
                                        <label class="form-check-label" for="flexSwitchCheckDefault">Is Present</label>
                                    </div>

                                </div>
                                <div class="col-12 mt-2">
                                    <button type="submit" class="social-theme-btn save-btn">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="tab-pane fade" id="work-tab-pane" role="tabpanel" aria-labelledby="work-tab"
                         tabindex="0">

                        <form class="setting-form-wrapper profile-information"
                              action="{{route('user.my-profile.profile.work')}}" method="post">
                            @csrf

                            <h5 class="setting-title">Work Information</h5>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label for="designation">Designation</label>
                                    <input type="text" value="" id="designation" name="designation"
                                           placeholder="Designation Name">
                                </div>
                                <div class="col-lg-6">
                                    <label for="companyName">Company Name</label>
                                    <input type="text" value="" id="companyName" name="companyName"
                                           placeholder="Company Name">
                                </div>

                                <div class="col-lg-6">
                                    <label for="startingDate">Starting Date</label>
                                    <input type="text" name="startingDate" class="form-control datepicker"
                                           value=""
                                           placeholder="">

                                </div>

                                <div class="col-lg-6">
                                    <label for="startingDate">Ending Date</label>
                                    <input type="text" name="passingDate" class="form-control datepicker"
                                           value=""
                                           placeholder="">

                                </div>

                                <div class="col-lg-6">
                                    <label for="company">About Company</label>
                                    <textarea class="form-control" id="editor1" placeholder="Enter the Description"
                                              name="company"></textarea>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input"  name="is_present" type="checkbox" id="flexSwitchCheckDefault">
                                        <label class="form-check-label" for="flexSwitchCheckDefault">Is Present</label>
                                    </div>

                                </div>

                                <div class="col-12 mt-2">
                                    <button type="submit" class="social-theme-btn save-btn">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="tab-pane fade" id="interest-tab-pane" role="tabpanel" aria-labelledby="interest-tab"
                         tabindex="0">
{{--                        @dd($userInterests)--}}
                        <form action="{{route('user.my-profile.profile.interest')}}" class="setting-form-wrapper profile-information" method="post">
                            @csrf
                            <h5 class="setting-title">Field Of Interest information</h5>
                            <div class="row">

                                <div class="col-lg-12">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="inputGroup-sizing-sm">Hobby</span>
                                        </div>
                                        <input type="text" name="hobby" value="{{(isset($userInterests['hobby'])) ? $userInterests['hobby'] : ''}}" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">

                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="inputGroup-sizing-sm">Favourite Book</span>
                                        </div>
                                        <input type="text" name="fav_book" value="{{(isset($userInterests['fav_book'])) ? $userInterests['fav_book'] : ''}}" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">

                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="inputGroup-sizing-sm">Other Interest</span>
                                        </div>
                                        <input type="text" name="other_interest" value="{{(isset($userInterests['other_interest'])) ? $userInterests['other_interest'] : ''}}" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">

                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="social-theme-btn save-btn">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="tab-pane fade" id="social-tab-pane" role="tabpanel" aria-labelledby="social-tab"
                         tabindex="0">
{{--                        @dd($userInterests)--}}
                        <form action="{{route('user.my-profile.profile.social')}}" class="setting-form-wrapper profile-information" method="post">
                            @csrf
                            <h5 class="setting-title">Social Links</h5>
                            <div class="row">

                                <div class="col-lg-12">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="inputGroup-sizing-sm">Facebook</span>
                                        </div>
                                        <input type="text" name="facebook" value="{{(isset($userSocial['facebook'])) ? $userSocial['facebook'] : ''}}" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">

                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="inputGroup-sizing-sm">Twitter</span>
                                        </div>
                                        <input type="text" name="twitter" value="{{(isset($userSocial['twitter'])) ? $userSocial['twitter'] : ''}}" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">

                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="inputGroup-sizing-sm">Instagram</span>
                                        </div>
                                        <input type="text" name="instagram" value="{{(isset($userSocial['instagram'])) ? $userSocial['instagram'] : ''}}" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">

                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="inputGroup-sizing-sm">Linkedin</span>
                                        </div>
                                        <input type="text" name="linkedin" value="{{(isset($userSocial['linkedin'])) ? $userSocial['linkedin'] : ''}}" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">

                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="inputGroup-sizing-sm">Pinterest</span>
                                        </div>
                                        <input type="text" name="pinterest" value="{{(isset($userSocial['pinterest'])) ? $userSocial['pinterest'] : ''}}" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">

                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="social-theme-btn save-btn">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab"
                         tabindex="0">
                        <form class="setting-form-wrapper profile-information">
                            <h5 class="setting-title">Security Information</h5>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label for="recoveryMail">Recovery Email</label>
                                    <input type="email" value="" id="recoveryMail" name="fname" placeholder="Recovery Email">
                                </div>
                                <div class="col-lg-6">
                                    <label for="recoveryNumber">Recovery Phone</label>
                                    <input type="number" value="" id="recoveryNumber" placeholder="Recovery Phone">
                                </div>
                                <div class="col-lg-6">
                                    <label for="securityQuesiton1">Security Question 01</label>
                                    <input type="text" id="securityQuesiton1" name="fname"
                                           placeholder="Security Question 01">
                                </div>
                                <div class="col-lg-6">
                                    <label for="securityQuesiton2">Security Question 02</label>
                                    <input type="text" id="securityQuesiton2" name="fname"
                                           placeholder="Security Question 02">
                                </div>
                                <div class="col-lg-6">
                                    <label for="securityQuesiton3">Security Question 03</label>
                                    <input type="text" id="securityQuesiton3" name="fname"
                                           placeholder="Security Question 03">
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="social-theme-btn save-btn">Save</button>
                                </div>
                            </div>
                        </form>
                        <form class="setting-form-wrapper profile-information"
                              action="{{route('user.my-profile.update-password')}}" method="post">
                            @csrf
                            <h5 class="setting-title">Change Password</h5>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label for="password1">Current Password
                                    </label>
                                    <input type="password" id="password1" name="current_password"
                                           placeholder="Current Password">
                                    @error('current_password')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-6">
                                    <label for="password2">New Password
                                    </label>
                                    <input type="password" id="password2" name="new_password"
                                           placeholder="New Password">
                                    @error('new_password')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-6">
                                    <label for="password3">Confirm Password
                                    </label>
                                    <input type="password" id="password3" name="new_password_confirmation"
                                           placeholder="Confirm New Password">
                                    @error('new_password_confirmation')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="social-theme-btn save-btn">Save Change</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab"
                         tabindex="0">
                        <form class="setting-form-wrapper profile-information">
                            <h5 class="setting-title">Privacy Settings</h5>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label>Who Can See Your Profile?</label>
                                    <input type="text">
                                </div>
                                <div class="col-lg-6">
                                    <label>Who Can See Your Future Post?</label>
                                    <input type="text">
                                </div>
                                <div class="col-lg-6">
                                    <label>Who Can Send You Friend Request?</label>
                                    <input type="text">
                                </div>
                                <div class="col-lg-6">
                                    <label>Who Can See Your Chat Activity?</label>
                                    <input type="text">
                                </div>
                                <div class="col-lg-6">
                                    <label>Who Can See Your Phone Number?</label>
                                    <input type="text">
                                </div>
                                <div class="col-lg-6">
                                    <label>How People Find And Contact You?</label>
                                    <input type="text">
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="social-theme-btn save-btn">Save Change</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="tab-pane fade" id="closeAccount-tab-pane" role="tabpanel"
                         aria-labelledby="closeAccount-tab" tabindex="0">
                        <div class="setting-form-wrapper profile-information">
                            <div class="setting-title">
                                Close Account
                                <p class="acount-subtitle"><span>Warning:</span> If you close your account, all your
                                    followers and friends will be unsubscribed and you will lose access forever.</p>
                            </div>
                            <form action="{{route('user.my-profile.deactivate-account')}}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label for="yourPassword">Your Password</label>
                                        <input type="password" name="current_password" id="yourPassword">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="social-theme-btn save-btn">Deactivate Account</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- news feeds content start  -->

    <!-- live chat and contact area start  -->
    <div class="contact-wrap">
        <div class="chat-wrapper">
            <div class="live-chat">
                <div class="widget-title">
                    <h5>Recent Chat</h5>
                </div>
                <ul class="contact-widget">
                    <li>
                        <div class="contact-img"><a href="#"><img
                                    src="../assets/images/community/home/right/birthday01.jpg" alt="img"></a>
                            <div class="login-status online"></div>
                        </div>
                        <div class="contact-name"><a href="#">Lolita Benally</a></div>
                    </li>
                    <li>
                        <div class="contact-img"><a href="#"><img
                                    src="../assets/images/community/home/right/birthday01.jpg" alt="img"></a>
                            <div class="login-status online"></div>
                        </div>
                        <div class="contact-name"><a href="#">Lolita Benally</a></div>
                    </li>
                    <li>
                        <div class="contact-img"><a href="#"><img
                                    src="../assets/images/community/home/right/birthday01.jpg" alt="img"></a>
                            <div class="login-status offline"></div>
                        </div>
                        <div class="contact-name"><a href="#">Lolita Benally</a></div>
                    </li>
                    <li>
                        <div class="contact-img"><a href="#"><img
                                    src="../assets/images/community/home/right/birthday01.jpg" alt="img"></a>
                            <div class="login-status offline"></div>
                        </div>
                        <div class="contact-name"><a href="#">Lolita Benally</a></div>
                    </li>
                    <li>
                        <div class="contact-img"><a href="#"><img
                                    src="../assets/images/community/home/right/birthday01.jpg" alt="img"></a>
                            <div class="login-status offline"></div>
                        </div>
                        <div class="contact-name"><a href="#">Lolita Benally</a></div>
                    </li>
                </ul>
            </div>
            <div class="live-chat live-contact">
                <div class="widget-title">
                    <h5>Contact</h5>
                </div>
                <form action="#" class="sms-search contact-search">
                    <input type="text" id="smsSearch" placeholder="Search">
                    <button id="smsSearchBtn" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                </form>
                <ul class="contact-widget">
                    <li>
                        <div class="contact-img"><a href="#"><img
                                    src="../assets/images/community/home/right/birthday01.jpg" alt="img"></a>
                            <div class="login-status online"></div>
                        </div>
                        <div class="contact-name"><a href="#">Lolita Benally</a></div>
                    </li>
                    <li>
                        <div class="contact-img"><a href="#"><img
                                    src="../assets/images/community/home/right/birthday01.jpg" alt="img"></a>
                            <div class="login-status online"></div>
                        </div>
                        <div class="contact-name"><a href="#">Lolita Benally</a></div>
                    </li>
                    <li>
                        <div class="contact-img"><a href="#"><img
                                    src="../assets/images/community/home/right/birthday01.jpg" alt="img"></a>
                            <div class="login-status offline"></div>
                        </div>
                        <div class="contact-name"><a href="#">Lolita Benally</a></div>
                    </li>
                    <li>
                        <div class="contact-img"><a href="#"><img
                                    src="../assets/images/community/home/right/birthday01.jpg" alt="img"></a>
                            <div class="login-status offline"></div>
                        </div>
                        <div class="contact-name"><a href="#">Lolita Benally</a></div>
                    </li>
                    <li>
                        <div class="contact-img"><a href="#"><img
                                    src="../assets/images/community/home/right/birthday01.jpg" alt="img"></a>
                            <div class="login-status offline"></div>
                        </div>
                        <div class="contact-name"><a href="#">Lolita Benally</a></div>
                    </li>
                    <li>
                        <div class="contact-img"><a href="#"><img
                                    src="../assets/images/community/home/right/birthday01.jpg" alt="img"></a>
                            <div class="login-status online"></div>
                        </div>
                        <div class="contact-name"><a href="#">Lolita Benally</a></div>
                    </li>
                    <li>
                        <div class="contact-img"><a href="#"><img
                                    src="../assets/images/community/home/right/birthday01.jpg" alt="img"></a>
                            <div class="login-status online"></div>
                        </div>
                        <div class="contact-name"><a href="#">Lolita Benally</a></div>
                    </li>
                    <li>
                        <div class="contact-img"><a href="#"><img
                                    src="../assets/images/community/home/right/birthday01.jpg" alt="img"></a>
                            <div class="login-status online"></div>
                        </div>
                        <div class="contact-name"><a href="#">Lolita Benally</a></div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- live chat and contact area end  -->
    <!-- side nav start  -->
    @include('community-frontend.layout.sidebar')
    <!-- side nav end  -->

@endsection

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css">

@endpush

@push('script')
    <script src="https://cdn.ckeditor.com/ckeditor5/37.1.0/classic/ckeditor.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


    <script>
        $(".datepicker").datepicker({maxDate: '0'});
    </script>
    <script>
        $(document).ready(function () {
            $('.js-example-basic-single').select2();
        });
        $(document).ready(function () {
            $('.js-example-basic-multiple').select2();
        });
    </script>
    <script>
        ClassicEditor.create(document.querySelector('.editor'))
            .then(editor => {
                editor.ui.view.editable.element.style.height = '150px';
            })
            .catch(error => {
                console.error(error);
            });

    </script>
    <script>
        ClassicEditor.create(document.querySelector('#editor1'))
            .then(editor => {
                editor.ui.view.editable.element.style.height = '150px';
            })
            .catch(error => {
                console.error(error);
            });

    </script>

    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();

            $(document).on('change','.country-dropdown', function () {
                let country_id = this.value;
                // console.log(country_id);
                $(".state-dropdown").html('');
                // return false;
                $.ajax({
                    url: "{{route('get.frontend.state.on-country-change')}}",
                    type: "POST",
                    data: {
                        country_id: country_id,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (result) {
                        $('.state-dropdown').html('<option value="">-- Select State --</option>');
                        $.each(result.getStates, function (key, value) {
                            $(".state-dropdown").append('<option value="' + value
                                .id + '">' + value.name + '</option>');
                        });
                        // $('#city-dropdown').html('<option value="">-- Select City --</option>');
                    }
                });
            });

            $(document).on('change','.state-dropdown', function () {
                let state_id = this.value;
                // console.log(country_id);
                $(".city-dropdown1").html('');
                // return false;
                $.ajax({
                    url: "{{route('get.frontend.city.on-state-change')}}",
                    type: "POST",
                    data: {
                        state_id: state_id,
                        reqTyp:'getCity',
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (result) {
                        console.log(result.getCity);
                        $('.city-dropdown1').html('<option value="">-- Select State --</option>');
                        $.each(result.getStates, function (key, value) {
                            $(".city-dropdown1").append('<option value="' + value
                                .id + '">' + value.city + '</option>');
                        });
                        // $('#city-dropdown').html('<option value="">-- Select City --</option>');
                    }
                });
            });

        });
    </script>
    <script>



        $(document).ready(function () {
            $('.js-example-basic-single').select2();

            let country=$('.country-dropdown').val();

            $('.country-dropdown').select2().select2('val', country);

        });
        $(document).ready(function () {
            $('.js-example-basic-multiple').select2();
        });
    </script>

@endpush

