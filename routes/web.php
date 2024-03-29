<?php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\PostTagController;
use App\Http\Controllers\UserCommentController;
use App\Http\Controllers\UserController;
use App\Mail\CommentPostedMarkdown;
use App\Models\Comment;
use Illuminate\Http\Request;
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

// Route::get('/', function () {
//     return view('home.index', []);
// })->name('home.index');

// Route::get('contact', function() {
//     return view('home.contact');
// })->name('home.contact');



Route::get('/', [HomeController::class, 'home'])->name('home.index');
Route::get('/contact', [HomeController::class, 'contact'])->name('home.contact');
Route::get('/secret', [HomeController::class, 'secret'])->name('home.secret')
->middleware('can:home.secret');
Route::resource('posts', PostsController::class);
Route::get("/posts/tag/{tag}", [PostTagController::class, "index"])->name("posts.tags.index");

Route::post("posts/{post}/comments", [PostCommentController::class, "store"])->name("posts.comments.store");
Route::post("users/{user}/comments", [UserCommentController::class, "store"])->name("users.comments.store");
Route::resource("users", UserController::class)->only(["show", "edit","update"]);

Route::get('mailable', function () {
    $comment = Comment::find(1);
    return new CommentPostedMarkdown($comment);
});

Auth::routes();


// Route::get('/single', AboutController::class);

// $posts = [
//     1 => [
//         'title' => 'Intro to Laravel',
//         'content' => 'This is a short intro to Laravel',
//         'is_new'=> true,
//         'has_comments'=> true
//     ],
//     2 => [
//         'title' => 'Intro to PHP',
//         'content' => 'This is a short intro to PHP',
//         'is_new' => false
//     ],
//     3 => [
//         'title' => 'Intro to Golang',
//         'content' => 'This is a short intro to PHP',
//         'is_new' => false
//     ]
// ];

// Route::get('/posts', function (Request $request) use($posts) {

//     // dd(request()->all());
//     dd((int)request()->query('page',1));
//     return view('posts.index', ['posts'=>$posts]);
// });

// Route::get('/posts/{id}', function($id) use($posts) {


//     abort_if(!isset($posts[$id]),404);

//     return view('posts.show',['post'=>$posts[$id]]);
// });

// Route::get('posts/{id}', function ($id) {
//     return ' God is good' .$id;
// })
// // ->where([
// //     'id'=> '[0-9]+'
// // ])
// ->name('posts.show');

// Route::get('/recent-posts/{days_age?}', function ($daysAgo = 20) {
//     return ' Posts from'.$daysAgo. 'Ago';
// })->name('posts.recent.index')->middleware('auth');






// Route::prefix('/fun')->name('fun.')->group(function() use($posts){

//     Route::get('/responses', function() use($posts) {
//         return response($posts, 201)
//         ->header('content-Type', 'application/json')
//         ->cookie('MY_COOKIE', 'Oso Emmauel', 3600);
//     })->name('responses');

//     Route::get('/redirect', function() {
//         return redirect('/contact');
//     })->name('redirect');

//     Route::get('/named-route', function() {
//         return redirect()->route('posts.show', ['id' => '1']);
//     })->name('named-route');

//     Route::get('/away', function() {
//         return redirect()->away('https://google.com');
//     })->name('away');

//     Route::get('/json', function() use($posts) {
//         return response()->json($posts);
//     })->name('json');

//     Route::get('/download', function() {
//         return redirect()->downlaod(public_path('daniel.jpg'), 'face.jpg');
//     })->name('download');
// });
