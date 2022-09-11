<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Image;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use App\Http\Requests\StorePost;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

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
        // $most_commented = Cache::remember('mostCommented', now()->addSeconds(10), function() {
        //     return BlogPost::mostCommented()->take(5)->get();
        // });
        // $mostActive = Cache::remember('mostActive', now()->addSeconds(10), function() {
        //     return User::withMostBlogPosts()->take(5)->get();
        // });
        // $lastMonthActive = Cache::remember('lastMonthActive', now()->addSeconds(10), function() {
        //     return User::withMostBlogPostsLastMonth()->take(5)->get();
        // });

        // $posts = Cache::remember('lastMonthActive', now()->addSeconds(10), function() {
        //     return BlogPost::latest()->withCount('comments')->with('user')->get()->paginate(10);
        // });
        $posts = BlogPost::latest()->withCount('comments')->with('user')->with('tags')->get();
        // dd($posts->take(5));
        return view('posts.index', 
        [
            'posts' => $posts->take(5),
            
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

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('thumbnail');
            $post->image()->save(
                Image::make(['path' => $path])
            );
            // $name1 = $file->storeAs('thumbnail', now()->format('Y-m-d'). '.'. $file->guessExtension());
            // $name2 = Storage::disk('public')->putFile('thumbnail', $file, now()->format('Y-m-d'). '.'. $file->guessExtension());
            // dump(Storage::url($name1));
            // dump(Storage::disk('public')->url($name2));
        }
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
        $post = Cache::remember("blog-post-{$id}", 60, function() use($id) {
            return BlogPost::with('comments')->findOrFail($id);
        });

        $sessionId = session()->getId();
        $counterKey = "blog-post-{$id}-counter";
        $userKey = "blog-post-{$id}-users";

        $users = Cache::get('users', []);

        $usersUpdate = [];
        $difference = 0;

        $now = now();
        foreach ($users as $session => $lastVisit) {
            # code...
            if($now->diffInMinutes($lastVisit) >= 1) {
                $difference--;
            } else {
                $usersUpdate[$session] = $lastVisit;
            }
        }

        if(
            !array_key_exists($sessionId, $users)
            || $now->diffInMinutes($users[$sessionId]) >= 1
           ) {
            $difference++;
        }

        $usersUpdate[$sessionId] = $now;

        Cache::forever($userKey, $usersUpdate);

        if (!Cache::has($counterKey)) {
            # code...
            Cache::forever($counterKey, 1);
        } else {
            Cache::increment($counterKey, $difference);
        }

        $counter = Cache::get($counterKey);
        return view('posts.show', 
        [
            'post' => $post,
            'counter' => $counter
        ]);
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

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('thumbnail');
            // dd($path, $post->image->path);
            if($post->image) {
                // Storage::disk('public')->delete('thumbnail/9OM0d4M7i2cdanvipinCT3NY0u6UMnCaMnkwdUbc.png');
                Storage::delete($post->image->path);
                $post->image->path = $path;
                $post->image->save();
            } else {
                $post->image()->save(
                    Image::make(['path' => $path])
                );

            }
            // $name1 = $file->storeAs('thumbnail', now()->format('Y-m-d'). '.'. $file->guessExtension());
            // $name2 = Storage::disk('public')->putFile('thumbnail', $file, now()->format('Y-m-d'). '.'. $file->guessExtension());
            // dump(Storage::url($name1));
            // dump(Storage::disk('public')->url($name2));
        }
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
