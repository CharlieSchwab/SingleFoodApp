<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\CategoryModel;
use App\User;
use App\UserTimeModel;
use App\ItemModel;


class MainController extends Controller
{
    public function firstPage($id, $cat = 1){

        $restaurant = User::where('restaurant_id','=',$id)->where('package_id','=','1')->first();
        $time = UserTimeModel::where('user_id','=',$id)->orderBy('week_id','asc')->get();
        $category = CategoryModel::where('user_id','=',$id)->where('status', '=', '0')->where('is_delete','=','0')->orderBy('category_order_by','asc')->get();
        $items = ItemModel::where('user_id','=',$id)->where('category_id','=',$cat)->orderBy('order_by','asc')->get();

        // print_r(json_encode($category));die;
        
        return view("client.main",['restaurant'=>$restaurant,'time'=>$time,'category'=>$category,'items'=>$items]);
    }
   
}
