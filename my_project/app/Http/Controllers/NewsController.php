<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function add()
    {
        return view('news.add');
    }

    public function store(Request $request)
    {
        $news = new News();
        $news->title = $request->input('title');
        $news->description = $request->input('description');
        $news->content = $request->input('content');
        if ($news->save()) {
            return redirect()->route('news.list');
        } else {
            return redirect()->route('news.add');
        }
    }

    public function show($id)
    {
        $news = News::findOrFail($id);
        return view('news.show', ['news' => $news]);

    }

    public function list()
    {
        $newsList = News::all();
        return view('news.list', ['newsList' => $newsList]);
    }

    public function edit($id)
    {
        $news = News::findOrFail($id);
        return view('news.edit', ['news' => $news]);
    }

    public function update(Request $request, $id)
    {
        $news = News::findOrFail($id);
        $news->update($request->all());

        return redirect('/news/list')->with('success', 'Tin tức đã được cập nhật!');
    }

    public function destroy($id)
    {
        $news = News::findOrFail($id);
        $news->delete();

        return redirect('/news/list')->with('success', 'Tin tức đã được xóa!');
    }

}
