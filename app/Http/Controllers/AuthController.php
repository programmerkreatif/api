<?php
   
namespace App\Http\Controllers;

use App\Enums\HttpStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use App\Models\User;

class AuthController extends BaseController
{
    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')->plainTextToken; 
            $success['name'] =  $user->name;
            return $this->successResponse($success, 'User login successfully.');
        } 
        else{ 
            return $this->errorResponse('Unauthorised.', ['error'=>'Unauthorised'],HttpStatus::HTTP_UNAUTHORIZED);
        } 
    }
}