<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\USERS_TB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class C_login extends Controller
{
    public function index()
    {
        if (session()->get('user_data')) {
            return redirect()->back();
        }
        return view('auth.sign-in');
    }
    public function checkData(Request $request)
    {
        $USERS_TB = new USERS_TB();
        $USERS = $USERS_TB->login($request->p_id);
      if ($USERS['check_data'] == 1)
        {
            session()->put('user_data',$USERS);
            return  redirect(route('request_committee.create')) ;
            //return session()->get('user_data');
        }
        else
        {
          return redirect()->back()->withErrors(['status' => 'خطا في اسم المستخدم!']);
        }
    }

    protected function redirectTo(){
        return route('request_committee.create');
       $type = Auth()->user()->user_type_id;
        if($type == 1 || $type == 5)
        {
          //  return route('admin.index');
        }
        else
        {
         //  return route('site.index');
        }
      }
      public function logout()
      {
        session()->forget('user_data');
      }
}
