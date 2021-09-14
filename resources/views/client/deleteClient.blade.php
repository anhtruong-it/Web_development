@extends('layouts.master')

@section('title')
  Delete Client
@endsection

@section('content')
<main>
<div class="bg-dark me-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center text-white overflow-hidden">
<h2 class="display-5">Do you want to delete this client?</h2>
    <!--Post client detail to delete-->
    <form method="post" action="{{url("delete_client_action")}}">
        {{csrf_field()}}
        <input type="hidden" name="id" value="{{$client->id}}">
        <input type="hidden" name="license" value="{{$client->license}}">
        <p>Licnese number: {{$client->license}}</p>
        <p>Name: {{$client->name}}</p>
        <p>Age: {{$client->age}}</p>
        <p>License type: {{$client->licensetype}}</p>
        <input type="submit" value="Delete">
    </form>
</div>
</main>   
@endsection
