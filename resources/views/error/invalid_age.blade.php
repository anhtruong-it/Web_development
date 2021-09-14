@extends('layouts.master')

@section('title')
  Invalid input
@endsection

@section('content')
<main>
<div class="bg-dark me-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center text-white overflow-hidden">
<h2 class="display-5">Age must be greater than 17 and less than 99!!!</h2>
  
<a href="{{url("/")}}">Return to home</a>
</div>
</main>   
@endsection
