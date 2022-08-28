<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use App\Http\Requests\StorePost;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class PostsController extends Controller
{
    
    public function __construct() {
        $this->middleware('auth')
             ->only(['create', 'store', 'edit', 'update', 'destroy']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // DB::enableQueryLog();
        // $posts = BlogPost::with('comments')->get();
        // foreach($posts as $post) {
        //     foreach($post->comments as $comment) {
        //         echo $comment;
        //     }
        // }

        // dd(DB::getQueryLog());
        return view('posts.index', 
        [
            'posts' => BlogPost::latest()->withCount('comments')->get(),
            'most_commented' => BlogPost::mostCommented()->take(5)->get(),
            'mostActive' => User::withMostBlogPosts()->take(5)->get(),
            'lastMonthActive' => User::withMostBlogPostsLastMonth()->take(5)->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePost $request)
    {
        $validatedData = $request->validated();
        $validatedData['user_id'] = $request->user()->id;
        $post =  BlogPost::create($validatedData);
        $request->session()->flash('status', 'BlogPost was created');
        return redirect()->route('posts.show', ['post' => $post->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // return view('posts.show', ['post' => BlogPost::with(['comments' => function($query) {
        //     return $query->latest();
        // }])->findOrFail($id)]);
        return view('posts.show', ['post' => BlogPost::with('comments')->findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('posts.edit', ['post' => BlogPost::findOrFail($id)]);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorePost $request, $id)
    {
        $post = BlogPost::findOrFail($id);
        // if(Gate::denies('posts.update', $post)) {
        //     abort(403, 'You cant update');
        // }
        $this->authorize('update', $post);
        $validatedData = $request->validated();
        $post->fill($validatedData);
        $post->save();
        $request->session()->flash('status', 'BlogPost was updated!');
        return redirect()->route('posts.show', ['post' => $post->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = BlogPost::findOrFail($id);
        
        $this->authorize('delete', $post);
        $post->delete();

        session()->flash('status', 'BlogPost was deleted!');
        return redirect()->route('posts.index');

    }
}
