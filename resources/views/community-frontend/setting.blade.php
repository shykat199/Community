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
                                    <select name="occupation" id="relation">
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
                                    <select name="gender" id="gender">
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
                                    <select name="relation" id="relation">
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
                                    <select name="bloodGroup" id="bloodGroup">
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
                                {{--                                @dd($userInfo)--}}
                                <div class="col-lg-6">
                                    <label for="address">Address</label>
                                    <input type="text" id="address"
                                           value="{{isset($userInfo[0])?$userInfo[0]['birthplace']:''}}" name="address"
                                           placeholder="Address">
                                </div>
                                <div class="col-lg-6">
                                    <label for="city">City</label>
                                    <select name="city" id="city">
                                        <option selected>City</option>
                                        <option
                                            value="Bangladesh" {{isset($userInfo[0])&&$userInfo[0]['city']==='Bangladesh'?'selected':''}}>
                                            Bangladesh
                                        </option>
                                        <option
                                            value="Canada" {{isset($userInfo[0])&&$userInfo[0]['city']==='Canada'?'selected':''}}>
                                            Canada
                                        </option>
                                        <option
                                            value="Germany" {{isset($userInfo[0])&&$userInfo[0]['city']==='Germany'?'selected':''}}>
                                            Germany
                                        </option>
                                        <option
                                            value="Switzerland" {{isset($userInfo[0])&&$userInfo[0]['city']==='Switzerland'?'selected':''}}>
                                            Switzerland
                                        </option>
                                    </select>
                                </div>
                                <div class="col-lg-6">
                                    <label for="state">State</label>
                                    <select name="state" id="state">
                                        <option selected>State</option>
                                        <option
                                            value="Bangladesh" {{isset($userInfo[0])&&$userInfo[0]['state']==='Bangladesh'?'selected':''}}>
                                            Bangladesh
                                        </option>
                                        <option
                                            value="Canada" {{isset($userInfo[0])&&$userInfo[0]['state']==='Canada'?'selected':''}}>
                                            Canada
                                        </option>
                                        <option
                                            value="Germany" {{isset($userInfo[0])&&$userInfo[0]['state']==='Germany'?'selected':''}}>
                                            Germany
                                        </option>
                                        <option
                                            value="Switzerland" {{isset($userInfo[0])&&$userInfo[0]['state']==='Switzerland'?'selected':''}}>
                                            Switzerland
                                        </option>
                                    </select>
                                </div>
                                <div class="col-lg-6">

                                    <label for="country">Country</label>

                                    <select class="js-example-basic-single country" name="country">
                                        <option selected value="">Select Country</option>
                                        @foreach(allCountries() as $country)
                                            <option
                                                value="{{$country}}"{{isset($userInfo[0])&& $userInfo[0]['country']===$country?'selected':''}}>{{$country}}</option>
                                        @endforeach

                                    </select>
                                </div>
                                <div class="col-lg-6">
                                    <label for="address">About Me</label>
                                    <textarea name="about_me" rows="5"
                                              cols="38">{{$country}}"{{isset($userInfo[0])?$userInfo[0]['about_me']:''}}</textarea>
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
                    {{--                        <div class="tab-pane fade" id="notification-tab-pane" role="tabpanel"--}}
                    {{--                             aria-labelledby="notification-tab" tabindex="0">--}}
                    {{--                            <div class="setting-form-wrapper profile-information">--}}
                    {{--                                <h5 class="setting-title">Notification</h5>--}}
                    {{--                                <div class="row">--}}
                    {{--                                    <div class="col-lg-6">--}}
                    {{--                                        <ul class="notification-check-list">--}}
                    {{--                                            <li>Where You Receive Comment Notification?</li>--}}
                    {{--                                            <li class="chek-inputs">--}}
                    {{--                                                <input type="checkbox" class="notificatoin-chekbox" id="email">--}}
                    {{--                                                <label for="email">Email</label>--}}
                    {{--                                            </li>--}}
                    {{--                                            <li class="chek-inputs">--}}
                    {{--                                                <input type="checkbox" class="notificatoin-chekbox" id="sms">--}}
                    {{--                                                <label for="sms">SMS</label>--}}
                    {{--                                            </li>--}}
                    {{--                                        </ul>--}}
                    {{--                                        <ul class="notification-check-list">--}}
                    {{--                                            <li>Get Notifications When You're Tagged By</li>--}}
                    {{--                                            <li class="chek-inputs">--}}
                    {{--                                                <input type="checkbox" class="notificatoin-chekbox" id="anyone">--}}
                    {{--                                                <label for="anyone">Anyone</label>--}}
                    {{--                                            </li>--}}
                    {{--                                            <li class="chek-inputs">--}}
                    {{--                                                <input type="checkbox" class="notificatoin-chekbox" id="friends">--}}
                    {{--                                                <label for="friends">Friends</label>--}}
                    {{--                                            </li>--}}
                    {{--                                        </ul>--}}
                    {{--                                        <ul class="notification-check-list">--}}
                    {{--                                            <li>Get Notifications When Updates From Friends</li>--}}
                    {{--                                            <li class="chek-inputs">--}}
                    {{--                                                <input type="checkbox" class="notificatoin-chekbox" id="email2">--}}
                    {{--                                                <label for="email2">Email</label>--}}
                    {{--                                            </li>--}}
                    {{--                                            <li class="chek-inputs">--}}
                    {{--                                                <input type="checkbox" class="notificatoin-chekbox" id="sms2">--}}
                    {{--                                                <label for="sms2">SMS</label>--}}
                    {{--                                            </li>--}}
                    {{--                                        </ul>--}}
                    {{--                                        <h6 class="notification-title">Other Notifications</h6>--}}
                    {{--                                        <ul class="notification-check-list">--}}
                    {{--                                            <li class="chek-inputs">--}}
                    {{--                                                <input type="checkbox" class="notificatoin-chekbox" id="videos">--}}
                    {{--                                                <label for="videos">Recommended Videos</label>--}}
                    {{--                                            </li>--}}
                    {{--                                            <li class="chek-inputs">--}}
                    {{--                                                <input type="checkbox" class="notificatoin-chekbox" id="games">--}}
                    {{--                                                <label for="games">Games</label>--}}
                    {{--                                            </li>--}}
                    {{--                                            <li class="chek-inputs">--}}
                    {{--                                                <input type="checkbox" class="notificatoin-chekbox" id="news">--}}
                    {{--                                                <label for="news">Breaking News</label>--}}
                    {{--                                            </li>--}}
                    {{--                                            <li class="chek-inputs">--}}
                    {{--                                                <input type="checkbox" class="notificatoin-chekbox" id="pageFollow">--}}
                    {{--                                                <label for="pageFollow">Pages Follow Notification</label>--}}
                    {{--                                            </li>--}}
                    {{--                                        </ul>--}}
                    {{--                                    </div>--}}
                    {{--                                    <div class="col-lg-6">--}}
                    {{--                                        <ul class="notification-check-list">--}}
                    {{--                                            <li>Where You Receive Friend Request Notification?</li>--}}
                    {{--                                            <li class="chek-inputs">--}}
                    {{--                                                <input type="checkbox" class="notificatoin-chekbox" id="email3">--}}
                    {{--                                                <label for="email3">Email</label>--}}
                    {{--                                            </li>--}}
                    {{--                                            <li class="chek-inputs">--}}
                    {{--                                                <input type="checkbox" class="notificatoin-chekbox" id="sms3">--}}
                    {{--                                                <label for="sms3">SMS</label>--}}
                    {{--                                            </li>--}}
                    {{--                                        </ul>--}}
                    {{--                                        <ul class="notification-check-list">--}}
                    {{--                                            <li>Where You Receive Birthday Notification?</li>--}}
                    {{--                                            <li class="chek-inputs">--}}
                    {{--                                                <input type="checkbox" class="notificatoin-chekbox" id="email4">--}}
                    {{--                                                <label for="email4">Email</label>--}}
                    {{--                                            </li>--}}
                    {{--                                            <li class="chek-inputs">--}}
                    {{--                                                <input type="checkbox" class="notificatoin-chekbox" id="sms4">--}}
                    {{--                                                <label for="sms4">SMS</label>--}}
                    {{--                                            </li>--}}
                    {{--                                        </ul>--}}
                    {{--                                        <ul class="notification-check-list">--}}
                    {{--                                            <li>Where You Receive Groups Notification?</li>--}}
                    {{--                                            <li class="chek-inputs">--}}
                    {{--                                                <input type="checkbox" class="notificatoin-chekbox" id="email5">--}}
                    {{--                                                <label for="email5">Email</label>--}}
                    {{--                                            </li>--}}
                    {{--                                            <li class="chek-inputs">--}}
                    {{--                                                <input type="checkbox" class="notificatoin-chekbox" id="sms5">--}}
                    {{--                                                <label for="sms5">SMS</label>--}}
                    {{--                                            </li>--}}
                    {{--                                        </ul>--}}
                    {{--                                    </div>--}}
                    {{--                                </div>--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}
                    {{--                        <div class="tab-pane fade" id="message-tab-pane" role="tabpanel" aria-labelledby="message-tab"--}}
                    {{--                             tabindex="0">--}}
                    {{--                            <div class="setting-form-wrapper profile-information">--}}
                    {{--                                <h5 class="setting-title">Messages Setting</h5>--}}
                    {{--                                <div class="row">--}}
                    {{--                                    <div class="col-lg-6">--}}
                    {{--                                        <ul class="notification-check-list">--}}
                    {{--                                            <li>Send Me Messages To My Cell Phone</li>--}}
                    {{--                                            <li class="chek-inputs">--}}
                    {{--                                                <input type="checkbox" class="notificatoin-chekbox" id="on">--}}
                    {{--                                                <label for="on">ON</label>--}}
                    {{--                                            </li>--}}
                    {{--                                            <li class="chek-inputs">--}}
                    {{--                                                <input type="checkbox" class="notificatoin-chekbox" id="off">--}}
                    {{--                                                <label for="sms">OFF</label>--}}
                    {{--                                            </li>--}}
                    {{--                                        </ul>--}}
                    {{--                                        <ul class="notification-check-list">--}}
                    {{--                                            <li>General Announcement, Updates, Posts, And Videos</li>--}}
                    {{--                                            <li class="chek-inputs">--}}
                    {{--                                                <input type="checkbox" class="notificatoin-chekbox" id="on1">--}}
                    {{--                                                <label for="on1">ON</label>--}}
                    {{--                                            </li>--}}
                    {{--                                            <li class="chek-inputs">--}}
                    {{--                                                <input type="checkbox" class="notificatoin-chekbox" id="off1">--}}
                    {{--                                                <label for="sms1">OFF</label>--}}
                    {{--                                            </li>--}}
                    {{--                                        </ul>--}}
                    {{--                                        <ul class="notification-check-list">--}}
                    {{--                                            <li>Messages From Activity On My Page</li>--}}
                    {{--                                            <li class="chek-inputs">--}}
                    {{--                                                <input type="checkbox" class="notificatoin-chekbox" id="on2">--}}
                    {{--                                                <label for="on2">ON</label>--}}
                    {{--                                            </li>--}}
                    {{--                                            <li class="chek-inputs">--}}
                    {{--                                                <input type="checkbox" class="notificatoin-chekbox" id="off2">--}}
                    {{--                                                <label for="sms2">OFF</label>--}}
                    {{--                                            </li>--}}
                    {{--                                        </ul>--}}
                    {{--                                    </div>--}}
                    {{--                                    <div class="col-lg-6">--}}
                    {{--                                        <ul class="notification-check-list">--}}
                    {{--                                            <li>Page Follow Notification</li>--}}
                    {{--                                            <li class="chek-inputs">--}}
                    {{--                                                <input type="checkbox" class="notificatoin-chekbox" id="on3">--}}
                    {{--                                                <label for="on3">ON</label>--}}
                    {{--                                            </li>--}}
                    {{--                                            <li class="chek-inputs">--}}
                    {{--                                                <input type="checkbox" class="notificatoin-chekbox" id="off3">--}}
                    {{--                                                <label for="sms3">OFF</label>--}}
                    {{--                                            </li>--}}
                    {{--                                        </ul>--}}
                    {{--                                        <ul class="notification-check-list">--}}
                    {{--                                            <li>Breaking News</li>--}}
                    {{--                                            <li class="chek-inputs">--}}
                    {{--                                                <input type="checkbox" class="notificatoin-chekbox" id="on4">--}}
                    {{--                                                <label for="on4">ON</label>--}}
                    {{--                                            </li>--}}
                    {{--                                            <li class="chek-inputs">--}}
                    {{--                                                <input type="checkbox" class="notificatoin-chekbox" id="off4">--}}
                    {{--                                                <label for="sms4">OFF</label>--}}
                    {{--                                            </li>--}}
                    {{--                                        </ul>--}}
                    {{--                                    </div>--}}
                    {{--                                </div>--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}
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
        });
    </script>

@endpush

