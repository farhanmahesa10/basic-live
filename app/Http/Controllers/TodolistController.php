<?php

namespace App\Http\Controllers;

use App\Models\Todolist;
use Illuminate\Http\Request;

class TodolistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $todolist = Todolist::orderBy('status','asc')->get();
        return response()->json($todolist);
    }

    public function getbydream($dreamid)
    {
        //
        $todolist = Todolist::where('dream_id',$dreamid)->orderBy('order','asc')->get();
        return response()->json($todolist);
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
        $lastList = Todolist::where('status','1')->orderBy('order','desc')->first();
        $order = 1;
        if($lastList){
            $order = $lastList->order + 1;
        }
       try {
       $todo =  Todolist::create([
            'title' => $request->title,
            'todo' => $request->content,
            'status' => 1,
            'bg_color' => $request->bg_color,
            'dream_id' => $request->dream_id,
            'order' => $order
        ]);

        return response()->json([
            'status' => 'success',
            'todo' => $todo
        ]);
       } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e
        ]);
       }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Todolist  $todolist
     * @return \Illuminate\Http\Response
     */
    public function show(Todolist $todolist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Todolist  $todolist
     * @return \Illuminate\Http\Response
     */
    public function edit(Todolist $todolist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Todolist  $todolist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Todolist $todolist)
    {
        //
        
        try{
        Todolist::where('id',$request->id)->update([
            'title' => $request->title,
            'todo' => $request->content,
            'status' => 1,
            'bg_color' => $request->bg_color,
            'dream_id' => $request->dream_id,
            'order' => $request->order
        ]);
        return response()->json([
            'status' => 'success',
            'todo' => $todo
        ]);
       } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e
        ]);
       }
    }

    public function updateOrder(Request $request)
    {
        //
        try {
            foreach($request->list as $list){
                Todolist::where('id',$list['id'])->update([
                    'status' => 1,
                    'order' => $list['order']
                ]);
            }
            foreach($request->process as $process){
                Todolist::where('id',$process['id'])->update([
                    'status' => 2,
                    'order' => $process['order']
                ]);
            }
            foreach($request->done as $done){
                Todolist::where('id',$done['id'])->update([
                    'status' => 3,
                    'order' => $done['order']
                ]);
            }

            return response()->json([
                'message' => 'success'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Todolist  $todolist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        Todolist::where('id',$request->id)->delete();
    }
    public function destroyUndo(Request $request)
    {
        //
        Todolist::withTrashed()->where('id',$request->id)->update([
            'deleted_at' => null
        ]);
    }
}