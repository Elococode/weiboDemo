@extends('layouts.default')

@section('title', '重置密码')

@section('content')
    <div class="offset-md-1 col-md-10">
        <div class="card">
            <div class="card-header">
                <h5>更新密码</h5>
            </div>
            <div class="card-body">
                @include('shared._errors')

                <form action="{{ route('password.update') }}" method="post">
                    {{ csrf_field() }}

                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="mb-3 row">
                        <label for="email" class="col-md-4 col-form-label text-md-right">
                            Email 地址：
                        </label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="email" name="email"
                                value="{{ old('email') }}" required autofocus>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="password" class="col-md-4 col-form-label text-md-right">
                            密码：
                        </label>
                        <div class="col-md-6">
                            <input type="password" name="password" class="form-control">
                        </div>
                    </div>


                    <div class="mb-3 row">
                        <label for="password-confirm" class="col-md-4 col-form-label text-md-right">
                            确认密码：
                        </label>
                        <div class="col-md-6">
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3 row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                重置密码
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
