<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// navigate to home page with a list of vehicles
Route::get('/', function(){
    $sql = "select * from vehicle";
    $vehicles = DB::select($sql);
    return view('home')->with('vehicles', $vehicles);
});

Route::get('documentation', function(){
    return view('documentation');
});

// navigate to client detail page with a list of clients
Route::get('client_detail', function(){
    $sql = "select * from client";
    $clients = DB::select($sql);
    //dd($clients);
    return view('client.client_detail')->with('clients', $clients);
});

// navigate to add client page
Route::get('add_client', function(){
    return view("client.add_client");
});

// adding client
Route::post('add_client_action', function(){
    // get input from Add client page
    $name = request('name');
    $age = request('age');
    $license = request('license');
    $licensetype = request('licensetype');
    $id = add_client($license, $name, $age, $licensetype);
    // return error pages if fail
    // return Clietn detail page if success
    if ($id == 'age'){
        return view("error.invalid_age");
    }
    elseif ($id == 'license'){
        return view("error.invalid_license");
    }
    elseif ($id == 'age and license'){
        return view("error.invalid_age_license");
    }
    elseif ($id == 'license exist'){
        return view("error.license_exist");
    }
    else{
        return redirect(url("client_detail"));
    }
});

// navigate to delete client page
Route::get('delete_client/{id}', function($id){
    // get client who will be deleted
    $client = get_client($id);
    return view("client.deleteClient")->with('client', $client);
});

// deleting client
Route::post('delete_client_action', function(){
    $id = request('id');
    $delete = delete_client($id);
    return redirect(url("client_detail"));
});

// navigate to update client detail page
Route::get('update_client/{id}', function($id){
    // get client who will be updated
    $client = get_client($id);
    return view("client.update_client")->with('client', $client);
});

Route::post('update_client_action', function(){
    $id = request('id');
    $license = request('license');
    $name = request('name');
    $age = request('age');
    $licensetype = request('licensetype');
    $id = update_client($id, $license, $name, $age, $licensetype);
    //dd($id);
    if ($id == 'age'){
        return view("error.invalid_age");
    }
    elseif ($id == 'license'){
        return view("error.invalid_license");
    }
    elseif ($id == 'age and license'){
        return view("error.invalid_age_license");
    }
    else{
        return redirect(url("client_detail"));
    }
});

// navigate to booking detail page by specific vehicle
Route::get('booking_detail/{ids}', function($ids){
    $vehicle_client = booking_detail($ids);

    // return booking detail page if vehicle has been book
    // return vehicle detail page if vehicle has not been book
    if ($vehicle_client){
        $seconds = times($ids);
        $duration = seconds_to_time($seconds);
        $booking_infor = booking_and_time($vehicle_client, $duration);
        return view('booking.booking_detail')->with('booking_infor', $booking_infor);
    }
    else{
        $vehicle = get_vehicle($ids);
        return view('vehicle.vehicle_detail')->with('vehicle', $vehicle);
    }
    
});

// navigate to make booking
Route::get('make_booking', function(){
    // get all client and vehicle
    $sql1 = "select * from vehicle";
    $vehicles = DB::select($sql1);
    $sql2 = "select * from client";
    $clients = DB::select($sql2);
    return view('booking.make_booking')->with('vehicles', $vehicles)->with('clients', $clients);
});

// making booking
Route::post('booking_action', function(){
    // get data from input booking page
    $vehicleId = request('ids');
    $clientId = request('id');
    $datetimeH = request('datetimeH');
    $datetimeR = request('datetimeR');

    $id = add_booking($vehicleId, $clientId, $datetimeH, $datetimeR);
    // return error page if booking fail
    if ($id=='error'){
        return view("error.invalid_date");
    }
    else{
        // time of new booking is the last element in times function
        // end($time) will get the last one
        $time = times($vehicleId);
        $sql = "insert into duration(vehicleId, clientId, timess) values (?, ?, ?)";
        DB::insert($sql, array($vehicleId, $clientId, end($time)));
        $id = DB::getPdo()->lastinsertId();
        return view('booking.booking_notice');
    }

});

// navigate to return vehicle page
Route::post('return_vehicle', function(){
    // get vehicle and client that will be deleted
    $vehicleId = request('vehicleId');
    $clientId = request('clientId');
    $detail = return_vehicle($vehicleId, $clientId);
    return view('vehicle.return_vehicle')->with('detail', $detail[0]);


});

