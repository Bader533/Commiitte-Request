<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\USERS_TB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

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
      $Validator =  Validator::make($request->all(),[
             'p_id'=>'required|numeric|digits:9'
        ]);
        if ($Validator->fails()) {
            // return redirect()->back()->withErrors(['status' => 'خطا في  !']);

            return redirect()->back()->withErrors(['status' => 'خطا في اسم المستخدم!']);
        }
        $USERS_TB = new USERS_TB();
        $USERS = $USERS_TB->login($request->p_id);
      if ($USERS['check_data'] == 1)
        {
            session()->put('user_data',$USERS);
            return redirect(route('home'));
        }
        else
        {
          return redirect()->back()->withErrors(['status' => 'خطا في اسم المستخدم!']);
        }
    }

      public function logout()
      {

      //  return session()->get('user_data');
      $USERS_TB = new USERS_TB();
return     $P_USERS_ID =$USERS_TB->auth()->ID;
        session()->forget('user_data');

        return redirect(route('login'));

      }
}
