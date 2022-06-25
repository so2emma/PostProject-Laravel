<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use App\Http\Requests\StorePost;
use Illuminate\Support\Facades\Gate;
// use Illuminate\Support\facades\DB;

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
        // DB::connection()->enableQueryLog();
        // $posts = BlogPost::all();
        // foreach ($posts as $post) {
        //     foreach($post->comments as $comment){
        //         echo $comment->content;
        //     }
        // }
        return view(
            'posts.index',
            [
                'posts' => BlogPost::latest()->withCount('comments')->get(),
                'mostCommented' => BlogPost::mostCommented()->take(5)->get(),
                'mostActive' => User::WithMostBlogPosts()->take(5)->get(),
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

        return view('posts.show',
        ['post'=> BlogPost::with('comments')->findOrFail($id)]);
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
