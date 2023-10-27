@extends('admin.layouts.app')
@section('title', "Internal Server Error ")
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 text-center">
            <h1 class="error-title">500 Internal server error</h1>
            <h2 class="error-sub-title">Something went wrong</h2>
            <p class="error-message">The page you are looking for might have been removed had its name changed or is temporarily unavailable.</p>
            <a href="{{ route('dashboard') }}" class="btn btn-primary mt-3">Go to Home Page</a>
        </div>
    </div>
</div>
@endsection