@extends('layouts.master')

@section('title')
  Client Details
@endsection

@section('content')
<main>
<div class="bg-dark me-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center text-white overflow-hidden">
<h2 class="display-5">Client Information</h2>
  <!--Display client detail one by one-->
  @foreach($clients as $client)
        <p class="lead">LICENSE NUMBER: {{$client->license}}</p>
        <p class="lead">NAME: {{$client->name}}</p>
        <p class="lead">AGE: {{$client->age}}</p>
        <p class="lead">LICENSE TYPE: {{$client->licensetype}}</p>
        
        <!--2 links to Delete and Update client one by one-->
        <p>
        <a href="{{url("delete_client/$client->id")}}">Delete</a>
        <a href="{{url("update_client/$client->id")}}">Update</a>
        </p>
        <p>---------------------------------------------------</P>
        <br>

@endforeach

<!--A link to Add client on the bottom of page-->
<a href="{{url("add_client")}}">Add client</a>
</div>
</main>   
@endsection
