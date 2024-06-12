<?php

namespace App\Http\Controllers\Backend\Person;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Person\CreatePersonRequest;
use App\Http\Requests\Backend\Person\DeletePersonRequest;
use App\Http\Requests\Backend\Person\EditPersonRequest;
use App\Http\Requests\Backend\Person\ManagePersonRequest;
use App\Http\Requests\Backend\Person\StorePersonRequest;
use App\Http\Requests\Backend\Person\UpdatePersonRequest;
use App\Http\Responses\Backend\Person\EditResponse;
use App\Http\Responses\Backend\Person\ShowResponse;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Models\Person\Person;
use App\Repositories\Backend\Person\PersonRepository;

/**
 * Class PersonController.
 */
class PersonController extends Controller
{
    protected $person;

    /**
     * @param \App\Repositories\Backend\Person\PersonRepository $person
     */
    public function __construct(PersonRepository $person)
    {
        $this->person = $person;
    }

    /**
     * @param \App\Http\Requests\Backend\Person\ManagePersonRequest $request
     *
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManagePersonRequest $request)
    {

        return new ViewResponse('backend.person.index');
    }

    /**
     * @param \App\Http\Requests\Backend\Person\CreatePersonRequest $request
     *
     * @return \App\Http\Responses\ViewResponse
     */
    public function create(CreatePersonRequest $request)
    {
        return new ViewResponse('backend.person.create');
    }

    /**
     * @param \App\Http\Requests\Backend\Person\StorePersonRequest $request
     *
     * @return \App\Http\Responses\RedirectResponse
     */
    public function store(StorePersonRequest $request)
    {
        $this->person->create($request->except(['_token']));

        return new RedirectResponse(route('admin.person.index'), ['flash_success' => trans('alerts.backend.person.created')]);
    }

    /**
     * @param \App\Models\Person\Person                            $person
     * @param \App\Http\Requests\Backend\Person\EditPersonRequest $request
     *
     * @return \App\Http\Responses\Backend\Person\EditResponse
     */
    public function edit(Person $person, EditPersonRequest $request)
    {
        return new EditResponse($person);
    }

    /**
     * @param \App\Models\Person\Person                              $person
     * @param \App\Http\Requests\Backend\Person\UpdatePersonRequest $request
     *
     * @return \App\Http\Responses\RedirectResponse
     */
    public function update(Person $person, UpdatePersonRequest $request)
    {
        $this->person->update($person, $request->except(['_method', '_token']));

        return new RedirectResponse(route('admin.person.index'), ['flash_success' => trans('alerts.backend.person.updated')]);
    }

    /**
     * @param \App\Models\Person\Person                              $person
     * @param \App\Http\Requests\Backend\Person\DeletePersonRequest $request
     *
     * @return \App\Http\Responses\RedirectResponse
     */
    public function destroy(Person $person, DeletePersonRequest $request)
    {
        $this->person->delete($person);

        return new RedirectResponse(route('admin.person.index'), ['flash_success' => trans('alerts.backend.person.deleted')]);
    }

    public function show(Person $person){
        return new ShowResponse($person);

    }
}
