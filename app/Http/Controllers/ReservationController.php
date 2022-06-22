<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Bus;
use App\Models\Reservation;
use App\Models\Trip;
use App\Models\Feature;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.   
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $ids=array();
        $tripReservations=array(); 
        $times=array();
        $buses=array();
        $bus_numbers=array(); 
        $company_IDs=array();
        $company_names=array();
        $features=array();
     
          $validator = Validator::make(
            $request->all(),
            [
                'date'  => 'required',
                'depart' => 'required',
                'arrival'   => 'required',
            ]
        );
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        
        $count=array();
  $trips=Trip::where('date',$request->date)->with('buses')->whereHas('buses',function($q){
        $q->where('bus_status', 1);
        })->with('locations')->whereHas('locations',function($q) use ($request){
        $q->where('depart_location',$request->depart)->where('arrival_location',$request->arrival);      })->with('feature')->get();

        // ->with('reservations')->whereHas('reservations',function($q) use ($request){
        // $q->where('date',$request->date);   
        // })   
        
       
        //getting trip information

        foreach ($trips as $trip) {
        $ids[]= $trip->id;
        $bus_numbers[]=$trip->buses->bus_number;
        $company_IDs[]=$trip->buses->company_ID;
        $times[]=$trip->time;

      $count[]=$trip->reservations->count();
        $features[]=Feature::where('id',$trip->buses->company_ID)->get();
       
     
        }

          // $features[]=Feature::whereIn('id',$company_IDs)->get();
      
    
      // $features = trim($features,'[]');
      
      //   return $features;
           
        //getting bus information
        // foreach($buses as $bus){
        // $bus_numbers[]= $bus->bus_number;
        // $company_IDs[]=$bus->company_ID;
        // }
         //getting company information
        // foreach($company_IDs as $com_ID){
       
       
        // }


    
       
     
        $tripReservations=Reservation::whereIn('trip_id',$ids)->count();
        
 return $response= response()->json(
            [[
          
                'trips'=>$trips,


            ]]
        );




    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        


$validator = Validator::make(
            $request->all(),
            [
                'bus_id'  => 'required',
                'trip_id' => 'required',
            
            ]
        );
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        
$reserv= Reservation::where('trip_id',$request->trip_id)->with('trip')->whereHas('trip',function($q)use($request){
    $q->where('bus_id',$request->bus_id);
})->get();
return $reserv;






    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
         $validator = Validator::make(
            $request->all(),
            [
                'bus_id'  => 'required',
                'trip_id' => 'required',
                'email'   => 'required|string|email',
                'seat_number'=>'required|array',
            ]
        );
          
         $seat_numbers=array();
       $seat_numbers=$request->seat_number;
      
       // $reservation            = new Reservation();
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
    // if($reservation->trip_id==$request->trip_id&&$reservation->seat_number==$request->seat_number)
    // {
    //      return response()->json('msg'=>'Reserved Seat', 405);
    // }

      $userInfo=User::where('email',$request->email)->first();
        $user_id=$userInfo->id;
   $tripReservations=Reservation::where('trip_id',$request->trip_id)->with(['trips'=>function($q) use ($request){
        $q->where('bus_id',$request->bus_id);
    }])->count();
        // if($tripReservations==41){
        // Bus::where('id',$request->bus_id)->update(['bus_status'=> 0]);
        // }
  $myTrip=Trip::where('id',$request->trip_id)->with([
        'buses' => function ($q)  {
          $q->where('bus_status',1);
        }])->first();
  for ($i=0; $i<count($seat_numbers); $i++) { 
    $reserv = Reservation::create([
        'user_id'=>$user_id,
        'seat_number'=>$seat_numbers[$i],
        'trip_id'=>$myTrip->id,
        'date'=>$myTrip->date,
        'time'=>$myTrip->time 
       ]);
    
  }
 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
// get only working days
// $days=array();
// $month = 3;
// $year = 2018;
// $firstdate = $year.'-'.$month.'-01';  //taked firstdate using month and year
// $lastdate = date('t', strtotime($firstdate)); //get last date from first date of month
// for($d=1; $d<=$lastdate; $d++) // loop till last date
// {
//     $time=mktime(12, 0, 0, $month, $d, $year);   
//     //check if day not equal Sat on Sun date('D', $time) != "Sat" or (date('D', $time) != "Sun" )      
//     if ((date('m', $time)==$month && ($dayis != 'Sat')) && (date('m', $time)==$month && ($dayis != 'Sun'))){  
//         echo date('D', $time)."<br>"; //to echo day name
//         $days[]=date('Y-m-d H:i:s', $time); // store dates in array if not Saturday or Sunday
//     }
// }

// var_dump($days);