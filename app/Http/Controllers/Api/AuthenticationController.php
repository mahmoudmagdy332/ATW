<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Post;
use App\Models\User;
use App\Trait\ApiTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException as ValidationValidationException;

class AuthenticationController extends Controller
{
    use ApiTrait;
    public function register(RegisterRequest $request){
      $user=User::create([
        'name'=>$request->name,
        'phone'=>$request->phone,
        'password'=>$request->password,
      ]);
      $deviceName=$request->post('device_name',$request->userAgent());
      $token= $user->createToken($deviceName);
      return $this->send(true,'token',200, ['token'=>$token->plainTextToken,'user'=>$user]);
    }


    public function login(LoginRequest $request){
        $user=User::where('name',$request->name)
                ->orWhere('name',$request->phone)->first();

        if($user && Hash::check($request->password, $user->password)){
            $deviceName=$request->post('device_name',$request->userAgent());
            $token= $user->createToken($deviceName);
            return $this->send(true,'token',200, ['token'=>$token->plainTextToken,'user'=>$user]);
        }
        else{
            return $this->send(false,'خطأ فى تسجيل الدخول',401);
        }
    }
    public function end_point(){
        $user_count=User::count();
        $post_count=Post::count();
        $user_count_with_0_posts=User::whereDoesntHave('posts')->count();

        return $this->send(true,'end poind ',200, [
            'Number of all users'=>$user_count,
            'Number of all posts'=>$post_count,
            'Number of users with 0 posts'=>$user_count_with_0_posts
            ]);
    }
}
