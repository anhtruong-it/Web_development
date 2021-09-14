@extends('layouts.master')

@section('title')
  Booking details
@endsection

@section('content')
<main>

<!--Notice booking is successfull-->
<div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center bg-light">
    <div class="col-md-5 p-lg-5 mx-auto my-5">
      <h1 class="display-4 fw-normal">Booking successful</h1>
    </div>
    <div class="product-device shadow-sm d-none d-md-block">
    <img src="{{URL::asset('/images/LIKE.png')}}"  height="400" width="300">
    </div>
    <div class="product-device product-device-2 shadow-sm d-none d-md-block">
    <img src="{{URL::asset('/images/LIKE.png')}}"  height="400" width="300">
    </div>
  </div>
</main>   
@endsection
