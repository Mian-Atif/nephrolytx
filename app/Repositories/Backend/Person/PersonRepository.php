<?php

namespace App\Repositories\Backend\Person;

use App\Events\Backend\Person\PersonCreated;
use App\Events\Backend\Person\PersonDeleted;
use App\Events\Backend\Person\PersonUpdated;
use App\Exceptions\GeneralException;
use App\Models\Person\Person;
use App\Repositories\BaseRepository;
use Illuminate\Support\Str;

/**
 * Class PersonRepository.
 */
class PersonRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Person::class;

    /**
     * @return mixed
     */
    public function getAll($order_by = 'sort', $sort = 'asc')
    {
        return $this->query()

            ->get();
    }
    public function getForDataTable()
    {
        return $this->query()
            ->leftjoin(config('access.users_table'),
                config('access.users_table').'.person_id', '=', config('module.person.table').'.id')
            ->select([
                config('module.person.table').'.id',
                config('module.person.table').'.middle_name',
                config('module.person.table').'.email',
                config('module.person.table').'.phone',
                config('module.person.table').'.address1',
                config('module.person.table').'.address2',
                config('module.person.table').'.created_at',
                config('module.person.table').'.updated_at',
            ]);
    }

    /**
     * @param array $input
     *
     * @throws \App\Exceptions\GeneralException
     *
     * @return bool
     */
    public function create(array $input)
    {
        if ($this->query()->where('email', $input['email'])->first()) {
            throw new GeneralException(trans('exceptions.backend.person.already_exists'));
        }

        if ($person = Person::create($input)) {
            event(new PersonCreated($person));

            return $person;
        }

        throw new GeneralException(trans('exceptions.backend.person.create_error'));
    }

    /**
     * @param \App\Models\Person\Person $person
     * @param array                 $input
     *
     * @throws \App\Exceptions\GeneralException
     *
     * @return bool
     */
    public function update($person, array $input)
    {
        if ($person->update($input)) {
            event(new PersonUpdated($person));

            return true;
        }

        throw new GeneralException(trans('exceptions.backend.person.update_error'));
    }

    /**
     * @param \App\Models\Person\Person $person
     *
     * @throws \App\Exceptions\GeneralException
     *
     * @return bool
     */
    public function delete($person)
    {
        if ($person->delete()) {
            event(new PersonDeleted($person));

            return true;
        }

        throw new GeneralException(trans('exceptions.backend.person.delete_error'));
    }
}
