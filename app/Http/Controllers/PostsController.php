<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use App\Http\Requests\StorePost;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;


class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['create','store','edit','update','destroy']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mostCommented = Cache::remember('blog-post-commented', 60, function () {
            return BlogPost::mostCommented()->take(5)->get();
        });
        $mostActive = Cache::remember('users-most-active', 60, function () {
            return User::WithMostBlogPosts()->take(5)->get();
        });
        $mostActiveLastMonth = Cache::remember('users-most-active-last-month', 60, function () {
            return User::WithMostBlogPostsLastMonth()->take(5)->get();
        });
        return view(
            'posts.index',
            [
                'posts' => BlogPost::latest()->withCount('comments')
                ->with('user')->with('tags')->get(),
                'mostCommented' => $mostCommented,
                'mostActive' => $mostActive,
                'mostActiveLastMonth' =>  $mostActiveLastMonth ,
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        //
        // this is used to validate inputs
        $validated = $request->validated();
        $validated['user_id'] = $request->user()->id;

        $post = BlogPost::create($validated);
        // // this is used to strore in the database
        // $post = new BlogPost();
        // $post->title = $validated['title'];
        // $post->content = $validated['content'];

        // // this is used to save to the database
        // $post->save();


        // for showing flash messages or onetime messages
        $request->session()->flash('status', 'The Blog post was created!');

        // to redirect after the contents have been saved
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
        // abort_if(isset($posts[$id]), 404);

        // return view('posts.show',
        // ['post'=> BlogPost::with(['comments' => function ($query) {
        //     return $query->latest();
        // }])->findOrFail($id)]);

        $blogPost = Cache::remember('blog-post-{$id}', 30, function () use($id){
            return BlogPost::with('comments')->with('tags')->with('user')->findOrFail($id);
        });
        $sessionId = session()->getId();
        $counterKey = "blog-post-{$id}-counter";
        $usersKey = "blog-post-{$id}-users";

        $users = Cache::get($usersKey, []);
        $usersUpdate = [];
        $difference = 0;
        $now = now();

        foreach ($users as $session => $lastVisit){
            if(now()->diffInMinutes($lastVisit) >= 1){
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
        Cache::forever('$userKey', $usersUpdate);

        if(!Cache::has($counterKey)) {
            Cache::forever('$counterKey', 1);
        } else {
            Cache::increment($counterKey, $difference);
        }

        $counter = Cache::get('$counterKey');

        return view('posts.show',[
            'post'=> $blogPost,
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

        $post = BlogPost::findOrFail($id);
        // if (Gate::denies('update-post', $post))
        // {
        //     abort(403, "You cannot edit this Blog Post");
        // }

        $this->authorize($post);

        return view('posts.edit', ['post' => $post ]);
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

        // if (Gate::denies('update-post', $post))
        // {
        //     abort(403, "You cannot edit this Blog Post");
        // }
        $this->authorize($post);
        $validated = $request->validated();
        $post->fill($validated);
        $post->save();

        $request->session()->flash('status', 'BlogPost Was Updated!');

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

        $this->authorize($post);
        $post->delete();

        session()->flash('status', 'Blog post was Deleted!');

        return redirect()->route('posts.index');
    }
}
