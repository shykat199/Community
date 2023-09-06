<?php

namespace App\Http\Controllers\Service;
use App\Models\Service\ServiceCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function category(){
        return view('Service.service-category.add');
    }
    public function PostCategory(Request $request){
        //dd($request->all());

//        $categories = ServiceCategory::create([
//            'name'=>$request->get('name')
//        ]);

        //$blogs->user()->associate(Auth::user());
        // $categories->save();


//        if($categories){
//            return to_route('category.list')->with('posted','Data Entry Successfull');
//
//        }else{
//            return Redirect::back();
//        }

    }

    public function CategoryList(){
//        $categories= DB::table('ServiceCategories')->latest()->get();
//        //dd($categories);
        return view('Service.service-category.list');
    }
}
