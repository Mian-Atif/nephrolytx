<?php

namespace App\Http\Responses\Backend\CptCodeInsurancePrices;

use Illuminate\Contracts\Support\Responsable;

class EditResponse implements Responsable
{
    /**
     * @var App\Models\CptCodeInsurancePrices\CptCodeInsurancePrice
     */
    protected $cptcodeinsuranceprices;

    /**
     * @param App\Models\CptCodeInsurancePrices\CptCodeInsurancePrice $cptcodeinsuranceprices
     */
    public function __construct($cptcodeinsuranceprices)
    {
        $this->cptcodeinsuranceprices = $cptcodeinsuranceprices;
    }

    /**
     * To Response
     *
     * @param \App\Http\Requests\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function toResponse($request)
    {
        return view('backend.cptcodeinsuranceprices.edit')->with([
            'cptcodeinsuranceprices' => $this->cptcodeinsuranceprices
        ]);
    }
}