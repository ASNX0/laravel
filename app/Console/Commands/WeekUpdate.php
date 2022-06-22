<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Trip;
use App\Models\Feature;
use App\Models\Bus;
use App\Http\Controllers\TripsController;

class WeekUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'week:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
      $tripController=new TripsController;
  $now=\Carbon\Carbon::now();

  $thisMonth=$now->month($now->month)->daysInMonth;

  $currentDay=$now->day;
  $currentMonth=$now->month;
  $currentDay1=15;
  if($currentDay==1 && $currentMonth==1){
   $tripController->scheduleTrips(1,$thisMonth,$now->month);
  }else if($currentDay1==1 && $currentMonth!=1){
  $tripController->scheduleTrips(15,$thisMonth,$now->month);
  }else if($currentDay1==15 && $currentMonth!=1){
  $tripController->scheduleTrips(1,14,$now->month+1);
   }












//   $now=\Carbon\Carbon::now();
//   $list=array();
//   $empty_bus=array();
//   $loc=array();
//   $week= $now->week;
//   $day=$now->day+7;
//   $nextMonth = $now->month($now->month+1);
//   return $thisMonth=$now->month();
//   $features=Feature::select('id')->with([
//         'buses' => function ($q)  {
//           $q->where('company_ID',1);
//         }
//     ])->get();
//   foreach ($features as $feature) {
//  $buses= $feature->buses;
//  foreach($buses as $bus){
//     $empty_bus[]= $bus->bus_number;
//     $loc=$bus->location_id;
//  }
// }
// ////////////////////////////////////////////
//  for($w=$day; $w<$day+8; $w++){
//    $time=mktime(12, 0, 0, $now->month, $w, $now->year);                
//     if (date('m', $time)==$now->month)       
//     $list[$w]=date('Y-m-d-D', $time);
//  for($t=06; $t<=18; $t++){
//      $time_in_24_hour_format[] = date("H:i", strtotime("$t:00"));
//      }
  
//      for($i=0; $i<count($time_in_24_hour_format); $i++){
//     for($id=0; $id<count($empty_bus); $id++){
//      $flight = Trip::create([
//        'location_id'=> $loc,
//        'bus_id'=>$empty_bus[$id],   
//        'date' => $list[$w],
//        'time'=> $time_in_24_hour_format[$i]
//        ]);
//       }
//      }
//    }
 }
}
