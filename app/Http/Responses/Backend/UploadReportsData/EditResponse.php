<?php

namespace App\Http\Responses\Backend\UploadReportsData;

use Illuminate\Contracts\Support\Responsable;

class EditResponse implements Responsable
{
    /**
     * @var App\Models\UploadReportsData\UploadReportsDatum
     */
    protected $uploadreportsdata;

    /**
     * @param App\Models\UploadReportsData\UploadReportsDatum $uploadreportsdata
     */
    public function __construct($uploadreportsdata)
    {
        $this->uploadreportsdata = $uploadreportsdata;
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
        return view('backend.uploadreportsdata.edit')->with([
            'uploadreportsdata' => $this->uploadreportsdata
        ]);
    }
}