// returning vehicle
Route::post('return_vehicle_action', function(){
    $ids = request('ids');
    $odometer = request('odometer');
    $id = request('id');

    $new_o = update_odometer($ids, $odometer);
    // check odometer updated fail or success
    if ($new_o == "invalid"){
        die('odometer');
    }
    else{
        // if success, delete detail in booking detail page
        $del = delete_booking($ids, $id);
        $sql = "select * from vehicle";
        $vehicles = DB::select($sql);
        return view('vehicle.return_vehicle_notice');
    }
   
});

// navigate to popular vehicle by how many time were booked
Route::get('most_booking_vehicle', function(){
    $populars = most_booking_vehicle();
    return view('vehicle.most_vehicle')->with('populars', $populars);
});

// navigate to popular vehicle by time
Route::get('most_time_vehicle', function(){
    $populars = most_time_vehicle();
    return view('vehicle.most_time_vehicle')->with('populars', $populars);
});

// function to add new client
function add_client($license, $name, $age, $licensetype){
    //retrieve all license of client existed to compare with new input license
    $license_data = get_license();
    $count_license = 0;
    foreach($license_data as $licenses){
        if ($license == $licenses->license){
            $count_license++;
        }
    }
    // license is not same as the old one, keep checking age input(17<age<99)
    if ($count_license == 0){
        $count = 0;
        for ($i = 0; $i < strlen($license); $i++){
            if ($license[$i] == (integer)$license[$i]){
                $count++;
            }
        }
        // some error notice
        if (((int)$age >= 99 or (int)$age <= 17) && $count == 9){
            $id = 'age';
        }
        elseif (((int)$age >= 99 or (int)$age <= 17) && $count != 9){
            $id = 'age and license';
        }
        elseif (((int)$age < 99 && (int)$age > 17) && $count != 9){
            $id = 'license';
        }
        else{
            // start to add client if conditions accepted
            $sql = "insert into client (license, name, age, licensetype) values (?, ?, ?, ?)";
            DB::insert($sql, array($license, $name, $age, $licensetype));
            $id = DB::getPdo()->lastinsertId();
        }
    }
    else{
        $id = 'license exist';
    }
    return $id;
}

// function to retrieve all licenses from database to compare with new license
function get_license(){
    $sql = "select license from client";
    $licenses = DB::select($sql);
    return $licenses;
}

// function delete client
function delete_client($id){
    $sql = "delete from client where id = ?";
    DB::delete($sql, array($id));
}

// function update client
function update_client($id, $license, $name, $age, $licensetype){
    // checking client detail same as add client
    $count = 0;
    for ($i = 0; $i < strlen($license); $i++){
        if ($license[$i] == (integer)$license[$i]){
            $count++;
        }
    }
    if (((int)$age >= 99 or (int)$age <= 17) && $count == 9){
        $id = 'age';
    }
    elseif (((int)$age >= 99 or (int)$age <= 17) && $count != 9){
        $id = 'age and license';
    }
    elseif (((int)$age < 99 && (int)$age > 17) && $count != 9){
        $id = 'license';
    }
    else{
        $sql = "update client set license = ?, name = ?, age = ?, licensetype = ? where id = ?";
        DB::update($sql, array($license, $name, $age, $licensetype, $id));
        $id = DB::getPdo()->lastinsertId();
    }
    return $id;
}

// function retrieve booking details by specific vehicle
function booking_detail($ids){
    $sql1 = "select client.*, vehicle.*, booking.*
    from vehicle, client, booking
    where client.id = booking.clientId and vehicle.ids = booking.vehicleId and vehicle.ids=?";
    $booking_detail = DB::select($sql1, array($ids));
    return $booking_detail;
}

