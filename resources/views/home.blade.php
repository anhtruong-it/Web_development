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
  <!--Display all vehicles with their REGO-->
  @foreach($vehicles as $vehicle)
  <div class="d-md-flex flex-md-equal w-100 my-md-3 ps-md-3">
    <div class="     text-center ">

        <!--A link to vehicle details by Vehicle's REGO-->
        <h2 class="display-5"><a href="{{url("booking_detail/$vehicle->ids")}}">{{$vehicle->rego}}</a></h2>

      
    </div>
  </div>
  @endforeach
</main>   
@endsection
