@extends('layouts.master')

@section('title')
  popular vehicles
@endsection

@section('content')

<main>

  <!--Display all vehicles from largest to smallest number of booking-->
  @foreach($populars as $popular )
  <div class="d-md-flex flex-md-equal w-100 my-md-3 ps-md-3">
    <div class="bg-dark me-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center text-white overflow-hidden">
      <div class="my-3 py-3">
        <h2 class="display-5">Vehicle:</h2>
        <h2 class="display-4">{{$popular['rego']}}</h2>
        <h2 class="display-5">Number of booking:</h2>
        <h2 class="display-4 ">{{$popular['number']}}</h2>
      </div>
    </div>
  </div>
  @endforeach
</main>   
@endsection