// function to add new booking
function add_booking($vehicleId, $clientId, $datetimeH, $datetimeR){
    // description will be explained on documentation!!!
    $new_hire = (string)$datetimeH;
    $new_return = (string)$datetimeR;
    $today = date("Y-m-d");

    if (strtotime($new_hire) < strtotime($new_return) && strtotime($new_hire) > strtotime($today)){
        $sql1 = "select booking.datetimeH
                 from vehicle, booking, client
                 where client.id = booking.clientId and vehicle.ids = booking.vehicleId and vehicle.ids=?";
        $timeBook = DB::select($sql1, array($vehicleId));
        
        $sql2 = "select booking.datetimeR
                 from vehicle, booking, client
                 where client.id = booking.clientId and vehicle.ids = booking.vehicleId and vehicle.ids=?";
        $timeReturn = DB::select($sql2, array($vehicleId));

        $i = 0;
        $check_time = 0;
        while ($i <= count($timeBook)-1){
            $old_hire = (string)$timeBook[$i]->datetimeH;
            $old_return = (string)$timeReturn[$i]->datetimeR;
            
            if (strtotime($new_hire) > strtotime($old_return) && strtotime($new_return) > strtotime($old_return)){
                $check_time += 1;
            }
            elseif (strtotime($new_hire) < strtotime($old_hire) && strtotime($new_return) < strtotime($old_hire)){
                $check_time += 1; 
            }
            $i++;
        }
       // dd($check_time==count($timeBook));
        if ($check_time == count($timeBook)){
            $sql = "insert into booking(vehicleId, clientId, datetimeH, datetimeR) values (?, ?, ?, ?)";
            DB::insert($sql, array($vehicleId, $clientId, $datetimeH, $datetimeR));
            $id = DB::getPdo()->lastinsertId();
        }   
        else{
            $id ='error';
        }
    }
    else{
        $id = 'error';
    }
    return $id;
}

// function to calculate toltal time of each booking
function times($ids){
    $sql = "select booking.datetimeH, booking.datetimeR
    from vehicle, client, booking
    where client.id = booking.clientId and vehicle.ids = booking.vehicleId and vehicle.ids=?";
    $booking = DB::select($sql, array($ids));
    $second = array();
    foreach ($booking as $book){
        $second = strtotime($book->datetimeR) - strtotime($book->datetimeH);
        $seconds[] = $second;
    }
    //dd($seconds,$second);
    return $seconds;
}

// function to calculate time in seconds into time in days-hours-minutes-sends
function seconds_to_time($seconds) {
    $duration = array();

    foreach ($seconds as $second){

        $days = $second / 86400;
        $second -= 86400*floor($days);

        $hours = $second / 3600;
        $second -= 3600*floor($hours);

        $minutes = $second / 60;
        $second -= 60*floor($minutes);
    
        // return the final array
        $duration[] = array(
            'days' => (int)$days,
            'hours' =>  (int)$hours,
            'minutes' => (int)$minutes,
            'seconds' => (int)$second,
        );
    }
    return $duration;
}

// function to add time to one booking
function booking_and_time($booking_detail, $duration){
    $i = 0;
    // times order and booking detail order are equivalent
    while ($i <= count($booking_detail)-1){
        $booking_detail[$i]->time = $duration[$i];
        $i++;
    }
    return $booking_detail;
}

// functio to retrieve vehicle and client that will be removed
function return_vehicle($vehicleId, $clientId){
    $sql1 = "select vehicle.*, client.*
    from vehicle, client, booking
    where client.id = booking.clientId and vehicle.ids = booking.vehicleId and booking.vehicleId=? and booking.clientId=?";
    $booking_detail = DB::select($sql1, array($vehicleId, $clientId));
    return $booking_detail;
}

// function to update odometer
function update_odometer($ids, $odometer){
    $sql = "select odometer from vehicle where ids = ?";
    $odometers = DB::select($sql, array($ids));
    $old_odo = $odometers[0]->odometer;

    // onew odometer must be a number and larger than current odometer
    if (is_numeric($old_odo) && $odometer > $old_odo){
        $sql = "update vehicle set odometer = ? where ids = ?";
        DB::update($sql, array($odometer, $ids));
        $id = DB::getPdo()->lastinsertId();
    }
    else{
        $id = "invalid";
    }
    return $id;
}

// function to delete booking in booking detail page
function delete_booking($vehicleId, $clientId){
    $sql = "delete from booking where vehicleId=? and clientId=?";
    DB::delete($sql, array($vehicleId, $clientId));
}

