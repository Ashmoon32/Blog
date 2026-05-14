<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ArticleController extends Controller
{
    public function index()
    {
        // return "Controller - Article List";
        // return view('articles/index');

        // $data = [
        //     ["id" => 1, "title" => "First Article"],
        //     ["id" => 2, "title" => "Second Article"],
        // ];

        // return view('articles.index', [
        //     'articles' => $data
        // ]);

        // $data = Article::all();

        // return view('articles.index', [
        //     'articles' => $data
        // ]);

        $data = Article::latest()->paginate(5);

        return view('articles.index', [
            'articles' => $data
        ]);
    }

    public function detail($id)
    {
        $data = Article::find($id);
        return view('articles.detail', [
            'article' => $data
        ]);

    }

    public function info($boldText)
    {
        return "Controller - Article Info - <b>$boldText!</b>";
    }

    public function add()
    {
        // no more hardcode
        // $data = [
        //     ["id" => 1, "name" => "News"],
        //     ["id" => 2, "name" => "Tech"],
        //     ["id" => 3, "name" => "Personal"],
        // ];



        $data = Category::all();

        return view('articles.add', [
            'categories' => $data
        ]);
    }

    public function create()
    {
        $validator = validator(request()->all(), [
            'title' => 'required',
            'body' => 'required',
            'category_id' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $article = new Article;
        $article->title = request()->title;
        $article->body = request()->body;
        $article->category_id = request()->category_id;
        $article->user_id = auth()->user()->id;
        $article->save();

        return redirect('/articles')->with('info', 'Article created');
    }

    public function delete($id)
    {
        $article = Article::findOrFail($id);
        if (Gate::denies('article-delete', $article)) {
            return back()->with('error', 'Unauthorize');
        }
        $article->delete();
        return redirect('/articles')->with('info', 'Article deleted');
    }

    public function edit($id)
    {
        $articles = Article::findOrFail($id);
        $categories = Category::all();
        return view('articles.edit', [
            'article' => $articles,
            'categories' => $categories
        ]);
    }

    public function update($id)
    {

        $article = Article::findOrFail($id);

        if (Gate::denies('article-update', $article)) {
            return back()->withErrors('Unauthorize');
        }

        $validator = validator(request()->all(), [
            'title' => 'required',
            'body' => 'required',
            'category_id' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $article->update([
            'title' => request()->title,
            'body' => request()->body,
            'category_id' => request()->category_id
        ]);

        return redirect("/articles/detail/$id")->with('info', 'Article updated');

    }

    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'detail']);
    }
}
