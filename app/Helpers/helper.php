<?php

use App\Models\Community\Group\CommunityUserGroup;
use App\Models\Community\Page\CommunityPage;
use App\Models\User;
use App\Models\Community\User\CommunityUserFollowing;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


function bloodGroups()
{
    $bloodGropes = [
        "A+",
        "A-",
        "B+",
        "B-",
        "AB+",
        "AB-",
        "O+",
        "O-"
    ];
    return $bloodGropes;
}

function allLanguages()
{
    $allLanguages = [
        "English",
        "Mandarin Chinese",
        "Hindi",
        "Spanish",
        "French",
        "Modern Standard Arabic",
        "Bengali",
        "Russian",
        "Portuguese",
        "Urdu",
        "Indonesian",
        "Standard German",
        "Japanese",
        "Nigerian Pidgin",
        "Marathi",
        "Telugu",
        "Turkish",
        "Tamil",
        "Yue Chinese",
        "Vietnamese",
        "Tagalog",
    ];
    return $allLanguages;
}

function allCountries()
{
    $countries = array(
        'Afghan',
        'Albanian',
        'Algerian',
        'American',
        'Andorran',
        'Angolan',
        'Antiguans',
        'Argentinean',
        'Armenian',
        'Australian',
        'Austrian',
        'Azerbaijani',
        'Bahamian',
        'Bahraini',
        'Bangladeshi',
        'Barbadian',
        'Barbudans',
        'Batswana',
        'Belarusian',
        'Belgian',
        'Belizean',
        'Beninese',
        'Bhutanese',
        'Bolivian',
        'Bosnian',
        'Brazilian',
        'British',
        'Bruneian',
        'Bulgarian',
        'Burkinabe',
        'Burmese',
        'Burundian',
        'Cambodian',
        'Cameroonian',
        'Canadian',
        'Cape Verdean',
        'Central African',
        'Chadian',
        'Chilean',
        'Chinese',
        'Colombian',
        'Comoran',
        'Congolese',
        'Costa Rican',
        'Croatian',
        'Cuban',
        'Cypriot',
        'Czech',
        'Danish',
        'Djibouti',
        'Dominican',
        'Dutch',
        'East Timorese',
        'Ecuadorean',
        'Egyptian',
        'Emirian',
        'Equatorial Guinean',
        'Eritrean',
        'Estonian',
        'Ethiopian',
        'Fijian',
        'Filipino',
        'Finnish',
        'French',
        'Gabonese',
        'Gambian',
        'Georgian',
        'German',
        'Ghanaian',
        'Greek',
        'Grenadian',
        'Guatemalan',
        'Guinea-Bissauan',
        'Guinean',
        'Guyanese',
        'Haitian',
        'Herzegovinian',
        'Honduran',
        'Hungarian',
        'I-Kiribati',
        'Icelander',
        'Indian',
        'Indonesian',
        'Iranian',
        'Iraqi',
        'Irish',
        'Israeli',
        'Italian',
        'Ivorian',
        'Jamaican',
        'Japanese',
        'Jordanian',
        'Kazakhstani',
        'Kenyan',
        'Kittian and Nevisian',
        'Kuwaiti',
        'Kyrgyz',
        'Laotian',
        'Latvian',
        'Lebanese',
        'Liberian',
        'Libyan',
        'Liechtensteiner',
        'Lithuanian',
        'Luxembourger',
        'Macedonian',
        'Malagasy',
        'Malawian',
        'Malaysian',
        'Maldivan',
        'Malian',
        'Maltese',
        'Marshallese',
        'Mauritanian',
        'Mauritian',
        'Mexican',
        'Micronesian',
        'Moldovan',
        'Monacan',
        'Mongolian',
        'Moroccan',
        'Mosotho',
        'Motswana',
        'Mozambican',
        'Namibian',
        'Nauruan',
        'Nepali',
        'New Zealander',
        'Nicaraguan',
        'Nigerian',
        'Nigerien',
        'North Korean',
        'Northern Irish',
        'Norwegian',
        'Omani',
        'Pakistani',
        'Palauan',
        'Panamanian',
        'Papua New Guinean',
        'Paraguayan',
        'Peruvian',
        'Polish',
        'Portuguese',
        'Qatari',
        'Romanian',
        'Russian',
        'Rwandan',
        'Saint Lucian',
        'Salvadoran',
        'Samoan',
        'San Marinese',
        'Sao Tomean',
        'Saudi',
        'Scottish',
        'Senegalese',
        'Serbian',
        'Seychellois',
        'Sierra Leonean',
        'Singaporean',
        'Slovakian',
        'Slovenian',
        'Solomon Islander',
        'Somali',
        'South African',
        'South Korean',
        'Spanish',
        'Sri Lankan',
        'Sudanese',
        'Surinamer',
        'Swazi',
        'Swedish',
        'Swiss',
        'Syrian',
        'Taiwanese',
        'Tajik',
        'Tanzanian',
        'Thai',
        'Togolese',
        'Tongan',
        'Trinidadian/Tobagonian',
        'Tunisian',
        'Turkish',
        'Tuvaluan',
        'Ugandan',
        'Ukrainian',
        'Uruguayan',
        'Uzbekistani',
        'Venezuelan',
        'Vietnamese',
        'Welsh',
        'Yemenite',
        'Zambian',
        'Zimbabwean'
    );
    return $countries;
}

