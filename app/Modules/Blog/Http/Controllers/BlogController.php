<?php

namespace App\Modules\Blog\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Modules\Blog\Http\Request\BlogRequest;
use App\Modules\Blog\Http\Request\DeleteBlogRequest;
use App\Modules\Blog\Http\Request\StoreBlogRequest;
use App\Modules\Blog\Http\Request\UpdateBlogRequest;
use App\Modules\Blog\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(BlogRequest $request)
    {
        $blogs = Blog::when($request->search, function ($q, $f) {
            $q->where('title', 'LIKE', "%$f%")
                ->orWhere('blog_body', 'LIKE', "%$f%");
        })->paginate(10);
        return response()->json([
            'data' => $blogs
        ]);
    }

    public function show(Request $request)
    {
        $uuid = $request->uuid;
        $blog = Blog::where('uuid', $uuid)
            ->with('author:id,name')
            ->first();
        return response()->json([
            'data' => $blog
        ]);
    }

    public function store(StoreBlogRequest $request)
    {
        $data = $request->validated();
        $user = auth()->user();
        $blog = $user->blogs()->create($data);
        return response()->json([
            'success' => true,
            'data' => $blog
        ]);
    }

    public function update(UpdateBlogRequest $request)
    {
        $data = $request->validated();
        $blog = Blog::where('uuid', $data['uuid'])->first();
        $blog->update($data);
        return response()->json([
            'success' => true,
            'data' => $blog
        ]);
    }

    public function delete(DeleteBlogRequest $request)
    {
        $data = $request->validated();
        Blog::where('uuid', $data['uuid'])->delete();
        return response()->json([
            'message' => 'Blog Deleted Successfully'
        ]);
    }
}
