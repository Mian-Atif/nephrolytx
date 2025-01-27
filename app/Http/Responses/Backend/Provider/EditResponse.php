<?php

namespace App\Http\Responses\Backend\Provider;

use Illuminate\Contracts\Support\Responsable;

class EditResponse implements Responsable
{
    /**
     * @var App\Models\Provider\Provider
     */
    protected $providers;

    /**
     * @param App\Models\Provider\Provider $providers
     */
    public function __construct($providers)
    {
        $this->providers = $providers;
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
        return view('backend.providers.edit')->with([
            'providers' => $this->providers
        ]);
    }
}