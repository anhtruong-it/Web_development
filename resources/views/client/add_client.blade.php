@extends('layouts.master')

@section('title')
  Add Client
@endsection

@section('content')
<main>
<div class="bg-dark me-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center text-white overflow-hidden">
<h2 class="display-5">Client Adding</h2>
    <!--post all input in this page to add new client-->
    <form method="post" action="{{url("add_client_action")}}">
        {{csrf_field()}}
        <p class="lead">
        <label>License Number:</label>
        <input type="text", name="license">
        </p>
        <p class="lead">
        <label>Name:</label>
        <input type="text", name="name">
        </p>
        <p class="lead">
        <label>Age:</label>
        <input type="text", name="age">
        </p>
        <p class="lead">
        <label>License Type:</label>
            <select name="licensetype">
                <option> P1 (provisional, probationary or restricted licence) </option>
                <option> P2 (provisional, probationary or restricted licence) </option>
                <option> O (Open) </option>
                <option> L (Leaner) </option>
            </select> <br><br>
        </p>
        <input type="submit" value="Add">
    </form>
</div>
</main>   
@endsection
