<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Diary;
use App\Http\Requests\DiaryRequest;

class DiaryController extends Controller
{
    public function index()
    {
        $diaries = Diary::all();

        return view('diaries.index', compact('diaries'));
    }

    public function create()
    {
        return view('diaries.create');
    }

    public function store(DiaryRequest $request)
    {
        Diary::create([
            'title' => $request->title,
            'body' => $request->body,
        ]);

        return redirect()->route('diary.index');
    }
}
