@extends('layouts.master')

@section('title')
  Update Client
@endsection

@section('content')
<main>
<div class="bg-dark me-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center text-white overflow-hidden">
<h2 class="display-5">Client Updating</h2>
    <!--Post data will be update, the form will display old data first-->
    <form method="post" action="{{url("update_client_action")}}">
        {{csrf_field()}}
        <input type="hidden" name="id" value="{{$client->id}}">
        <p>
        <p>
        <label>License:</label>
        <input type="text" name="license" value="{{$client->license}}">
        </p>
        <label>Name:</label>
        <input type="text" name="name" value="{{$client->name}}">
        </p>
        <p>
        <label>Age:</label>
        <input type="text" name="age" value="{{$client->age}}">  
        </p>
        <p>
        
        <label>License Type:</label>
        <p>{{$client->licensetype}}</p>
            <select name="licensetype" >
                <option> P1 (provisional, probationary or restricted licence) </option>
                <option> P2 (provisional, probationary or restricted licence) </option>
                <option> O (Open) </option>
                <option> L (Leaner) </option>
            </select> <br><br>

        </p>   
        <input type="submit" value="Update Client">    
    </form>
</div>
</main>   
@endsection
