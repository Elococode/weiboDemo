<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Composer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;


class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => [
                'create',
                'store',
                'confirmEmail',
            ]
        ]);

        $this->middleware('guest', [
            'only' => [
                'create',
            ]
        ]);

        // 限流 一个小时内只能提交 10 次请求；
        $this->middleware('throttle:10,60', [
            'only' => ['store']
        ]);
    }

    public function create()
    {
        return view('users.create');
    }

    public function show(User $user)
    {
        $this->authorize('view', $user);
        $statuses = $user->feed()->paginate(30);
        return view('users.show', compact('user', 'statuses'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6',
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        $this->sendComfirmatonEmailTo($user);

        // 之后我们可以使用 session()->get('success') 通过键名来取出对应会话中的数据，取出的结果为 欢迎，您将在这里开启一段新的旅程~。
        session()->flash('success', '验证邮件已发送到你的注册邮箱上，请注意查收。');

        return redirect()->route('home');
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    public function update(User $user, Request $request)
    {
        $this->authorize('update', $user);
        $this->validate($request, [
            'name' => 'required|max:50',
            'password' => 'nullable|confirmed|min:6',
        ]);

        $data = [];
        $data['name'] = $request->name;
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);

        session()->flash('success', '您的信息已修改成功！');
        return redirect()->route('users.show', $user);
    }

    public function index(User $user)
    {
        $this->authorize('index', $user);
        $users = User::paginate(6);
        return view('users.index', compact('users'));
    }

    public function destroy(User $user)
    {
        $this->authorize('destroy', $user);
        $user->delete();
        session()->flash('success', '您已成功删除用户！');
        return back();
    }

    protected function sendComfirmatonEmailTo($user)
    {
        $view = 'emails.confirm';
        $data = compact('user');
        $from = 'summer@example.com';
        $name = 'Summer';
        $to = $user->email;
        $subject = "感谢注册 Weibo 应用！请确认您的邮箱。";

        Mail::send($view, $data, function ($message) use ($from, $name, $to, $subject) {
            $message->from($from, $name)->to($to)->subject($subject);
        });
    }

    public function confirmEmail($token)
    {

        if (User::where('activation_token', $token)->exists()) {
            $user = User::where('activation_token', $token)->first();
            $user->activated = true;
            $user->activation_token = null;
            $user->save();

            Auth::login($user);
            session()->flash('success', '恭喜您，激活成功！');
            return redirect()->route('users.show', $user);
        } else {
            return redirect()->route('home');
        }
    }
}
