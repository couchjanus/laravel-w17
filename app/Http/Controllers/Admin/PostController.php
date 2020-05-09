<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\{Post, Category, Tag};
use App\Enums\PostStatusType;
use Illuminate\Http\Request;
use Auth;
use Gate;

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
            'category_id' => $request->category_id,
            'user_id' => Auth::id() ?? 1
        ]);

        $post->tags()->sync((array)$request->input('tags'));  
        return redirect()->route('admin.posts.index')->withSuccess('Post Created Successfully');
    }

    // public function store(Request $request)
    // {

    //     // $this->validate($request, [
    //     //     'title' => 'required',
    //     //     'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    //     // ]);

    //     $post = Post::firstOrCreate([
    //         'title' => $request->title,
    //         'content' => $request->content,
    //         'status' => $request->status,
    //         'user_id' => Auth::guard('admin')->id(),
    //         'cover_path' => $this->uploadImage($request->file("cover")),
    //         'visits' => 0
    //     ]);

    //     $post->categories()->sync((array)$request->input('categories'));  
    //     $post->tags()->sync((array)$request->input('tags'));  
    //     return redirect()->route('admin.posts.index');
    // }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        // if ($user->can('view', $post)) {
        //   echo "Current logged in user is allowed to update the Post: {$post->title}";
        // } else {
        //   echo 'Not Authorized.';
        // }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $categories = Category::pluck('name', 'id'); 
        $status = PostStatusType::toSelectArray();
        $tags = Tag::get()->pluck('name', 'id');
        return view('admin.posts.edit')->withPost($post)->withStatus($status)->withCategories($categories)->withTags($tags)->withTitle('Posts management');
    }

    // public function edit(Post $post)
    // {
    //     $user = Auth::guard('admin')->user();

    //     // if (Gate::forUser($user)->allows('update-post', $post)) {
    //     //     echo 'Allowed Edit Post';
    //     // } else {
    //     //         echo 'Not Allowed Edit Post ';
    //     // }
    //     // exit;

    //     if (Gate::forUser($user)->allows('update-post', $post)) {
    //         $categories = Category::pluck('name', 'id'); 
    //         $status = PostEnumStatusType::toSelectArray();
    //         $tags = Tag::get()->pluck('name', 'id');
    //         return view('admin.posts.edit')->withPost($post)->withStatus($status)->withCategories($categories)->withTags($tags)->withTitle('Posts management');
    //     } else {   
    //         return redirect(route('admin.posts.index'))->with('warning','Not Allowed Edit Post');
    //     }
        
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $post->update(['title' => $request->title, 'content'=>$request->content, 'status'=>$request->status, 'category_id'=>$request->category_id, 'user_id'=>Auth::id() ?? 1]);
        $post->tags()->sync((array)$request->input('tags'));
        return redirect()->route('admin.posts.index')->withSuccess('Post Updated Successfully');
    }

    // public function update(Request $request, Post $post)
    // {
        
    //     $data = ['title' => $request->title, 'content'=>$request->content, 'status'=>$request->status, 'user_id'=>Auth::id() ?? 1];

    //     if($request->file("cover")) {
    //         Storage::delete("public/covers/" . $post->cover);
    //         $data += ["cover_path" => $this->uploadCover($request->file("cover"))]; 
    //     } else {
    //         $data += ["cover_path" => $post->cover_path]; 
    //     }

    //     $post->update($data);

    //     $post->tags()->sync((array)$request->input('tags'));
    //     $post->categories()->sync((array)$request->input('categories')); 

    //     return redirect()->route('admin.posts.index');

    //     // $user = Auth::guard('admin')->user();
    //     // if ($user->can('update', $post)) {
    //     // $post->update($request->all());
    //     // $post->tags()->sync((array)$request->input('tags'));
    //     // return redirect(route('admin.posts.index'))->with('message','Post has been updated successfully');
    //     // } else {
    //     //     return redirect(route('admin.posts.index'))->with('warning',"Current logged in user is not allowed to update the Post: {$post->id}");
    //     // }
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->tags()->detach();
        $post->delete();
        return redirect()->route('admin.posts.index');
    }

    // public function destroy(Post $post)
    // {
    //     $post->tags()->detach();
    //     Storage::delete("public/covers/{$post->cover}");
    //     $post->delete();
    //     return redirect()->route('admin.posts.index');

    //     // $user = Auth::guard('admin')->user();
        
    //     // if ($user->can('delete', $post)) {
    //     //     $post->tags()->detach();
    //     //     $post->delete();
    //     //     return redirect()->route('admin.posts.index')->with('success','Post deleted successfully');
    //     // } else {
    //     //     return redirect()->route('admin.posts.index')->with('warning','Пользователь '.$user->name.' не может удалять статью...');
    //     // }
        
    //     // if (Gate::forUser($user)->denies('destroy-post', $post)) {
    //     //     // Пользователь не может удалять статью...
    //     //     // dd('Пользователь '.$user->name.' не может удалять статью...');
    //     //     return redirect()->route('posts.index')->with('warning','Пользователь '.$user->name.' не может удалять статью...');
    //     // } else {
    //     // $post->tags()->detach();
    //     // $post->delete();
    //     // return redirect()->route('posts.index')->with('type','success')->with('message','Post deleted successfully');
    //     // }
    // }
}
