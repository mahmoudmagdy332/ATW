<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagRequest;
use App\Models\Tag;
use App\Trait\ApiTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller
{
    use ApiTrait;
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(){
        $tags=Tag::all();
        return $this->send(true,'the tag created',200,$tags);
     }

   public function create(TagRequest $request){
   Tag::create([
    'name'=>$request->name
   ]);
   return $this->send(true,'the tag created',200);

}
public function update(TagRequest $request){
    if(!$request->id)
    return $this->send(true,'not found tag',403);
    $tag=Tag::find($request->id);
    if(!$tag)
    return $this->send(true,'not found tag',403);
    $tag->update([
     'name'=>$request->name
    ]);
    return $this->send(true,'the tag updated',200,$tag);

 }

 public function delete(Request $request){
    if(!$request->id)
    return $this->send(true,'not found tag',403);
    $tag=Tag::find($request->id);
    if(!$tag)
    return $this->send(true,'not found tag',403);
    $tag->delete();
    return $this->send(true,'the tag deleted',200);

 }


}



/* $rules = array(
    'name' => 'required|string',
);
$messages = array(
    'name.required'=>'الأسم مطلوب' ,
    'name.string'=>'الأسم يجب ان يكون حروف'
);
$validator = Validator::make($request,$rules,$messages);
if ($validator->fails()) {
    $this->send(false,'Validation errors',401,$validator->errors());
} */
