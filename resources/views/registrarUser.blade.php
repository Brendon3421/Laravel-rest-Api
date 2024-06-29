<!-- resources/views/register.blade.php -->
@extends('layout')
@section('title', 'Register')
@section('content')
    <div class="mt-5">
        @if ($errors->any())
            <div class="col-12">
                @foreach ($errors->all() as $erro)
                    <div class="alert alert-danger">{{ $erro }}</div>
                @endforeach
            </div>
        @endif

        @if (session()->has('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if (session()->has('sucess'))
            <div class="alert alert-success">{{ session('sucess') }}</div>
        @endif

    </div>
    <div class="container">
        <form class="ms-auto me-auto mt-auto" method="POST" action="{{ route('register.post') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" class="form-control" name="name" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email address</label>
                <input type="email" class="form-control" name="email" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection

<style>
    form {
        width: 500px;
    }
</style>
