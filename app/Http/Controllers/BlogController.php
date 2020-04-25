<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;;

class BlogController extends Controller
{
    public function index()
    {
        $posts = Post::simplePaginate(5);
        $title = "Blog post list";
        return view('blog.index',compact('posts', 'title'));
    }

    // public function show($id)
    // {
    //     $title = "Blog post item";
    //     $post = Post::where('id', $id)->first();
    //     return view('blog.show',compact('post', 'title'));
    // }

    public function show($slug)
    {
        if (is_numeric($slug)) {
            // Get post for slug.
            $post = Post::findOrFail($slug);
            return Redirect::to(route('blog.show', $post->slug), 301);
            // 301 редирект со старой страницы, на новую.   
        }
        $title = "Blog post item";
        // Get post for slug.
        $post = Post::whereSlug($slug)->firstOrFail();
        return view('blog.show',compact('post'));
    }

}
