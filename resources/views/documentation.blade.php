@extends('layouts.master')

@section('title')
  Documentation
@endsection

@section('content')


<main>
  <div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center bg-light">
    <div class="col-md-5 p-lg-5 mx-auto my-5">
      <h1 class="display-4 fw-normal">DOCUMENTATION!!!</h1>
    </div>
    <div class="product-device shadow-sm d-none d-md-block"></div>
    <div class="product-device product-device-2 shadow-sm d-none d-md-block"></div>
    <img src="{{URL::asset('/images/documentation.PNG')}}"  height="1000" width="700">
  </div>

</main>   
@endsection
