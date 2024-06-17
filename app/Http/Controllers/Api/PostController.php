<?php

namespace App\Http\Controllers\Api;

//import model Post
use App\Models\Post;
use App\Http\Controllers\Controller;
//import resource PostResource
use App\Http\Resources\PostResource;
//import Http request
use Illuminate\Http\Request;
//import facade Validator
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get all posts
        $posts = Post::latest()->paginate(5);

        //return collection of posts as a resource
        return new PostResource(true, 'List Data Posts', $posts);
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'nama_resep' => 'required',
            'deskripsi' => 'required',
            'bahan'   => 'required',
            'langkah' => 'required',
            'gambar' => 'required|gambar|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //upload gambar
        $gambar = $request->file('gambar');
        $gambar->storeAs('public/posts', $gambar->hashName());

        //create post
        $post = Post::create([
            'nama_resep'     => $request->nama_resep,
            'deskripsi'   => $request->deskripsi,
            'bahan'     => $request->bahan,
            'langkah'   => $request->langkah,
            'gambar'     => $gambar->hashName(),
        ]);

        //return response
        return new PostResource(true, 'Data Post Berhasil Ditambahkan!', $post);
    }
     /**
     * show
     *
     * @param  mixed $id
     * @return void
     */
    public function show($id)
    {
        //find post by ID
        $post = Post::find($id);

        //return single post as a resource
        return new PostResource(true, 'Detail Data Post!', $post);
    }
     /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'nama_resep' => 'required',
            'deskripsi' => 'required',
            'bahan' => 'required',
            'langkah' => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //find post by ID
        $post = Post::find($id);

        //check if gambar is not empty
        if ($request->hasFile('gambar')) {

            //upload gambar
            $gambar = $request->file('gambar');
            $gambar->storeAs('public/posts', $gambar->hashName());

            //delete old gambar
            Storage::delete('public/posts/' . basename($post->gambar));

            //update post with new gambar
            $post->update([
                'nama_resep'     => $request->nama_resep,
                'deskripsi'   => $request->deskripsi,
                'bahan'     => $request->bahan,
                'langkah'   => $request->langkah,
                'gambar'     => $gambar->hashName(),
            ]);
        } else {

            //update post without gambar
            $post->update([
                'nama_resep'     => $request->nama_resep,
                'deskripsi'   => $request->deskripsi,
                'bahan'     => $request->bahan,
                'langkah'   => $request->langkah,
            ]);
        }

        //return response
        return new PostResource(true, 'Data Post Berhasil Diubah!', $post);
    }

    /**
     * destroy
     *
     * @param  mixed $id
     * @return void
     */
    public function destroy($id)
    {

        //find post by ID
        $post = Post::find($id);

        //delete image
        Storage::delete('public/posts/'.basename($post->image));

        //delete post
        $post->delete();

        //return response
        return new PostResource(true, 'Data Post Berhasil Dihapus!', null);
    }
}
