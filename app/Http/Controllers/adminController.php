<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class adminController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['loginAdmin', 'registerAdmin']]);
                // $this->middleware('type', ['only' => ['login']]);
          // $this->middleware('verified', ['only' => ['login']]);


    }//end __construct()

     protected function guard()
    {
        return Auth::guard();

    }//end guard()

   function loginAdmin(Request $request){
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

   		
   }
   public function registerAdmin(Request $request){
   	$validator= Validator::make(
   		$request->all(),
   		[
   		'name' => 'required|string|between:2,100',
        'email'=>'required|email|unique:users',
        'password' =>'required|min:5',
        'phone_number'=>'required',
        'type' => 'required',
    
]);
   	if($validator->fails()){
   		return response()->json(['massege'=>'Account already exists'],501);

   	}
   
   $user= User::create(
   	array_merge(
   		$validator->Validated(),
   		['password'=>bcrypt($request->password)]));
      $user->sendEmailVerificationNotification();

        return response()->json(['message' => 'User created successfully']);

} 
 public function UserTokens(Request $request)
    {

     $user=User::where('social_number',$request->social_number)->first();

     return response()->json(['msg'=>$user], 400);;
    

    }
    public function addTokens(Request $request){
    $user=User::where('social_number',$request->social_number)->increment('token',$request->amount);
        return response()->json(['msg'=> 'Tokens Added']);
    }

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

}