function allPages($id = null)
{


    if (empty($id)) {
        $allPages = CommunityPage::join('users', 'users.id', 'community_pages.user_id')
            ->leftJoin('community_page_profile_photos as profile_photo', 'profile_photo.page_id', '=', 'community_pages.id')
            ->leftJoin('community_page_follow_likes as likes', function ($q) {
                $q->on('likes.page_id', '=', 'community_pages.id');
                $q->where('likes.user_id', '=', Auth::id());
                $q->whereRaw('likes.page_like = 1');
            })
            ->selectRaw('users.name,users.id,community_pages.page_name,community_pages.id as pId,profile_photo.page_profile_photo,COUNT(likes.id) as likeCounts')
            ->groupBy('community_pages.id')
            ->get();
    } else {
        $allPages = CommunityPage::join('users', function ($q) use ($id) {
            $q->on('users.id', 'community_pages.user_id');
            $q->where('community_pages.id', '!=', $id);
        })
            ->leftJoin('community_page_profile_photos as profile_photo', 'profile_photo.page_id', '=', 'community_pages.id')
            ->leftJoin('community_page_follow_likes as likes', function ($q) {
                $q->on('likes.page_id', '=', 'community_pages.id');
                $q->where('likes.user_id', '=', Auth::id());
                $q->whereRaw('likes.page_like = 1');
            })
            ->selectRaw('users.name,users.id,community_pages.page_name,community_pages.id as pId,profile_photo.page_profile_photo,COUNT(likes.id) as likeCounts')
            ->groupBy('community_pages.id')
            ->get();
    }


    return $allPages;

}

