<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Resources\postResource;
use App\Models\Post;
use App\Trait\ApiTrait;
use App\Trait\ImageTrait;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    use ApiTrait,ImageTrait;

    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
        $user_id=Auth::guard('sanctum')->user()->id;
        $posts= Post::where('user_id',$user_id)->orderBy('pinned', 'DESC')->get();
        $posts=postResource::collection($posts);
        return $this->send(true,'return all posts',200,$posts);
    }
    catch(\Exception $ex){
     return $this->send(false,'حدثت مشكلة اثناء جلب البيانات]',500);
 }
    }



    /**
     * Store a newly created resource in storage.
     */
    public function create(PostRequest $request)
    {
        try{
        $image = $this->saveImage($request->image,public_path('Upload/Images/PostImages'));
        $user_id=Auth::guard('sanctum')->user()->id;
        Post::create([
            'title'=>$request->title,
            'body'=>$request->body,
            'image'=>$image,
            'Pinned'=>$request->Pinned,
            'user_id'=>$user_id
           ]);
           return $this->send(true,'the post created',200);
        }
           catch(\Exception $ex){
            return $this->send(false,'حدثت مشكلة اثناء الحفظ',500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
    try{
        $post= new postResource(Post::findOrFail($request->id));
        return $this->send(true,'return  post that id ',200,$post);
    }
    catch(\Exception $ex){
     return $this->send(false,'حدثت مشكلة اثناء جلب البيانات]',500);
 }
    }

    /**
     * Display the deleted post.
     */
    public function deleted_posts()
    {
    try{
        $user_id=Auth::guard('sanctum')->user()->id;
        $posts= Post::where('user_id',$user_id)->onlyTrashed()->orderBy('pinned', 'DESC')->get();
        $posts=postResource::collection($posts);
        return $this->send(true,'all soft dleted posts ',200,$posts);
    }
    catch(\Exception $ex){
     return $this->send(false,'حدثت مشكلة اثناء جلب البيانات]',500);
 }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request)
    {
    if(!$request->id)
    return $this->send(true,'not found tag',403);
    $post=Post::find($request->id);
    if(!$post)
    return $this->send(true,'not found tag',403);
    if($request->image){
        $this->deleteImage($post->image,$this->path_post_image());
        $image = $this->saveImage($request->image,$this->path_post_image());
        $post->image=$image;
    }

    $post->title=$request->title;
    $post->body=$request->body;
    $post->Pinned=$request->Pinned;
    $post->save();

    $post= new postResource($post);
    return $this->send(true,'the tag updated',200,$post);
    }

      /**
     * softDelete
     */
    public function delete(Request $request)
    {

        if(!$request->id)
        return $this->send(true,'not found post',403);
        $post=Post::find($request->id);
        if(!$post)
        return $this->send(true,'not found post',403);
        $post->delete();
        return $this->send(true,'the tag deleted',200,[Carbon::now()->subMonth(), $post->delete_at]);
    }
    public function restore(Request $request)
    {
        if(!$request->id)
        return $this->send(true,'not found id',403);
        $post=Post::onlyTrashed()->find($request->id);
        if(!$post)
        return $this->send(true,'not found post',403);
        $post->restore();
        return $this->send(true,'restor deleted post',200);
    }

}
