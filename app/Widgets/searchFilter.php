<?php

namespace App\Widgets;

use App\Models\Practice\Practice;
use Arrilot\Widgets\AbstractWidget;
use Illuminate\Support\Facades\Auth;

class searchFilter extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [

    ];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        try {
            $user = Auth::user();
            $practice_id = $user->practice_id;

            $payers=DB::table('practice_payers')
                ->where('practice_id',$practice_id)
                ->get();

            if ($user->roles()->first()->name == 'Practice User') {
                $person = $user->person;
                $providers = $person->doctors;
                $locations = $person->locations;

            } else {
                $practice = Practice::find($practice_id);
                $providers = $practice->getDotorsdata;
                $locations = $practice->getLocationdata;

            }

            return view('widgets.search_filter', compact('practice', 'providers',
                'locations','payers'));
        }
        catch (\Exception $e) {
            return back();
        }
    }
}
