<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\PostTagController;
use App\Http\Controllers\UserCommentController;
use App\Http\Controllers\UserController;
use App\Mail\CommentPosted;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class , 'home'])
     ->name('home.index');
    // ->middleware('auth');

Route::get('/contact', [HomeController::class , 'contact'])->name('home.contact');

Route::get('/single', AboutController::class);

Auth::routes();

Route::resource('posts', PostsController::class);
Route::resource('posts.comments', PostCommentController::class)->only(['index','store']);
Route::resource('users.comments', UserCommentController::class)->only(['store']);
Route::resource('users', UserController::class)->only(['show', 'edit', 'update']);
Route::get('/posts/tag/{tag}', [PostTagController::class, 'index'])->name('posts.tags.index');
     //->only(['index', 'show', 'create', 'store', 'edit', 'update']);

// Route::get('/posts', function() use($posts) {
//     // dd(request()->all());
//     dd(request()->input('page', 3));
//     return view('posts.index', ['posts' => $posts]);
// });

// Route::get('/posts/{id}', function ($id) use($posts) {

    

//     abort_if(!isset($posts[$id]), 404);
//     return view('posts.show', ['post' => $posts[$id]]);
// })
// // ->where([
// //     'id' => '[0-9]+'
// // ])
// ->name('posts.show');


// Route::get('/recent-posts/{days_ago?}', function ($days_ago = 5) {
//     return "Posts from {$days_ago} days ago";
// })->name('posts.recent.index')->middleware('auth');


// Route::get('/fun/responses', function() use($posts) {
//     return response($posts, 201)
//           ->header('Content-Type', 'application/json')
//           ->cookie('MY_COOKIE', 'Hanuman Shaik', 3600);
// });

Route::get('/mailable', function() {
     $comment = Comment::find(1);
     return new CommentPosted($comment);
});

// Route::get('/fun/download', function() use($posts) {
//     return response()->download(public_path('/image-1.png'), 'sample-image.png');
// });
