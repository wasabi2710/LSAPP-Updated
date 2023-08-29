<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$posts = Post::orderBy('created_at', 'desc')->paginate(1);
        // raw query
        //$posts = DB::select('SELECT * FROM posts ORDER BY created_at DESC');

        $posts = Post::paginate(4);

        return view('posts.index')->with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'cover_image' => 'image|nullable|max:1999'
        ]);

        // handle file upload
        if ($request->hasFile('cover_image')) {
            // get file name with extension
            $fileNameExt = $request->file('cover_image')->getClientOriginalName();
            // get just file name
            $fileName = pathinfo($fileNameExt, PATHINFO_FILENAME);
            // get just ext
            $extName = $request->file('cover_image')->getClientOriginalExtension();
            // file name to store
            $fileNameToStore = $fileName.'_'.time().$extName;
            // upload image
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
        } 
        $post = new Post();
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        if ($request->hasFile('cover_image')) {
            $post->cover_image = $fileNameToStore;
        }
        $post->user_id = auth()->id();

        $post->save();

        return redirect('/posts')->with('success', 'Post Created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::find($id);
        return view('posts.showPost')->with('post', $post);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Post::find($id);

        //authorization
        if (auth()->id() !== $post->user_id) {
            return redirect('/posts')->with('error', 'Unauthorized Access');
        }

        return view('posts.edit')->with('post', $post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required'
        ]);
        
        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');

        $post->save();

        return redirect('/posts')->with('success', 'Post Updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::find($id);

        //authorization
        if (auth()->id() !== $post->user_id) {
            return redirect('/posts')->with('error', 'Unauthorized Access');
        }
        
        // handle with image
        if ($post->cover_image !== 'noimage.jpg') {
            // delete image
            Storage::delete('/public/cover_images/'.$post->cover_image);
        }

        $post->delete();
        return redirect('/posts')->with('success', 'Post Removed!');
    }
}
