@extends('layouts.app')

@section('content')

<div class="card">
    <div class="card-header">Change Password</div>
    <div class="card-body">
        <form action="{{ route('users.updatePassword', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class=" row col-sm-12"> 
            <div class="row col-sm-10">    
             <p><strong>ID: </strong><u class="text-primary">{{ $user->username}}</u> <strong>Name: </strong> <u>{{ $user->first_name}}  {{ $user->middle_name}}  {{ $user->last_name}}  </u>
            </div>   
            </div>
            <div class="form-group mb-3">
                <label for="password">New Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>

            <div class="form-group mb-3">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
            </div>

            <div class="form-group mb-3">
                <button type="submit" class="btn btn-success btn-sm">Update Password</button>
            </div>
        </form>
    </div>
</div>

@endsection