// function to calculate popular vehicle by number of booking
function most_booking_vehicle(){

    $sql = "select vehicleId from duration";
    $vehicleIds = DB::select($sql);

    // get vehicle id from database
    $i=0;
    while($i<=count($vehicleIds)-1){
        $id[]= $vehicleIds[$i]->vehicleId;
        $i++;
    }

    // check id, add id into a array
    $i=0;
    while($i<count($id)){

        // first id will automatic added
        if($i == 0){
            $temp_id[]=$id[$i];
        }
        else{
            // check other id, if they are not same as previou id,
            // add it
            $counts = 0;
            for ($temp_loop = 0; $temp_loop < $i ; $temp_loop++ ){
                if ($id[$i] == $id[$temp_loop]){
                    $counts += 1;
                }
            }
            if ($counts==0){
                $temp_id[]=$id[$i];
            }
        }
        $i++;
    }

    // retrieve rego, calculate number of booking
    $i=0;
    while($i < count($temp_id)){
        $counts=0;
        // retrieve rego by vehicle's id
        $sql = "select rego from vehicle where ids=?";
        $rego = DB::select($sql, array($temp_id[$i]));

        // calculate number of booking for each vehicle
        for ($temp_loop = 0; $temp_loop < count($id); $temp_loop++){
            if ($temp_id[$i] == $id[$temp_loop]){
                $counts += 1;
            }
        }
        $new_array[] = array("number"=>$counts, 
                             "vehicleId"=>$temp_id[$i],
                             "rego"=>$rego[0]->rego);
        $i++;
    }

    // rerange vehicles in order to of the how often they are booked
    arsort($new_array);

    foreach ($new_array as $temp){
        $popular_vehicle[]=$temp;
    }
    return $popular_vehicle;
}

// function to calculate popular vehicle by time
function most_time_vehicle(){

    // retrieve vehicles id and time from database
    $sql = "select vehicleId, timess from duration";
    $vehicleIds = DB::select($sql);

    // add vehicles id to new array that same as most_booking_vehicle function
    $i=0;
    while($i <= count($vehicleIds)-1){
        $id[]= $vehicleIds[$i]->vehicleId;
        $i++;
    }
    $i=0;
    while($i < count($id)){
        if($i==0){
            $temp_id[]=$id[$i];
        }
        else{
            $counts = 0;
            for ($temp_loop=0; $temp_loop<$i ; $temp_loop++ ){
                if ($id[$i]==$id[$temp_loop]){
                    $counts +=1;
                }
            }
            if ($counts==0){
                $temp_id[]=$id[$i];
            }
        }
        $i++;
    }

    // retrieve rego, calculate total time that same as most_booking_vehicle function
    $i=0;
    while($i < count($temp_id)){
        $second=0;
        $sql = "select rego from vehicle where ids=?";
        $rego = DB::select($sql, array($temp_id[$i]));

        for ($temp_loop = 0; $temp_loop < count($id); $temp_loop++){
            if ($temp_id[$i] == $id[$temp_loop]){
                $second += $vehicleIds[$temp_loop]->timess;
            }
        }

        $time_compare = $second;

        // transfer seconds to days-hours-minutes-seconds
        $days = $second / 86400;
        $second -= 86400*floor($days);

        $hours = $second / 3600;
        $second -= 3600*floor($hours);

        $minutes = $second / 60;
        $second -= 60*floor($minutes);

        $duration[] = array(
            'days' => (int)$days,
            'hours' =>  (int)$hours,
            'minutes' => (int)$minutes,
            'seconds' => (int)$second,
        );
        $new_array[] = array("time_compare"=>$time_compare,
                             "total time"=>$duration[0],
                             "vehicleId"=>$temp_id[$i],
                             "rego"=>$rego[0]->rego);
        
        // reset array after add one vehicle
        unset($duration);
        $i++;
    }

    // rerange 
    arsort($new_array);;
    foreach ($new_array as $temp){
        $popular_vehicle[]=$temp;
    }
    return $popular_vehicle;
}

// function to retrieve vehicle by id
function get_vehicle($ids){
    $sql = "select * from vehicle where ids=?";
    $vehicles = DB::select($sql, array($ids));
    $vehicle = $vehicles[0];
    return $vehicle;
}

// function to retrieve client by id
function get_client($id){
    $sql = "select * from client where id=?";
    $clients = DB::select($sql, array($id));
    //dd($clients);
    $client = $clients[0];
    return $client;
}




