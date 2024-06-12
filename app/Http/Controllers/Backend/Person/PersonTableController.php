<?php

namespace App\Http\Controllers\Backend\Person;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Person\ManagePersonRequest;
use App\Repositories\Backend\Person\PersonRepository;
use Yajra\DataTables\Facades\DataTables;

/**
 * Class PersonTableController.
 */
class PersonTableController extends Controller
{
    protected $person;

    /**
     * @param PersonRepository $person
     */
    public function __construct(PersonRepository $person)
    {
        $this->person = $person;
    }

    /**
     * @param ManagePersonRequest $request
     *
     * @return mixed
     */

    public function __invoke(ManagePersonRequest $request)
    {
        return Datatables::of($this->person->getForDataTable())
            ->addColumn('middle_name', function ($person) {
                return $person->middle_name;
            })
            ->addColumn('email', function ($person) {
                return $person->email;
            })
            ->addColumn('phone', function ($person) {
                return $person->phone;
            })
            ->addColumn('address1', function ($person) {
                return $person->address1;
            })
            ->addColumn('address2', function ($person) {
                return $person->address2;
            })
          /*  ->addColumn('created_at', function ($person) {
                return $person->created_at->toDateString();
            })*/
            ->addColumn('actions', function ($person) {
                return $person->action_buttons;
            })
            ->rawColumns(['actions', 'action','action_buttons'])
            ->make(true);
    }
}
