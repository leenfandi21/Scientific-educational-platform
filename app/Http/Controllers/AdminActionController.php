<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Image;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use TCG\Voyager\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use TCG\Voyager\Models\Permission;
use App\Traits\GeneralTrait;

class AdminActionController extends Controller
{
    use GeneralTrait;


    public function index()
    {
        $posts=Post::with('images')->get();

        return $this->returnData("posts", $posts);
    }


    public function index1()
    {
        $posts = Post::with('images')->get();


        return view('post', compact('posts'));
    }



    public function store(Request $request)
    {

        $validator=Validator::make($request->all(),[
            'description'=>['nullable','string'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(),400);
        }

        $input= $request->all();
        $user = Auth::user();
        $input['user_id']=$user->id;
        if( $user->role_id == 1)
        {
        $post = Post::create($input);
        $post_id=$post->id;
        if($request->has('images')){
            foreach($request->file('images') as $image){
                $file_name = time() . '.' . $image->getClientOriginalExtension();
                $path='images/' . $file_name;
                $image->move(public_path('images'), $file_name);
                Image::create([
                    'post_id'=>$post_id,
                    'image_path'=>$path
                ]);

            }
        }

        return redirect()->route('news_post.index')->with('success', 'Time aded successfully!');
    }
    else{
        return view('unAuth');
    }

    }


    public function show($id)
    {


        $post=Post::where('id','=',$id)->with('images')->get();

        if ($post)
            return $this->returnData("post", $post);
        else
            return $this->returnError("404", "There is no post with id:" . $id . " not found!");
    }

    public function edit(Post $news_post)
    {
        // Retrieve the news post for editing
        return view('edit', compact('news_post'));
    }

    public function update(Request $request, Post $news_post)
    {
        $user = Auth::user();
        if($user->role_id != 1 )
        {
            return redirect()->route('news_post.index');
        }
        // Validate the request data
        $validatedData = $request->validate([
            'description' => 'required|string',
        ]);

        // Update the news post
        $news_post->update($validatedData);

        // Redirect to the updated post or any other appropriate page
        return redirect()->route('news_post.index', ['news_post' => $news_post->id]);
    }

    public function addCourse(Request $request){

    // Check if the user is authenticated
    if ($request->user()) {
        // Check if the user has the 'admin' role
        if ($request->user()->hasRole('admin')) {
            $validatedData = $request->validate([
                'course_name' => 'required|string',
                'course_code' => 'required|string',
            ]);
            $course = new Course();
            $course->name = $validatedData['course_name'];
            $course->code = $validatedData['course_code'];

            // Save the course to the database
            $course->save();

            // Return a success response
            return response()->json(['message' => 'Course created successfully'], 200);
        } else {
            // User is not an admin
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    } else {
        // User is not authenticated
        return response()->json(['message' => 'Unauthenticated'], 401);
    }
    }

    public function destroy(Post $news_post)
    {
        $user = Auth::user();
        if($user->role_id != 1 )
        {
            return redirect()->route('news_post.index');
        }
        // Delete the news post
        $news_post->delete();

        // Redirect to the index page or any other appropriate page
        return redirect()->route('news_post.index');
    }








}
