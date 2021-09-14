
@extends('layouts.master')

@section('title')
  Home Page
@endsection

@section('content')

<main>
<div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center bg-light">
    <div class="col-md-6 p-lg-5 mx-auto my-5">
      <h1 class="display-4 fw-normal">Welcome to Vehicle Hiring</h1>
    </div>
    <div class="product-device shadow-sm d-none d-md-block">
    <img src="{{URL::asset('/images/SEDAN.jpg')}}"  height="400" width="300">
    </div>
    <div class="product-device product-device-2 shadow-sm d-none d-md-block">
    <img src="{{URL::asset('/images/SUV3.jpg')}}"  height="500" width="300">
    </div>
  </div>
  <!--This form will handle return vehicle page when user want to do return-->
  <form method="post" action="{{url("return_vehicle")}}">
  {{csrf_field()}}

  <!--Display All booking detail for vehicle chosen-->
  @foreach($booking_infor as $bookings)
  <div class="d-md-flex flex-md-equal w-100 my-md-3 ps-md-3">
    <div class="bg-dark me-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center text-white overflow-hidden">
      <div class="my-3 py-3">
        <h1>Client</h1>
        <div class="choices">
        <input type="radio" name="clientId" value="{{$bookings->clientId}}">
        <h2 class="display-5">Name: {{$bookings->name}}</h2>
        <h2 class="display-5">License number: {{$bookings->license}}</h2>
        <h2 class="display-5">Type of license: {{$bookings->licensetype}}</h2>
        <h2 class="display-5">Age: {{$bookings->age}}</h2>
        <h1>Time</h1>
        <h2 class="display-5">Date hiring: {{$bookings->datetimeH}}</h2>
        <h2 class="display-5">Date return: {{$bookings->datetimeR}}</h2>
        <h2 class="display-5">Time estimated: {{$bookings->time['days']}} days, {{$bookings->time['hours']}} hours:{{$bookings->time['minutes']}}minutes:{{$bookings->time['seconds']}}seconds</h2>
  @endforeach
        <p>------------------------------------------------------------------</p>
  <!--Vehicle detail will only display 1 time-->
  @for($i=0;$i<=0;$i++)
        <h1>Vehicle</h1>
        <div class="choices">
        <input type="radio" name="vehicleId" value="{{$bookings->vehicleId}}">
        <h2 class="display-5">Rego: {{$booking_infor[$i]->rego}}</h2>
        <h2 class="display-5">Model: {{$booking_infor[$i]->model}}</h2>
        <h2 class="display-5">Year: {{$booking_infor[$i]->years}}</h2>
        <h2 class="display-5">Odometer: {{$booking_infor[$i]->odometer}}</h2>
        <p>------------------------------------------------------------------</p>
  @endfor
        <input type="submit" value="Return vehicle">
      </div>
    </div>
  </div>

  </form>
</main>   
@endsection
