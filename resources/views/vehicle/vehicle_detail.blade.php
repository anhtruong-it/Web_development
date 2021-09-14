@extends('layouts.master')

@section('title')
  Vehicle Details
@endsection

@section('content')
<main>
  
  <div class="d-md-flex flex-md-equal w-100 my-md-3 ps-md-3">
    <div class="bg-dark me-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center text-white overflow-hidden">
      <div class="my-3 py-3">
        <h2 class="display-5">Vehicle Information</h2>
        <p class="lead">REGO: {{$vehicle->rego}}</p>
        <p class="lead">MODEL: {{$vehicle->model}}</p>
        <p class="lead">YEAR: {{$vehicle->years}}</p>
        <p class="lead">ODOMETER: {{$vehicle->odometer}}</p>
        <p>------------------------------------------------</p>
        <p class="lead">This vehicle have not booked yet</p>
      </div>
      <div class="bg-light shadow-sm mx-auto" style="width: 80%; height: 300px; border-radius: 21px 21px 0 0;">
      <img src="{{URL::asset('/images/SEDAN.jpg')}}"  height="300" width="400">
      <img src="{{URL::asset('/images/SUV3.jpg')}}"  height="300" width="300">
      <img src="{{URL::asset('/images/SUV2.jpg')}}"  height="300" width="500"></div>
    </div>
</main>   
@endsection
