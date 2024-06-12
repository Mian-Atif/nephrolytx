<?php

namespace App\Http\Responses\Backend\CptCodeInsurancePrices;

use Illuminate\Contracts\Support\Responsable;

class CreateResponse implements Responsable
{
    /**
     * To Response
     *
     * @param \App\Http\Requests\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function toResponse($request)
    {

        $user = Auth::user();
        $practice_id = $user->practice_id;
        $payers=DB::table('practice_payers')
            ->where('practice_id',$practice_id)
            ->get();
        return view('backend.cptcodeinsuranceprices.create',compact('payers'));
    }
}