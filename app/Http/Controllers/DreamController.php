<?php

namespace App\Http\Controllers;

use App\Models\Dream;
use App\Models\Todolist;
use Illuminate\Http\Request;

class DreamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $userId = $request->user()->id;
        $dream = Dream::where('user_id',$userId)->orderBy('id','desc')->get();
        return response()->json($dream);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $userId = $request->user()->id;
        $dream = Dream::create([
            'dream' => $request->dreamInput,
            'user_id' => $userId
        ]);
        return response()->json($dream);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Dream  $dream
     * @return \Illuminate\Http\Response
     */
    public function show(Dream $dream)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Dream  $dream
     * @return \Illuminate\Http\Response
     */
    public function edit(Dream $dream)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Dream  $dream
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dream  $dream
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Todolist::where('dream_id',$request->dreamId)->delete();
        Dream::where('id',$request->dreamId)->delete();
        
        return response()->json([
            'message' => 'success'
        ]);
    }

    public function destroyUndo(Request $request)
    {
        Dream::withTrashed()->where('id',$request->dreamId)->update([
            'deleted_at' => null
        ]);
        Todolist::withTrashed()->where('dream_id',$request->dreamId)->update([
            'deleted_at' => null
        ]);
        
        return response()->json([
            'message' => 'success'
        ]);
    }
}