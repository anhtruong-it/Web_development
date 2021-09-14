@extends('layouts.master')

@section('title')
  Invalid input
@endsection

@section('content')
<main>
<!--Notice booking is overlap or invalid date-->
<div class="bg-dark me-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center text-white overflow-hidden">
<h1 class="display-5">Inlavid date</h1>
<a href="{{url("/")}}">Return to home</a>
</div>
</main>   
@endsection
