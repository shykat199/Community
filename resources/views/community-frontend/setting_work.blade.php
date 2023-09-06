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
                    <button class="nav-link" id="edu-tab" data-bs-toggle="tab" data-bs-target="#edu-tab-pane"
                            type="button" role="tab" aria-controls="edu-tab-pane" aria-selected="false">Work Information
                    </button>
                </li>
            </ul>


            <div class="setting-tab-content">
                <div class="tab-content" id="myTabContent">


                        <form class="setting-form-wrapper profile-information"
                              action="{{route('user.my-profile.update.profile.work',$userWork->id)}}" method="post">
                            @csrf

                            <h5 class="setting-title">Work Information</h5>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label for="designation">Designation</label>
                                    <input type="text" value="{{$userWork->designation}}" id="designation"
                                           name="designation"
                                           placeholder="Designation Name">
                                </div>
                                <div class="col-lg-6">
                                    <label for="companyName">Company Name</label>
                                    <input type="text" value="{{$userWork->institute}}" id="companyName"
                                           name="companyName"
                                           placeholder="Company Name">
                                </div>

                                <div class="col-lg-6">
                                    <label for="startingDate">Starting Date</label>
                                    <input type="text" name="startingDate" class="form-control datepicker"
                                           value="{{$userWork->starting_date}}"
                                           placeholder="">

                                </div>

                                <div class="col-lg-6">
                                    <label for="startingDate">Ending Date</label>
                                    <input type="text" name="passingDate" class="form-control datepicker"
                                           value="{{$userWork->ending_date}}"
                                           placeholder="">

                                </div>

                                <div class="col-lg-6">
                                    <label for="company">About Company</label>
                                    <textarea class="form-control" id="editor1" placeholder="Enter the Description"
                                              name="company">{!! $userWork->description!!}</textarea>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" name="is_present" type="checkbox" {{$userWork->is_present===1?'checked':''}}
                                               id="flexSwitchCheckDefault">
                                        <label class="form-check-label" for="flexSwitchCheckDefault">Is Present</label>
                                    </div>

                                </div>

                                <div class="col-12 mt-2">
                                    <button type="submit" class="social-theme-btn save-btn">Save</button>
                                </div>
                            </div>
                        </form>

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
        $(document).ready(function () {
            $('.js-example-basic-multiple').select2();
        });
    </script>

@endpush

