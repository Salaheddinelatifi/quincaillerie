@extends('layouts.app')

@section('content')
<div class="container mt-5" style="max-width:500px;">
    <h2 class="mb-4 text-center">تسجيل الدخول</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">البريد الإلكتروني</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">كلمة السر</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">تسجيل الدخول</button>
    </form>
</div>
@endsection
