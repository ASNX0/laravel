<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register','addimage']]);
                // $this->middleware('type', ['only' => ['login']]);
          // $this->middleware('verified', ['only' => ['login']]);


    }//end __construct()


    public function login(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email'    => 'required|email',
                'password' => 'required|string|min:5',
            ]
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $token_validity = (24 * 60);

        $this->guard()->factory()->setTTL($token_validity);
        $user=User::where('email',$request->email)->first();
    //     if($user->type!='User'){
    //     return response()->json(['error' => 'not a user account'], 401);
    // }

        if (!$token = $this->guard()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 402);
        }

            if(! is_null($this->guard()->user()->email_verified_at))
           return $this->respondWithToken($token);
            return response()->json(['error' => 'Not verified'], 403);

    }//end login()
 

    public function register(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name'     => 'required|string|between:2,100',
                'email'    => 'required|email',
                'password' => 'required|min:5',
                'phone_number'=> 'required',
                // 'social_number'=>'required',
                'type' => 'required',
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                ['message'=> 'Account already exists'],501
            );
        }

      $user = User::create(
            array_merge(
                $validator->validated(),
                ['password' => bcrypt($request->password),'token'=>0,'tiket'=>0]
            )
        );
          $user->sendEmailVerificationNotification();

        return response()->json(['message' => 'User created successfully']);

    }//end register()


    public function logout()
    {


   
        $this->guard()->logout();

        return response()->json(['message' => 'User logged out successfully']);

    }//end logout()


    public function profile()
    {
        return response()->json($this->guard()->user());

    }//end profile()


    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());

    }//end refresh()


    protected function respondWithToken($token)
    {
        return response()->json(
            [
                'token'          => $token,
                'token_type'     => 'bearer',
                'token_validity' => ($this->guard()->factory()->getTTL() * 60),
                'user' => $this->guard()->user(),
               
            ]
        );

    }//end respondWithToken()


    
    public function qrtoken(Request $request){

       $tokenval= $this->guard()->user()->token;
       if($tokenval<=200){
        return response()->json(['msg'=> 'You have 0 tokens']); 
       
    }else{
         $user=User::where('email', $request->email)->decrement('token',$request->amount);
        return response()->json(['msg'=> 'Paid successfully']);
    }

    }
    public function buytiket(Request $request){

       $tokenval= $this->guard()->user()->token;
       if($tokenval<=200){
        return response()->json(['msg'=> 'You have 0 tokens']); 
       
    }else{
         $user=User::where('email', $request->email)->decrement('token',$request->token);
        //$user=User::where('email', $request->email)->increment('tiket',$request->tikets);
        return response()->json(['msg'=> 'tiket bought']);
    }

    }
     public function mytokens(Request $request){

      
      
        $user=User::where('email',$request->email)->first();
        return response()->json(['tokens'=> $user->token,'tikets'=>$user->tiket]);
    

    }
    protected function guard()
    {
        return Auth::guard();

    }//end guard()

 
     public function addimage(Request $request)
    {

         $user = $this->guard()->user();

       
          
          if ($request->hasFile('License')) {
           $user->driver_license = $request->title;
            $path = $request->file('License')->store('images');
            $user->driver_license = $path;
             
           }
            if ($request->hasFile('Registration')) {
           $user->vehicle_registration = $request->title;
            $path = $request->file('Registration')->store('images');
            $user->vehicle_registration = $path;
             
           }
        $user->save();
        return response()->json(['msg' => $request->title], 201);
         
          // return new ImageResource($user);
    }

}//end class
