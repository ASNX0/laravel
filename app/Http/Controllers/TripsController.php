<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Models\Trip;
use App\Models\Feature;
use App\Models\Bus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class TripsController extends Controller
{


    // public function __construct() {
    //     $this->middleware('auth:api', ['except' => ['passengers','history']]);
    
    // } 

     public function bustrip(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'bus_id' => 'required|integer',
                'name' => 'required|string',
                'email' => 'required|email',
                'trip_name'=>'required|string',
                
            ]
        );


          if ($validator->fails()) {
            return response()->json([$validator->errors(),'msg'=>'wrong info'], 400);
        }
      

          $trips = Todo::create(
        
                $validator->validated(),
            
        );
         
         
  
   
    return redirect('/noti');

     
          // return response()->json(['msg' => 'trip registered'], 201);
    }
    public function history(Request $request)
    {

     $hist=Todo::where('email',$request->email)->get();
     // return $hist;
    return Todo::all();
    

    }
       public function passengers(Request $request)
    {
      
     $hist=Todo::where('bus_id',$request->bus_id)->get();
    

   
    

     return $hist;
    

    }
     protected function guard()
    {
        return Auth::guard();

    }
   
     
  
  public function schedTrip(){
  $now=\Carbon\Carbon::now();
 $thisMonth=$now->month($now->month)->daysInMonth;

  $currentDay=$now->day;
  $currentMonth=$now->month;
  $currentDay1=15;
  if($currentDay==1 && $currentMonth==1){
  $this->scheduleTrips(1,$thisMonth,$now->month);
  }else if($currentDay1==1 && $currentMonth!=1){
  $this->scheduleTrips(15,$thisMonth,$now->month);
  }else if($currentDay1==15 && $currentMonth!=1){
  $this->scheduleTrips(1,14,$now->month+1);
   }
  }

  public function scheduleTrips($startDay,$endDay,$month){
  $now=\Carbon\Carbon::now();
  $list=array();
  $empty_bus=array();
  $loc=array();
  $ids=[1,2,3];
  $thisMonth=$now->month($now->month)->daysInMonth;


 $features=Feature::select('id')->with([
        'buses' => function ($q)  {
          $q->where('company_ID',1);
        }
    ])->get();
  foreach ($features as $feature) {
 $buses= $feature->buses;
 foreach($buses as $bus){
    $empty_bus[]= $bus->bus_number;
    $loc=$bus->location_id;
 }
}
   for($w=$startDay; $w<=$endDay; $w++){
   $time=mktime(12, 0, 0, $month, $w, $now->year);                
    if (date('m', $time)==$month)  {     
    $list[$w]=date('Y-m-d-D', $time);
}
 for($t=06; $t<=18; $t++){
     $time_in_24_hour_format[] = date("H:i", strtotime("$t:00"));
     }
  
     for($i=0; $i<count($time_in_24_hour_format); $i++){
    for($id=0; $id<count($empty_bus); $id++){
        for($com_id=0; $com_id<count($ids); $com_id++){
     $flight = Trip::create([
       'location_id'=> $loc,
       'bus_id'=>$empty_bus[$id],   
       'date' => $list[$w],
       'time'=> $time_in_24_hour_format[$i],
       'company_ID'=>$ids[$com_id],
   
       ]);
 }
      }
     }
}

  }

public function reservBus(Request $request){ 
      $reserv_id=Reservation::where('bus_id',$request->bus_id)
                           ->where('trip_id',$request->trip_id)->count();
    if($reserv_id=25){
        Bus::where('id',$request->bus_id)->update(['bus_status'=> 0]);
     Trip::where('bus_id', $request->bus_id)->where('id',$request->trip_id)->delete();
    }
   
    $user=  User::where('email', $request->email)->first();
    $Reservation = Reservations::create([
       'user_id'=> $user->id,
     'trip_id'=>$request->trip_id,   
    'date' => $request->date,
       ]);

    

}
public function getTrips(Request $request){

 return $getTrips=Trip::where('date', $request->date)->with('locations')->whereHas('locations', function ($q) use ($request)  {
      $q->where('depart_location',$request->depart)->where('arrival_location',$request->arrival);  
        })->with('buses')->whereHas('buses', function ($q)  {
      $q->where('bus_status',1);  
        })->get();
}




























   public function getCompanyBuses(){
    //get all  buses columns for company id =1
$feature=Feature::find(1);
// return $feature->buses;

//get one buses column for company id=1 
$feature=Feature::with(relations:'buses')->find(1);
// return $feature->company_name;
 $buses= $feature->buses;
// foreach($buses as $bus){
//     echo $bus->bus_number; 
// }
//get one feature column for bus id=4
$bus=Bus::find(4);
return $bus->feature->company_name;

   }
   public function getEmptyBuses(){
  
$empty_bus=array();
 $features=Feature::select('id')->with([
        'buses' => function ($q)  {
            $q->where('bus_status',1);

        }
    ])->get();


  // $features=Feature::with(relations:'buses')->whereHas('buses',function($q){
  //         return $q->where('bus_status',1);
  //   })->get();
  foreach ($features as $feature) {
 $buses= $feature->buses;
 foreach($buses as $bus){
    $empty_bus[]= $bus->bus_number;
 }
}
  return $empty_bus;
   }
    
public function create(){
    $trip=tirp::with(relations:'buses')->where('company_ID','1');
    $buses=$trip->buses;
    foreach ($Buses as $bus) {
        

        // code...
    }
    //$emptyBus=bus::get();


 

}
    
  

}
