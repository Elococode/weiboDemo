<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function create()
    {
        return view('users.create');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:users|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        
        // 之后我们可以使用 session()->get('success') 通过键名来取出对应会话中的数据，取出的结果为 欢迎，您将在这里开启一段新的旅程~。
        session()->flash('success', '欢迎，您将在这里开启一段新旅程！');

        return redirect()->route('users.show', [$user]);
    }
}
