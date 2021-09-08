<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
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
        return response()->json(Note::where('user_id',$userId)->orderByRaw("notes.order::int asc")->get());
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
        // return response()->json($request->content);
        $newOrder = 1;
        $userId = $request->user()->id;
       $latesOrder = Note::where('user_id',$userId)->orderByRaw("notes.order::int desc")->first();
       
       if($latesOrder){
           $newOrder = $latesOrder->order + 1;
       }
      
        $note = Note::create([
            'title' => $request->title,
            'content' => $request->content,
            'bg_color' => $request->bg_color,
            'user_id' => $userId,
            'order' => $newOrder
        ]);

        return response()->json($note);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function show(Note $note)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function edit(Note $note)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        Note::where('id',$request['id'])->update([
            'title' => $request['title'],
            'content' => $request['content'],
            'bg_color' => $request['bg_color'],
        ]);
        return response()->json([
            'message' => 'success'
        ]);
    }
    public function order(Request $request)
    {
        $data = $request->all();
        $i = 1;
        foreach ($data as $req) {
            Note::where('id',$req['id'])->update([
                'order' =>$i
            ]);
            $i++;
        };
       
        return response()->json($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        Note::where('id',$request->id)->delete();
        return response()->json([
            'message' => 'success'
        ]);
    }
    public function undoDestroy(Request $request){
        Note::withTrashed()->where('id',$request->id)->update([
            'deleted_at' => null
        ]);
        return response()->json([
            'message' => 'success'
        ]);
    }
}