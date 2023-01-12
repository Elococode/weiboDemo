<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class PasswordController extends Controller
{
    public function showLinkRequestFrom()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        // 验证邮箱
        $request->validate([
            'email' => 'required|email',
        ]);
        $email = $request->email;

        // 获取邮箱用户
        $user = User::where('email', $email)->first();

        // 如果不存在
        if (is_null($user)) {
            session()->flash('danger', '邮箱未注册');
            return redirect()->back()->withInput();
        }

        // 生成Token 在视图 emails.reset_link 里拼接链接
        $token = hash_hmac('sha256', Str::random(40), config('app.key'));

        // 入库，使用 updateOrInsert 来保持 Email 唯一
        DB::table('password_resets')->updateOrinsert([
            'email'=>$email,
        ],[
            'email'=>$email,
            'token'=>Hash::make($token),
            'created_at' => new Carbon,
        ]);

        // 将 Token 链接发送给用户

        Mail::send('emails.reset_link',compact('token'),function($message) use ($email){
            $message->to($email)->subject("忘记密码");
        });

        session()->flash('success','重置邮件发送成功，请及时查收！');
        return redirect()->back();
    }

    public function showRequestForm($token)
    {
        # code...
    }
}
