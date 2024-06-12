<?php

namespace App\Http\Responses\Backend\BillingManager;

use Illuminate\Contracts\Support\Responsable;

class EditResponse implements Responsable
{
    /**
     * @var App\Models\BillingManager\BillingManager
     */
    protected $billingmanagers;

    /**
     * @param App\Models\BillingManager\BillingManager $billingmanagers
     */
    public function __construct($billingmanagers)
    {
        $this->billingmanagers = $billingmanagers;
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
        return view('backend.billingmanagers.edit')->with([
            'billingmanagers' => $this->billingmanagers
        ]);
    }
}