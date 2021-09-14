<?php
  $years = 2021;
?>
@extends('layouts.master')

@section('title')
  Make abooking
@endsection

@section('content')

<main>
  <div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center bg-light">
    <div class="col-md-5 p-lg-5 mx-auto my-5">
      <h1 class="display-4 fw-normal">Book your vehicle</h1>
    </div>
    <div class="product-device shadow-sm d-none d-md-block">
    <img src="{{URL::asset('/images/SEDAN.jpg')}}"  height="400" width="300">
    </div>
    <div class="product-device product-device-2 shadow-sm d-none d-md-block">
    <img src="{{URL::asset('/images/SUV3.jpg')}}"  height="500" width="300">
    </div>
  </div>
  <!--Dsiplay all clients and Vehicles to make a booking-->
  <form method="post" action="{{url("booking_action")}}">
        {{csrf_field()}}
    <div class="container">
      <div class="row"  >
        <div class="col-md-6">
          <h1>Clients</h1>
        @foreach($clients as $client)
          <div class="choices">
          <input type="radio" name="id" value="{{$client->id}}">
          <p class="lead">LICENSE NUMBER: {{$client->license}}</p>
          <p class="lead">NAME: {{$client->name}}</p>
          <p class="lead">AGE: {{$client->age}}</p>
          <p class="lead">LICENSE TYPE: {{$client->licensetype}}</p>
          <p>---------------------------------------------------</P>
          <br></div>
        @endforeach
      </div>

        <div class="col-md-6">
        <h1>Vehicles</h1>
        @foreach($vehicles as $vehicle)
        <div class="choices">
        <input type="radio" name="ids" value="{{$vehicle->ids}}">
          <h1 class="lead">REGO: {{$vehicle->rego}}</h1>
          <p class="lead">Year: {{$vehicle->years}}</p>
          <p class="lead">Model: {{$vehicle->model}}</p>
          <p class="lead">Odometer: {{$vehicle->odometer}}</p>
          <p>---------------------------------------------------</P>
          </div>
        @endforeach
        </div>
    </div>
      <p> Date and time book:</p>
      <input type="datetime-local" name="datetimeH">

      <p> Date and time return:</p>
     
      <input type="datetime-local" name="datetimeR">

      <input type="submit" name="submit" value="add">
  </from>
</main>   
@endsection
