<?php
{{-- filepath: c:\xampp\htdocs\akmal-ukk\resources\views\auth\verify-email.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Verify Your Email Address</h1>
    <p>Before proceeding, please check your email for a verification link.</p>
    <p>If you did not receive the email, <a href="{{ route('verification.send') }}">click here to request another</a>.</p>
</div>
@endsection
