<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;;
use App\Enums\PostStatusType;

class BlogController extends Controller
{
    public function index()
    {
        
        $posts = Post::with('user')->where('status', PostStatusType::Published)->simplePaginate(5);
        $title = "Blog post list";
        return view('blog.index', compact('posts', 'title'));
    }
 
    public function show($slug)
    {
        if (is_numeric($slug)) {
            $post = Post::findOrFail($slug);
            return Redirect::to(route('blog.show', $post->slug), 301);
        }
        $title = "Blog post item";
        $post = Post::whereSlug($slug)->with('user')->with('categories')->firstOrFail();
        
        // $post->increment('votes');
        // \Session::flush();

        $Key = 'blog' . $post->id;
        if (!\Session::has($Key)) {
            $post->increment('votes');
            \Session::put($Key, 1);
        }
        
        return view('blog.show',compact('post'));
    }

}