function allGroups($id = null)
{

    if (empty($id)) {

        $allGroups = CommunityUserGroup::join('community_user_group_pivots', function ($q) use ($id) {
            $q->on('community_user_group_pivots.group_id', '=', 'community_user_groups.id');
            $q->where('community_user_group_pivots.user_status', '=', 1);

        })
            ->leftJoin('community_user_group_pivots as group_owner_pivots', function ($q) {
                $q->on('group_owner_pivots.group_id', 'community_user_groups.id');
                $q->where('group_owner_pivots.user_status', '=', 1);
                $q->where('group_owner_pivots.group_user_role', '=', 1);
            })
            ->leftjoin('users', 'users.id', 'group_owner_pivots.user_id')
            ->leftJoin('community_user_group_profile_photos', 'community_user_group_profile_photos.group_id', 'community_user_groups.id')
            ->selectRaw('community_user_groups.id as cGroupId,community_user_groups.group_name,
            community_user_group_profile_photos.group_profile_photo,
             COUNT(community_user_group_pivots.id) as userCount
            ')
            ->groupBy('community_user_groups.id')
            ->inRandomOrder()->limit(5)
            ->get();
    } else {

        $allGroups = CommunityUserGroup::join('community_user_group_pivots', function ($q) use ($id) {
            $q->on('community_user_group_pivots.group_id', '=', 'community_user_groups.id');
            $q->where('community_user_group_pivots.user_status', '=', 1);
            $q->where('community_user_groups.id', '!=', $id);
        })
            ->leftJoin('community_user_group_pivots as group_owner_pivots', function ($q) {
                $q->on('group_owner_pivots.group_id', 'community_user_groups.id');
                $q->where('group_owner_pivots.user_status', '=', 1);
                $q->where('group_owner_pivots.group_user_role', '=', 1);
            })
            ->leftjoin('users', 'users.id', 'group_owner_pivots.user_id')
            ->leftJoin('community_user_group_profile_photos', 'community_user_group_profile_photos.group_id', 'community_user_groups.id')
            ->selectRaw('community_user_groups.id as cGroupId,community_user_groups.group_name,
            community_user_group_profile_photos.group_profile_photo,
             COUNT(community_user_group_pivots.id) as userCount
            ')
            ->groupBy('community_user_groups.id')
            ->inRandomOrder()->limit(5)
            ->get();

    }


    return $allGroups;

}

function allUserFollowers($id = null)
{


    if (empty($id)) {
        $userFollowers = CommunityUserFollowing::with('users.userProfileImages')->join('users', 'users.id', 'community_user_followings.user_id')
            ->leftjoin('community_user_followings as myFollows', 'myFollows.user_id', 'myFollows.user_following_id')
            ->where('community_user_followings.user_following_id', Auth::id())
            ->where('users.role', '!=', ADMIN_ROLE)
            ->selectRaw('users.id as uId,users.name as userName,community_user_followings.user_following_id,community_user_followings.id as flowId,
        community_user_followings.user_id,myFollows.id as is_followed')->get();
    } else {
        $userFollowers = CommunityUserFollowing::with('users.userProfileImages')->join('users', 'users.id', 'community_user_followings.user_id')
            ->leftjoin('community_user_followings as myFollows', 'myFollows.user_id', 'myFollows.user_following_id')
            ->where('community_user_followings.user_following_id', $id)
            ->where('users.role', '!=', ADMIN_ROLE)
            ->selectRaw('users.id as uId,users.name as userName,community_user_followings.user_following_id,community_user_followings.id as flowId,
        community_user_followings.user_id,myFollows.id as is_followed')->get();
    }

    return $userFollowers;
}

function countFollowing()
{

    $countFollower = CommunityUserFollowing::join('users', 'users.id', 'community_user_followings.user_id')
        ->where('community_user_followings.user_id', Auth::user()->id)
        ->where('users.role', '!=', ADMIN_ROLE)
        ->selectRaw('COUNT(community_user_followings.user_id) as userFollowings')
        ->groupBy('community_user_followings.user_id')
        ->get();

    return $countFollower;

}

function countFollowers()
{

    $countFollowers = CommunityUserFollowing::join('users', 'users.id', 'community_user_followings.user_id')
        ->where('community_user_followings.user_following_id', Auth::user()->id)
        ->where('users.role', '!=', ADMIN_ROLE)
        ->selectRaw('COUNT(community_user_followings.user_id) as userFollowers')
        ->groupBy('community_user_followings.user_following_id')
        ->get();

    return $countFollowers;

}

function allRequestedFriend()
{

//    $requestedFriendList=User::with('userProfileImages')
//        ->join('community_user_friend_requests',function ($q){
//            $q->on('community_user_friend_requests.receiver_user_id','=','users.id');
//            $q->where('community_user_friend_requests.sender_user_id','=',Auth::id());
//        })->get();

    $requestedFriendList  = User::with('userProfileImages')->join('community_user_friend_requests', 'community_user_friend_requests.receiver_user_id', '=', 'users.id')
        ->join('community_user_friend_requests as countRequest', 'countRequest.receiver_user_id', '=', 'users.id')
        ->where('community_user_friend_requests.status', '=', 0)
        ->where('community_user_friend_requests.sender_user_id', '=', Auth::id())
        ->leftJoin('community_user_friends as f1', 'f1.user_id', '=', 'users.id')
        ->leftJoin('community_user_friends as f2', function ($q) {
            $q->on('f1.requested_user_id', '=', 'f2.requested_user_id');
            $q->where('f1.user_id', '=', Auth::id());
            $q->where('f2.user_id', '=', 'users.id');
        })
        ->leftJoin('community_user_friend_requests as friendReq','friendReq.receiver_user_id','=','users.id')
        ->leftJoin('community_user_followings as userFollowings', function ($q) {
            $q->on('userFollowings.user_id', '=', 'community_user_friend_requests.sender_user_id');
        })
        ->leftJoin('community_user_followings as usersFollowers', function ($q) {
            $q->on('userFollowings.user_following_id', '=', 'community_user_friend_requests.sender_user_id');
        })
        ->leftJoin('community_user_profile_photos as profilePhoto', function ($q) {
            $q->on('profilePhoto.user_id', '=', 'community_user_friend_requests.sender_user_id');
            $q->where('users.id', '!=', ADMIN_ROLE);
        })
        ->leftJoin('community_user_profile_covers as profileCover', function ($q) {
            $q->on('profileCover.user_id', '=', 'community_user_friend_requests.sender_user_id');
            $q->where('users.id', '!=', ADMIN_ROLE);
        })
        ->selectRaw('users.id,users.name as userName,community_user_friend_requests.id as reqId,COUNT(f1.id) as countMutualFriend,COUNT(userFollowings.id) as followings,COUNT(usersFollowers.id) as followers,
        profilePhoto.user_profile,profileCover.user_cover,friendReq.sender_user_id as requestedId')
        ->groupBy('users.id')
        ->get();
    return $requestedFriendList;
}

function countRequest()
{
    $countRequest = User::join('community_user_friend_requests', 'community_user_friend_requests.receiver_user_id', 'users.id')
        ->where('community_user_friend_requests.status', '=', 0)
        ->where('users.id', '!=', ADMIN_ROLE)
        ->where('community_user_friend_requests.receiver_user_id', '=', Auth::id())
        ->select(DB::raw('COUNT(community_user_friend_requests.id) as total'))
        ->groupBy('users.id')->get();
    return $countRequest;

}

function myFriends()
{
    $myFriends = User::with('userProfileImages')->join('community_user_friends', function ($q) {
        $q->on('community_user_friends.requested_user_id', '=', 'users.id');
        $q->where('users.id', '!=', ADMIN_ROLE);
        $q->where('community_user_friends.user_id', '=', Auth::id());
    })
        ->leftJoin('community_user_profile_photos as profilePhoto', function ($q) {
            $q->on('profilePhoto.user_id', '=', 'community_user_friends.requested_user_id');
            $q->where('users.id', '!=', ADMIN_ROLE);
        })
        ->leftJoin('community_user_profile_covers as profileCover', function ($q) {
            $q->on('profileCover.user_id', '=', 'community_user_friends.requested_user_id');
            $q->where('users.id', '!=', ADMIN_ROLE);

        })
        ->leftJoin('community_user_followings as userFollowers', function ($q) {
            $q->on('userFollowers.user_id', '=', 'community_user_friends.requested_user_id');
        })
        ->leftJoin('community_user_followings as userFollowings', function ($q) {
            $q->on('userFollowings.user_following_id', '=', 'community_user_friends.requested_user_id');
        })
        ->leftJoin('community_user_details as userDetails', function ($q) {
            $q->on('userDetails.user_id', '=', 'users.id');
        })
        ->selectRaw('users.id,users.name as userName,profilePhoto.user_id as profileUserId,profilePhoto.user_profile,
        profileCover.user_cover,COUNT(userFollowers.id) as userFollowers,COUNT(userFollowings.id) as userFollowings,userDetails.birthplace')
        ->groupBy('users.id')
        ->orderBy('users.name')
        ->get();

    return $myFriends;
}

function recentlyAddedFriends()
{

    $myFriends = User::with(['userProfileImages', 'userCoverImages'])->join('community_user_friends', function ($q) {
        $q->on('community_user_friends.requested_user_id', '=', 'users.id');
        $q->where('users.id', '!=', ADMIN_ROLE);
        $q->where('community_user_friends.user_id', '=', Auth::id());
    })
        ->leftJoin('community_user_profile_photos as profilePhoto', function ($q) {
            $q->on('profilePhoto.user_id', '=', 'community_user_friends.requested_user_id');
            $q->where('users.id', '!=', ADMIN_ROLE);
        })
        ->leftJoin('community_user_profile_covers as profileCover', function ($q) {
            $q->on('profileCover.user_id', '=', 'community_user_friends.requested_user_id');
            $q->where('users.id', '!=', ADMIN_ROLE);

        })
        ->leftJoin('community_user_followings as userFollowers', function ($q) {
            $q->on('userFollowers.user_id', '=', 'community_user_friends.requested_user_id');
        })
        ->leftJoin('community_user_followings as userFollowings', function ($q) {
            $q->on('userFollowings.user_following_id', '=', 'community_user_friends.requested_user_id');
        })
        ->leftJoin('community_user_details as userDetails', function ($q) {
            $q->on('userDetails.user_id', '=', 'users.id');
        })
        ->selectRaw('users.id,users.name as userName,profilePhoto.user_id as profileUserId,profilePhoto.user_profile,
        profileCover.user_cover,COUNT(userFollowers.id) as userFollowers,COUNT(userFollowings.id) as userFollowings,userDetails.birthplace')
        ->groupBy('users.id')
        ->orderBy('community_user_friends.created_at', 'DESC')
        ->get();
    return $myFriends;

}

function countFriends()
{
    $countFriends = User::join('community_user_friends', 'community_user_friends.requested_user_id', 'users.id')
        ->where('users.id', '!=', ADMIN_ROLE)
        ->where('community_user_friends.user_id', '=', Auth::id())
        ->groupBy('community_user_friends.user_id')
        ->count();
    return $countFriends;
}

function userAllPhoto()
{
    $imgArray = [];

    $allPhotos = User::join('community_user_posts as userPost', 'userPost.user_id', '=', 'users.id')
        ->where('userPost.user_id', '!=', ADMIN_ROLE)
        ->where('userPost.user_id', '=', Auth::id())
        ->leftJoin('community_user_post_file_types as postFile', 'postFile.post_id', '=', 'userPost.id')
        ->where('postFile.post_image_video', 'LIKE', '%' . 'image' . '%')
        ->orderByDesc('postFile.id')->pluck('postFile.post_image_video')->toArray();

//dd($allPhotos);
    foreach ($allPhotos as $imgPhoto) {
        $mediaExtension = explode('.', $imgPhoto);
//dd($mediaExtension);
        if ($mediaExtension[2] === 'png' || $mediaExtension[2] === 'jpeg' || $mediaExtension[2] === 'jpg' || $mediaExtension[2] === 'gif') {
            $imgArray[] = $imgPhoto;
        }
//        dd($imgArray);
    }

    return $imgArray;

}

function userPhotoAlbum()
{

    $coverImgArray = [];
    $profileImgArray = [];
    $uploadedImage = [];
    $userPhotoAlbum = [];
    $allProfilePhotos = \App\Models\Community\User_Profile\CommunityUserProfilePhoto::where('user_id', '=', Auth::id())->select('user_profile');
    $allCoverProfilePhotos = \App\Models\Community\User_Profile\CommunityUserProfileCover::where('user_id', '=', Auth::id())->select('user_cover')
        ->unionAll($allProfilePhotos);
    $allPostImage = \App\Models\Community\User\CommunityUserPostFileType::leftJoin('community_user_posts', 'community_user_posts.id', '=', 'community_user_post_file_types.post_id')
        ->where('community_user_posts.user_id', '=', Auth::id())
        ->where('community_user_post_file_types.post_image_video', 'LIKE', '%' . 'image' . '%')
        ->select('post_image_video as allPostMedia')
        ->unionAll($allCoverProfilePhotos)->get();

//    dd($allPostImage);

    foreach ($allPostImage as $imgPhoto) {

        $mediaExtension = explode('.', $imgPhoto->allPostMedia);
//        dd($mediaExtension);

        if ($mediaExtension[2] === 'png' || $mediaExtension[2] === 'jpeg' || $mediaExtension[2] === 'jpg' || $mediaExtension[2] === 'gif') {

            if ($mediaExtension[1] === 'cover-Photo') {
                $coverImgArray[] = $imgPhoto->allPostMedia;
                $userPhotoAlbum['pp'] = $coverImgArray;
//                dd($coverImgArray);
            } elseif ($mediaExtension[1] === 'profile-Photo') {
                $profileImgArray[] = $imgPhoto->allPostMedia;
                $userPhotoAlbum['pc'] = $profileImgArray;
            } elseif ($mediaExtension[1] === 'image') {
                $uploadedImage[] = $imgPhoto->allPostMedia;
                $userPhotoAlbum['img'] = $uploadedImage;
            } else {
                return $data = "No Data";
            }
        }
    }

    return $userPhotoAlbum;

}

function getUpComingBirthday()
{

    $currentDate = \Carbon\Carbon::now();
    $allBirthdays = User::with('userProfileImages')->join('community_user_friends as userFriend', function ($q) {
        $q->on('userFriend.requested_user_id', '=', 'users.id');
        $q->where('userFriend.user_id', '=', Auth::id());
        $q->where('userFriend.user_id', '!=', ADMIN_ROLE);
    })
        ->join('community_user_details as userDetails', function ($q) use ($currentDate) {
            $q->on('userDetails.user_id', '=', 'userFriend.requested_user_id');
            $q->whereRaw("DATE_FORMAT(userDetails.dob,'%m-%d') > DATE_FORMAT(now(), '%m-%d')");
            $q->whereRaw('MONTH(userDetails.dob) = ' . Carbon::now()->format('m'));
        })
        ->selectRaw('users.id , users.name as userName,userDetails.dob')
        ->orderBy('userDetails.dob', 'ASC')
        ->get();
    return $allBirthdays;
}

function getMyPostTimeLine()
{
    $allMyPosts = \App\Models\Community\User\CommunityUserPost::with(['users.userProfileImages', 'newsFeedComments.replies'])
        ->join('users', function ($q) {
            $q->on('users.id', '=', 'community_user_posts.user_id');
            $q->where('users.id', '!=', ADMIN_ROLE);
            $q->where('users.id', '=', Auth::id());
        })
        ->leftJoin('community_user_post_file_types as postMedia', function ($q) {
            $q->on('postMedia.post_id', '=', 'community_user_posts.id');
        })
        ->leftJoin('community_user_post_tags as userTag', function ($q) {
            $q->on('userTag.user_post_id', '=', 'community_user_posts.id');
        })
        ->leftJoin('users as taggedUser', function ($q) {
            $q->on('taggedUser.id', '=', 'userTag.tag_user_id');
        })
        ->leftJoin('community_user_post_reactions as userPostReaction', function ($q) {
            $q->on('userPostReaction.user_post_id', '=', 'community_user_posts.id');
            $q->where('userPostReaction.user_id', '=', Auth::id());
        })
        ->selectRaw('users.id as user_id,users.name as userName,community_user_posts.id as postId,community_user_posts.post_description as postDescription,community_user_posts.created_at,
        postMedia.post_image_video as postMediaFile, postMedia.caption as postMediaFileCaption,userTag.tag_user_id as taggedUser,
        userPostReaction.reaction_type,userPostReaction.id as reactionId,
        taggedUser.name as taggedUserName')
        ->latest()
        ->get()->map(function ($q) {
            $q->setRelation('newsFeedComments', $q->newsFeedComments->take(2));
            return $q;
        });

    $allMyPosts = $allMyPosts->each(function ($item) {
        $item->newsFeedComments->each(function ($comment) {
            $comment->load('users.userProfileImages');
        });
    });

    return $allMyPosts;
}

function myPostReactionCount($id)
{
    $reactionCount = \App\Models\Community\User\CommunityUserPost::join('community_user_post_reactions as postReaction', 'postReaction.user_post_id', '=', 'community_user_posts.id')
        ->where('postReaction.user_post_id', '=', $id)
        ->groupBy('community_user_posts.id')
        ->count();

    return $reactionCount;
}

function myPostCommentCount($id)
{
    $reactionCount = \App\Models\Community\User\CommunityUserPost::join('community_user_post_comments as postComment', 'postComment.user_post_id', '=', 'community_user_posts.id')
        ->where('postComment.user_post_id', '=', $id)
        ->groupBy('community_user_posts.id')
        ->count();

    return $reactionCount;
}

function allUsersDetails()
{
    $allUserDetails = User::with('userProfileImages')->leftJoin('community_user_details as userDetail', function ($q) {
        $q->on('userDetail.user_id', '=', 'users.id');
        $q->where('userDetail.user_id', '=', Auth::id());
        $q->where('userDetail.user_id', '!=', ADMIN_ROLE);
    })
        ->leftJoin('community_user_profile_covers as userCover', 'userCover.user_id', '=', 'users.id')
        ->leftJoin('community_user_profile_photos as userProfile', 'userProfile.user_id', '=', 'users.id')
        ->selectRaw('users.id,userDetail.birthplace,GROUP_CONCAT(userCover.user_cover ORDER BY userCover.created_at DESC) as user_cover,
        GROUP_CONCAT(userProfile.user_profile ORDER BY userProfile.created_at DESC) as user_profile')
        ->groupBy('users.id')
        ->first();
    return $allUserDetails;
}

function allMonths()
{
    $months = ["January", "February", "March", "April", "May", "June", "July",
        "August", "September", "October", "November", "December"];
    return $months;
}

//function countReactions($id)
//{
//    $countReaction = \App\Models\Community\User_Post\CommunityUserPostReaction::join('community_user_posts as userPost', function ($q) use ($id) {
//        $q->on('userPost.id', '=', 'community_user_post_reactions.user_post_id');
//        $q->where('community_user_post_reactions.user_post_id', '=', $id);
//    })
//        ->selectRaw('COUNT(community_user_post_reactions.id) as reactionCount')
//        ->groupBy('userPost.id')
//        ->first();
//    return $countReaction;
//}

function countComments($id)
{
    $countComments = \App\Models\Community\User\CommunityUserPost::join('community_user_post_comments as userComment', function ($q) use ($id) {
        $q->on('userComment.user_post_id', '=', 'community_user_posts.id');
        $q->where('userComment.user_post_id', '=', $id);
    })
        ->selectRaw('COUNT(userComment.id) as commentCount')
        ->groupBy('community_user_posts.id')
        ->first();
    return $countComments;
}

function getGroupPostCount($id)
{
    $allGroupPostCount = CommunityUserGroup::leftJoin('community_user_group_posts as groupPost', 'groupPost.group_id', '=', 'community_user_groups.id')
        ->where('groupPost.group_id', '=', $id)
        ->groupBy('community_user_groups.id')
        ->count();
    return $allGroupPostCount;
}


function getAllGroupUserRequest($id)
{

    $groupUsers = User::join('community_user_group_pivots as userGroupPivot', function ($q) use ($id) {
        $q->on('userGroupPivot.user_id', '=', 'users.id');
        $q->where('userGroupPivot.group_user_role', '=', 3);
        $q->where('userGroupPivot.user_status', '=', 0);
        $q->where('userGroupPivot.group_id', '=', $id);
    })
        ->leftJoin('community_user_group_profile_photos as groupProfile', 'groupProfile.group_id', '=', 'users.id')
        ->leftJoin('community_user_group_cover_photos as groupCover', 'groupCover.group_id', '=', 'users.id')
        ->selectRaw('users.id as Uid,users.name,groupProfile.group_profile_photo as gProfile,groupCover.cover_photo as gCover,userGroupPivot.id,userGroupPivot.group_id')
        ->orderBy('userGroupPivot.id', 'DESC')
        ->limit(6)
        ->get();

    return $groupUsers;
}

function getGroupUserList($id)
{

    $allGroupUsers = User::join('community_user_group_pivots as userGroupPivot', function ($q) use ($id) {
        $q->on('userGroupPivot.user_id', '=', 'users.id');
        $q->where('userGroupPivot.user_status', '=', 1);
        $q->where('userGroupPivot.group_id', '=', $id);
    })
        ->leftJoin('community_user_group_profile_photos as groupProfile', 'groupProfile.group_id', '=', 'users.id')
        ->leftJoin('community_user_group_cover_photos as groupCover', 'groupCover.group_id', '=', 'users.id')
        ->selectRaw('userGroupPivot.id as pivotId,userGroupPivot.user_id as uId,users.name,
        groupProfile.group_profile_photo as gProfile,groupCover.cover_photo as gCover,
        userGroupPivot.id,userGroupPivot.group_user_role,
        userGroupPivot.user_id,userGroupPivot.group_id')
        ->get();
    return $allGroupUsers;
}


function getGroupPostCommentCount($id)
{

    $getGroupPostCommentCount = \App\Models\Community\Group\CommunityUserGroupPostComment::join('community_user_group_posts as userGroupPost', function ($q) use ($id) {
        $q->on('userGroupPost.id', '=', 'community_user_group_post_comments.group_post_id');
        $q->where('community_user_group_post_comments.group_post_id', '=', $id);
    })
        ->groupBy('userGroupPost.id')
        ->count();
    return $getGroupPostCommentCount;
}

function getGroupPostReactionCount($id)
{

    $getGroupPostReactionCount = \App\Models\Community\Group\CommunityUserGroupPostReaction::join('community_user_group_posts as userGroupPost', function ($q) use ($id) {
        $q->on('userGroupPost.id', '=', 'community_user_group_post_reactions.group_post_id');
        $q->where('community_user_group_post_reactions.group_post_id', '=', $id);
    })
        ->groupBy('userGroupPost.id')
        ->count();
    return $getGroupPostReactionCount;
}

function getUserTimeLinePostReactionCount($id)
{

    $getUserPostReactionCount = \App\Models\Community\User_Post\CommunityUserPostReaction::join('community_user_posts as userPost', function ($q) use ($id) {
        $q->on('userPost.id', '=', 'community_user_post_reactions.user_post_id');
        $q->where('community_user_post_reactions.user_post_id', '=', $id);
    })
        ->groupBy('userPost.id')
        ->count();
    return $getUserPostReactionCount;
}

function getUserTimeLinePostCommentCount($id)
{

    $getUserPostReactionCount = \App\Models\Community\User_Post\CommunityUserPostComment::join('community_user_posts as userPost', function ($q) use ($id) {
        $q->on('userPost.id', '=', 'community_user_post_comments.user_post_id');
        $q->where('community_user_post_comments.user_post_id', '=', $id);
    })
        ->groupBy('userPost.id')
        ->count();
    return $getUserPostReactionCount;
}

function pageLikeCount($id)
{
//    dd($id);
    $pageLikeCount = CommunityPage::leftJoin('community_page_follow_likes as likes', function ($q) use ($id) {
        $q->on('likes.page_id', '=', 'community_pages.id');
        $q->whereRaw("likes.page_id = $id");
        $q->whereRaw('likes.page_like = 1');
    })
        ->groupBy('community_pages.id')
        ->count();
    return $pageLikeCount;
}

function pageFollowCount($id)
{
    $pageFollowCount = \App\Models\Community\Page\CommunityPageFollowLike::leftJoin('community_pages', function ($q) use ($id) {
        $q->on('community_pages.id', '=', 'community_page_follow_likes.page_id');
        $q->where('community_page_follow_likes.page_follow', '!=', 0);
        $q->where('community_page_follow_likes.page_id', '=', $id);
    })
        ->groupBy('community_pages.id')
        ->count();

    return $pageFollowCount;
}


function getAllComments()
{

}


