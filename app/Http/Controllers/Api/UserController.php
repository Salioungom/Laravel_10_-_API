<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResgiterUser;
use App\Http\Requests\LogUserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
   public function register(ResgiterUser $request)

   {

    try{
        $user=new User();
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password=bcrypt($request->password);
        $user->save();
        return response()->json([
            'status_code' => 200,
            'status_message' => 'Utilisateur ajouter avec succes',
            'Utilisateur'=>$user,
        ]);
    }
    catch(Exception $e){

    }

   }


   public function login(LogUserRequest $request)
   {
    if(auth()->attempt($request->only(['email','password'])))
    {
        $user=auth()->user();
        $token=$user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'status_code' => 200,
            'status_message' => 'Utilisateur connecté avec succes',
            'Utilisateur'=>$user,
            'token'=>$token,
        ]);
    }else{
        return response()->json([
            'status_code' => 403,
            'status_message' => 'Infromation d\'authentification incorrecte',

        ]);
    }

    // try{
    //     $user=User::where('email',request('email'))->first();
    //     $token=$user->createToken('auth_token')->plainTextToken;
    //     return response()->json([
    //         'status_code' => 200,
    //         'status_message' => 'Utilisateur connecté avec succes',
    //         'Utilisateur'=>$user,
    //         'token'=>$token,
    //     ]);
    // }catch(Exception $e){

    // }
   }
   public function logout(Request $request)
   {
      //
   }
}
