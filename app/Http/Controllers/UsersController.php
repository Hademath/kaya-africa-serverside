<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Admin;
use Mail;
use App\Mail\SendMail;
use HasApiTokens;


class UsersController extends Controller
{
    //
   public function __construct(){
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
        $this->result = (object) array(
            "status" => false,
            "status_code" => 200,
            "message" => null,
            "data"=> (object) null,
            "token" => null,
            "debug" => null
        );
       
    }

   

       public function Register(Request $request){
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|email|unique:users',
            'phone' => 'required|unique:users',
            'password'=> 'required|required|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
            // $this->result->message = $validator->errors()->get(['email', 'name']);
        }else{
            $user = User::create([
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'email'=>$request->email,
                'phone' => $request->phone,
                'password' => bcrypt($request->password),
                ]
            );
           
            if($user){
                $this->result->status = true;
                $this->result->message = "Successful";
                $this->result->data = $user;
            }else{
                $this->result->status = false;
                $this->result->message = "Not Successfull";
            }
           
       }
        return response()->json($this->result);
    }

    public function login(Request $request){
    	$validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (!$token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Invalid login credentials'], 401);
        }else{
            $this->result->status = true;
            $this->result->message = "Login Successful";
            $this->result->data = $token;
        }
        return $this->createNewToken($token);
    }


      public function get_all_users(){
        $users = User::paginate(15);
        if($users){
            $this->result->status = true;
            $this->result->message = "Successful";
            $this->result->data = $users;
        }else{
            $this->result->status = false;
            $this->result->message = "Not Successfull";
        }
        return response()->json($this->result);

    }

 public function get_user_by_id($id){
        $user = User::find($id);
        if (!$user) {
            $this->result->status_code = 404;
            $this->result->message = 'User not found';
            return response()->json($this->result);
        }
        if($user){
            $this->result->status = true;
            $this->result->message = "Successful";
            $this->result->data = $user;
        }
        return response()->json($this->result);
    }

      //make user an admin
    public function make_user_admin($id){
        $user = User::find($id);
        if (!$user) {
            $this->result->status_code = 404;
            $this->result->message = 'User not found';
            return response()->json($this->result);
        }
       $user_update = User::where('id', $id)->update(['is_admin' => 1, 'updated_at' => Carbon::now()->toDateTimeString()]);
        if($user_update){
            $this->result->status = true;
            $this->result->message = "Successful";
            $this->result->data = $user;
        }
        return response()->json($this->result); 
    }


 protected function createNewToken($token){
        return response()->json([
            'message'=> 'Successfully logged in',
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

     public function logout(Request $request){
        $user = Auth::user()->token();
        $user->revoke();
        return 'Successfully logged out'; 
    }

 
public function refresh(){
        return $this->createNewToken(auth()->refresh());
    }
    
}
