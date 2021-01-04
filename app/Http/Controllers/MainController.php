<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\CategoryModel;
use App\User;
use App\UserTimeModel;
use App\ItemModel;
use Auth;


class MainController extends Controller
{
    public function firstPage($id, $cat = 1){

        $restaurant = User::where('restaurant_id','=',$id)->where('package_id','=','1')->first();
        $time = UserTimeModel::where('user_id','=',$id)->orderBy('week_id','asc')->get();
        $category = CategoryModel::where('user_id','=',$id)->where('status', '=', '0')->where('is_delete','=','0')->orderBy('category_order_by','asc')->get();
        $items = ItemModel::where('user_id','=',$id)->where('category_id','=',$cat)->orderBy('order_by','asc')->get();

        // print_r(json_encode($category));die;
        return view("client.main",['restaurant'=>$restaurant,'time'=>$time,'category'=>$category,'items'=>$items,'user'=>'guest']);
    }

    public function login(Request $request){

        // $restaurant = User::where('restaurant_id','=',$request->userR)->where('package_id','=','1')->first();
        // $time = UserTimeModel::where('user_id','=',$request->userR)->orderBy('week_id','asc')->get();
        // $category = CategoryModel::where('user_id','=',$request->userR)->where('status', '=', '0')->where('is_delete','=','0')->orderBy('category_order_by','asc')->get();
        // $items = ItemModel::where('user_id','=',$request->userR)->where('category_id','=',1)->orderBy('order_by','asc')->get();
        

        if (Auth::attempt(['username' => $request->userN, 'password' => $request->userP, 'is_delete' => '0'], true)) {

            if(empty(Auth::user()->status))
			{	
                return view('client.main',['user'=>Auth::user()->username, 'success'=>true]);
			}
			else
			{
				return redirect()->back()->with('error', 'Please enter the correct credentials');	
			}
		} else {
			return redirect()->back()->with('error', 'Please enter the correct credentials');
        }
        
        // return;
  
    }

    public function register(Request $request){

        
    }
}
