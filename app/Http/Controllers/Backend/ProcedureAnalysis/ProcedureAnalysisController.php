<?php

namespace App\Http\Controllers\Backend\ProcedureAnalysis;

use App\Http\Controllers\Controller;
use App\Http\Responses\ViewResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProcedureAnalysisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $title='Procedure Analysis';
            $practice_id = Auth::user()->practice_id;
            $currentMonth = Carbon::now()->startOfMonth()->format('m/d/Y');
            $currentDate = Carbon::now()->format('m/d/Y');
            $frProcedures = DB::select("CALL fr_procedure_analysis($practice_id,$currentMonth,$currentDate)");
            $procedureAnalysis=collect($frProcedures)->groupBy('provider');
            $chargeTotal = collect($frProcedures)->sum('charges');
            $paymentTotal = collect($frProcedures)->sum('payments');
            $unitTotal = collect($frProcedures)->sum('units');
            return view('backend.procedureAnalysis.index', compact('title','procedureAnalysis','frProcedures', 'chargeTotal','unitTotal', 'paymentTotal', 'currentMonth', 'currentDate','frProcedures'));
        } catch (\Exception $e) {
//            return $this->respondInternalError($e->getMessage());
            return back();
        }
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
        try {
            $title='Procedure Analysis';
            $practice_id = Auth::user()->practice_id;
            $currentMonth = $request->get('dateStartfilter');
            $currentDate = $request->get('dateEndfilter');
            $frProcedures = DB::select('call fr_procedure_analysis(?,?,?)', array($practice_id, $currentMonth, $currentDate));
            $procedureAnalysis=collect($frProcedures)->groupBy('provider');
            $chargeTotal = collect($frProcedures)->sum('charges');
            $paymentTotal = collect($frProcedures)->sum('payments');
            $unitTotal = collect($frProcedures)->sum('units');
            $view = (string)view('backend.procedureAnalysis..partials.tableBody', compact('procedureAnalysis','frProcedures', 'chargeTotal','unitTotal', 'paymentTotal', 'currentMonth', 'currentDate','frProcedures'));
            $header=(string)view('backend.partials.financialReportsHeader',compact('title','currentDate','currentMonth'));

            return response()->json(['status' => true, 'view' => $view,'header' => $header]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);        }

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
