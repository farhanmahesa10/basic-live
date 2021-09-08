<?php

namespace App\Http\Controllers;

use App\Models\Finance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class FinanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        // return response()->json( request()->sort);
        $userId = $request->user()->id;
        $sorting = request()->sort;
        $sortingValue = request()->sortingValue;
        $type = request()->type;
        $grafik =[];
        if($sorting == 'week'){
            $req = explode(',',$request->sortingValue);
            $monthYear = $req[0];
            $week = $req[1];
            
            $startOfWeek = Carbon::createFromFormat('Y-m-d',$monthYear.'-01')->addWeeks($week)->startOfWeek()->format('Y-m-d');
            $endOfWeek = Carbon::createFromFormat('Y-m-d',$monthYear.'-01')->addWeeks($week)->endOfWeek()->format('Y-m-d');
            $finance = Finance::where('user_id',$userId)->where('type',$type)->whereBetween('date', [$startOfWeek, $endOfWeek])->orderBy('id','desc')->paginate(10);
            $total =  Finance::where('user_id',$userId)->select('amount')->where('type',$type)->whereBetween('date', [$startOfWeek, $endOfWeek])->sum('amount');
        }elseif($sorting == 'month' || $sorting == 'year'){
            $req = explode('-',$request->sortingValue);
            $year = $req[0];
            $month = $req[1];
            $finance = Finance::where('user_id',$userId)->where('type',$type)->where('date','like',$sortingValue.'%')->orderBy('id','desc')->paginate(10);
            $total =  Finance::where('user_id',$userId)->select('amount')->where('type',$type)->where('date','like',$sortingValue.'%')->sum('amount');
            if($sorting == 'month'){
                $grafik = Finance::select(DB::raw("sum(amount) as amount,  EXTRACT(YEAR FROM finances.date) as years, EXTRACT(MONTH FROM finances.date) as months"))
                ->where('user_id',$userId)->where('type',$type)
                ->groupBy('months','years')
                ->get();
                $label = ['January','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
                $value = [0,0,0,0,0,0,0,0,0,0,0,0];
                
                foreach($grafik as $graf){
                    $value[$graf['months'] - 1] = $graf['amount'];
                }
                $grafik = [
                    'label' => $label,
                    'value' => $value
                ];
           }
        }else{
            $finance = Finance::where('user_id',$userId)->where('type',$type)->where('date', $sortingValue)->orderBy('id','desc')->paginate(10);
            $total =  Finance::where('user_id',$userId)->select('amount')->where('type',$type)->where('date', $sortingValue)->sum('amount');
        }
        
        return response()->json([
            'finance' => $finance,
            'total' => $total,
            'grafik' => $grafik
        ]);
    }
      
    public function totalallamount()
    {
        //
        $type = request()->type;
        $incomes = Finance::select('amount')->where('type',$type)->sum('amount');
        return response()->json($incomes);
    }
    public function sortByDate($condition)
    {
        //
        $incomes = Finance::where('type',1)->orderBy('id','desc')->paginate(10);
        return response()->json($incomes);
    }
    public function sortByWeek($condition)
    {
        //
        $incomes = Finance::where('type',1)->orderBy('id','desc')->paginate(10);
        return response()->json($incomes);
    }
    public function sortByYear($condition)
    {
        //
        $incomes = Finance::where('type',1)->orderBy('id','desc')->paginate(10);
        return response()->json($incomes);
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
        try {
           $finance = Finance::create([
               'type' => $request->type,
               'desc' => $request->desc,
               'amount' => $request->amount,
               'date' => $request->date,
               'user_id' => 1
           ]);
           return response()->json($finance);
        } catch (\Exception $e) {
            return response()->json($e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Finance  $finance
     * @return \Illuminate\Http\Response
     */
    public function show(Finance $finance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Finance  $finance
     * @return \Illuminate\Http\Response
     */
    public function edit(Finance $finance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Finance  $finance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        try{
            Finance::where('id',$request->id)->update([
                'type' => $request->type,
                'desc' => $request->desc,
                'amount' => $request->amount,
                'date' => $request->date,
                'user_id' => 1
            ]);
        } catch (\Exception $e) {
            return response()->json($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Finance  $finance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        try {
            
            Finance::where('id',$request->id)->delete();
         } catch (\Exception $e) {
             return response()->json($e);
         }
    }
    public function destroyUndo(Request $request)
    {
        //
        try {
            Finance::withTrashed()->where('id',$request->id)->update([
                'deleted_at' => null
            ]);
         } catch (\Exception $e) {
             return response()->json($e);
         }
    }
}