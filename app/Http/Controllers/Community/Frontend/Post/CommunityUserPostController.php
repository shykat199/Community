<?php

namespace App\Http\Controllers\Community\Frontend\Post;

use App\Http\Controllers\Controller;
use App\Models\Community\User\CommunityUserPost;
use App\Models\Community\User\CommunityUserPostFileType;
use App\Models\Community\User\CommunityUserPostTag;
use Carbon\Carbon;
use Faker\Provider\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class CommunityUserPostController extends Controller
{

    public function store(Request $request)
    {
//        dd($request->all());

        $fileName = null;
        $userPost=CommunityUserPost::create([
            'user_id'=>Auth::id(),
            'post_description'=>$request->get('postMessage')
        ]);
//        dd($userPost->id);
        if ($userPost){
            if ($request->hasFile('postFile')){
                $fileName = Uuid::uuid() . '.' . $request->file('postFile')->getClientOriginalExtension();
                $file = Storage::put('/public/community/post' . $fileName, file_get_contents($request->file('postFile')));
            }

            $postImageCaption=CommunityUserPostFileType::create([
                'post_id'=>$userPost->id,
                'post_image_video'=>$fileName,
                'caption'=>$request->get('imageCaption'),
            ]);

            if ($request->get('tagId')){
                $input['tagId']=$request->input('tagId');
//                dd(is_array($input['tagId']));
                if (is_array($input['tagId'])){
                    foreach ($input['tagId'] as $key=>$value){
                        $tagUsers=CommunityUserPostTag::insert([
                            'user_id'=>Auth::id(),
                            'tag_user_id'=>$value,
                            'user_post_id'=>$userPost->id,
                            'created_at'=>Carbon::now(),
                            'updated_at'=>Carbon::now(),
                        ]);
                    }

                }

            }

        }

        if ($userPost || $postImageCaption){
//            toastr('dd', 'success');
            toastr()->success('Post has been posted successfully!','Congrats');
            return Redirect::back();
        }
        toastr()->error('An error has occurred please try again later.');

    }

}
