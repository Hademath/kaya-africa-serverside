<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Shops;   
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Mail;
use App\Mail\SendMail;
use HasApiTokens;

class VendorsController extends Controller
{
  public function __construct() {
        $this->middleware('jwt');
        $this->result = ( object ) array(
            'status' => false,
            'status_code' => 200,
            'message' => null,
            'data'=> ( object ) array(),
            'token' => null,
            'debug' => null
        );

    }

//   Login vendor can create  shops 
    public function create_shop(Request $request){
          $validator = Validator::make($request->all(), [
            'items' => 'required|string',
            'price' => 'required|string',
            'category' => 'required|string',
            'color'=> 'required|string',
        ]);

        if($validator->fails()){
            $this->result->status_code = 422;
            $this->result->message = $validator->errors()->get('*');
        }else{
            $user = Auth::user();
            $user_id = $user->id;
            $shop = Shops::create([
                'items' => $request->items,
                'user_id' => $user_id,
                'price' => $request->price,
                'category' => $request->category,
                'color' => $request->color,
                ]
            );
     
            if($shop){
                $this->result->status = true;
                $this->result->message = "Successful";
            }else{
                $this->result->status = false;
                $this->result->message = "Not Successfull";
            }

            return response()->json($shop); 
        }


    }
  
    //  Get all shops by the login User and return the shops
    public function get_shops(){
        $user = Auth::user();
        $user_id = $user->id;
        $shops = Shops::where('user_id', $user_id)->get();
        if($shops->count() > 0){
            $this->result->status = true;
            $this->result->message = "Successful";
            $this->result->data = $shops;
        }else{
            $this->result->status = false;
            $this->result->message = "Not Successfull";
        }
        return response()->json($shops);
    }

//    view shop by Id
    public function view_shop($id){
        $shop = Shops::find($id);
        if($shop){
            $this->result->status = true;
            $this->result->message = "Successful";
            $this->result->data = $shop;
        }else{
            $this->result->status = false;
            $this->result->message = "Not Successfull";
        }
        return response()->json($shop);
    }    


    //Allow the super admin to get all shops
    public function get_all_shops(){
        $shops = Shops::all();
        $valid_admin = Auth::user();
        $is_admin = $valid_admin->is_admin==1;
           if(!$is_admin){
                $this->result->status_code = 401;
            $this->result->message = 'You are not authorized to perform this action';
            return response()->json($this->result);
                }else{
                      if($shops==true){
            $this->result->status = true;
            $this->result->message = "Successful";
            $this->result->data = $shops;
        }else{
            $this->result->status = false;
            $this->result->message = "Not Successfull";
        }
    }
      
        return response()->json($shops);
    }
  



    //  admin can deactivate users 
    public function deactivate_vendor($id){
        $user = User::find($id);
        if(!$user) {
            $this->result->status_code = 404;
            $this->result->message = 'User not found';
            return response()->json($this->result);
        }else{
            
                $valid_admin = Auth::user();
                $is_admin = $valid_admin->is_admin==1;
                if(!$is_admin){
                     $this->result->status_code = 401;
                    $this->result->message = 'You are not authorized to perform this action';
                    return response()->json($this->result);
                }else{
                    $active_user = User::where('id', $id)->where('status', '1')->first();
                    if($active_user ){
                        $user_update = User::where('id', $id)->update(['status' => '0', 'updated_at' => Carbon::now()->toDateTimeString()]);
                        $this->result->status = true;
                        $this->result->message = "User deactivated";
                        $this->result->data = $user;
                        }else{
                    $this->result->status = false;
                    $this->result->message = "User already deactivated";
                }
             }


                   
            
             return response()->json($this->result);

        }
        
    }



}
