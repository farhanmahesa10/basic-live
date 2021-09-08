<?php

namespace App\Http\Controllers;

use App\Models\Motivation;
use Illuminate\Http\Request;

class MotivationController extends Controller
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
        $motivation = Motivation::where('user_id',$userId)->orderBy('order','asc')->get();

        return response()->json($motivation);
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
        $order = 1;
        $lastOrder =Motivation::where('id',$request->user()->id)->orderBy('order','desc')->first();
        if($lastOrder){
            $order = $lastOrder->order + 1;
        }
        $stored = Motivation::create([
            'user_id' => $userId,
            'title' => $request->title,
            'content' => $request->content,
            'bg_color' => $request->bg_color,
            'order' => $order +1,
        ]);

        return response()->json([
            'message' => 'success',
            'data' => $stored
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Motivation  $motivation
     * @return \Illuminate\Http\Response
     */
    public function show(Motivation $motivation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Motivation  $motivation
     * @return \Illuminate\Http\Response
     */
    public function edit(Motivation $motivation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Motivation  $motivation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        $updated = Motivation::where('id',$request->id)->update([
            'title' => $request->title,
            'content' => $request->content,
            'bg_color' => $request->bg_color,
            
        ]);

        return response()->json([
            'message' => 'success',
        ]);
    }

    public function updateOrder(Request $request){
        // return response()->json($request);
      
        foreach($request->motivations as $motivation){
            Motivation::where('id',$motivation['id'])->update([
                'order' => $motivation['order']
            ]);
        }
        return response()->json([
            'message' => 'success'
        ]);
        try {
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'error',
                'error' => $e
            ]);
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Motivation  $motivation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        Motivation::where('id',$request->id)->delete();
        return response()->json([
            'message' => 'success',
        ]);
    }
    public function destroyUndo(Request $request)
    {
        //
        Motivation::withTrashed()->where('id',$request->id)->update([
            'deleted_at' => null
        ]);
        return response()->json([
            'message' => 'success',
        ]);
    }
}