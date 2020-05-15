<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\{Post, Category, Tag};
use App\Enums\PostStatusType;
use Illuminate\Http\Request;
use Auth;
use Gate;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Image;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::paginate();
        $title = "Posts Management";
        return view('admin.posts.index', compact('posts', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Add New Post";
        $categories = Category::get()->pluck('name', 'id');
        $tags = Tag::get()->pluck('name', 'id');
        $status = PostStatusType::toSelectArray();
        return view('admin.posts.create', compact('title'))
            ->withStatus($status)->withCategories($categories)->withTags($tags);
    }

    // public function create()
    // {
    //     $user = Auth::guard('admin')->user();
        
    //     // if ($user->can('create', Post::class)) {
    //     //     echo 'Current logged in user is allowed to create new posts.';
    //     // } else {
    //     //     echo 'You can not create post';
    //     // }
    //     // exit;
        

    //     // if ($this->authorize('create', Post::class)) {
    //     //     echo 'Current logged in user is allowed to create new posts.';
    //     // } else {
    //     //     echo 'You can not create post';
    //     // }
    //     // exit;

        
    //     if ($user->can('create', Post::class)) {
    //         $title = "Add New Post";
    //         $categories = Category::get()->pluck('name', 'id');
    //         $tags = Tag::get()->pluck('name', 'id');
    //         $status = PostEnumStatusType::toSelectArray();
    //         return view('admin.posts.create', compact('title'))
    //             ->withStatus($status)->withCategories($categories)->withTags($tags);
    //     } else {
    //         return redirect(route('admin.posts.index'))->with('warning','You can not create post');
    //     }
        
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $post = Post::firstOrCreate([
            'title' => $request->title,
            'content' => $request->content,
            'status' => $request->status,
            'cover_path' => $this->uploadCover($request->file("cover")),
            // 'cover_path' => $this->uploadImage($request->file("cover")),
            'user_id' => Auth::guard('admin')->id(),
        ]);

        $post->tags()->sync((array)$request->input('tags'));  
        $post->categories()->sync((array)$request->input('categories'));  
        return redirect()->route('admin.posts.index')->withSuccess('Post Created Successfully');
    }

    private function uploadCover(UploadedFile $file) : string
    {
        $filename = time() . "." . $file->getClientOriginalExtension();
        $file->storeAs("public/covers", $filename);
        return asset("storage/covers/". $filename);
    }

    public function uploadImage(UploadedFile $file) : string
    {
        $filename = time() . "." . $file->getClientOriginalExtension();
        $img = Image::make($file);
        $img->resize(520, 250, function ($constraint) {
            $constraint->aspectRatio();
        })->save(storage_path('app/public/covers')."/".$filename);
        return asset("storage/covers/". $filename);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $user = Auth::guard('admin')->user();
        if (Gate::forUser($user)->allows('update-post', $post)) {
            $categories = Category::get()->pluck('name', 'id'); 
            $status = PostStatusType::toSelectArray();
            $tags = Tag::get()->pluck('name', 'id');
            return view('admin.posts.edit')->withPost($post)->withStatus($status)->withCategories($categories)->withTags($tags)->withTitle('Posts management');
        } else {   
            return redirect(route('admin.posts.index'))->with('warning','Not Allowed Edit Post');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $data = ['title' => $request->title, 'content'=>$request->content, 'status'=>$request->status, 'user_id'=> Auth::guard('admin')->id()];

        if($request->file("cover")) {
            Storage::delete("public/covers/" . $post->cover);
            $data += ["cover_path" => $this->uploadImage($request->file("cover"))]; 
        } else {
            $data += ["cover_path" => $post->cover_path]; 
        }

        $post->update($data);
        $post->tags()->sync((array)$request->input('tags'));
        $post->categories()->sync((array)$request->categories); 
        return redirect(route('admin.posts.index'))->with('message','Post has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->tags()->detach();
        Storage::delete("public/covers/{$post->cover}");
        $post->delete();
        return redirect()->route('admin.posts.index')->with('success','Post deleted successfully');
    }
    
}
