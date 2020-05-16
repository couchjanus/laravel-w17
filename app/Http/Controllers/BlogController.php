<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Post, Category};
use App\Enums\PostStatusType;
use Spatie\Searchable\Search;

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
        $Key = 'blog' . $post->id;
        if (!\Session::has($Key)) {
            $post->increment('votes');
            \Session::put($Key, 1);
        }
        
        return view('blog.show',compact('post'));
    }

    public function search(Request $request)
    {
        $searchResults = (new Search())
            ->registerModel(Post::class, 'title')
            ->registerModel(Category::class, 'name')
            ->perform($request->input('query'));

        return view('blog.search', compact('searchResults'));
    }

}
