<?php

namespace App\Http\Controllers;

use App\Models\Models\Laraveltravel\Laraveltravel;
use Illuminate\Http\Request;

class LaraveltravelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $laraveltravel = LaravelTravel::all(); // 例として全てのレコードを取得
        return view('laraveltravel.index', compact('laraveltravel'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Laraveltravel $laraveltravel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Laraveltravel $laraveltravel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Laraveltravel $laraveltravel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Laraveltravel $laraveltravel)
    {
        //
    }
}
