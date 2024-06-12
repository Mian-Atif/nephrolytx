<?php

namespace App\Listeners\Backend\Patient;

use App\Events\Backend\Patient\patient;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class patientListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  patient  $event
     * @return void
     */
    public function handle(patient $event)
    {
        //
    }
}
