<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;

class SessionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }

    public function create()
    {
        return view ('sessions.create');
    }

    public function store(Request $request)
    {
        $credentials = $this->validate($request,[
                'email' => 'required|email|max:255',
                'password' => 'required',
            ]);

        if (Auth::attempt($credentials,$request->has('remember'))){
            if(Auth::user()->activated) {
            // 登陆成功后的相关操作
                session()->flash('success','欢迎回来！');
                $fallback = route('users.show', Auth::user());
                return redirect()->intended($fallback);
            } else {
                Auth::logout();
                session()->flash('warning','账号未激活，请检查邮箱中的注册邮件进行激活');
                return redirect('/');
            }
        }else{
            //登陆失败后的相关操作
            session()->flash('danger','很抱歉，您的邮箱密码不匹配');
            return redirect()->back()->withInput();
        }
    }

    public function destory()
    {
        Auth::logout();
        session()->flash('success','您已成功退出');
        return redirect('login');
    }
}
