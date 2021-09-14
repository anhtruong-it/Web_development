@extends('layouts.master')

@section('title')
  Return vehicle
@endsection

@section('content')
<main>
<div class="bg-dark me-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center text-white overflow-hidden">
<h2 class="display-5">Return vehicle</h2>
    <!--Display vehicle detail and input odometer to update after retruning-->
    <form method="post" action="{{url("return_vehicle_action")}}">
        {{csrf_field()}}
        <input type="hidden" name="ids" value="{{$detail->ids}}">
        <input type="hidden" name="id" value="{{$detail->id}}">
        <p>rego:{{$detail->rego}}</p>
        <p>model:{{$detail->model}}</p>
        <p>years:{{$detail->years}}</p>
        <label>odometer:</label>
        <input type="text" name="odometer" value="{{$detail->odometer}}">  
        <input type="submit" value="Return">    
    </form>
</div>
</main>   
@endsection
