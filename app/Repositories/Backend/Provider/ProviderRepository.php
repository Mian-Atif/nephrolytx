<?php

namespace App\Repositories\Backend\Provider;

use DB;
use Carbon\Carbon;
use App\Models\Provider\Provider;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProviderRepository.
 */
class ProviderRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Provider::class;

    /**
     * This method is used by Table Controller
     * For getting the table data to show in
     * the grid
     * @return mixed
     */
    public function getForDataTable()
    {
        return $this->query()
            ->select([
                config('module.providers.table').'.id',
                config('module.providers.table').'.created_at',
                config('module.providers.table').'.updated_at',
            ]);
    }

    /**
     * For Creating the respective model in storage
     *
     * @param array $input
     * @throws GeneralException
     * @return bool
     */
    public function create(array $input)
    {
        if (Provider::create($input)) {
            return true;
        }
        throw new GeneralException(trans('exceptions.backend.providers.create_error'));
    }

    /**
     * For updating the respective Model in storage
     *
     * @param Provider $provider
     * @param  $input
     * @throws GeneralException
     * return bool
     */
    public function update(Provider $provider, array $input)
    {
    	if ($provider->update($input))
            return true;

        throw new GeneralException(trans('exceptions.backend.providers.update_error'));
    }

    /**
     * For deleting the respective model from storage
     *
     * @param Provider $provider
     * @throws GeneralException
     * @return bool
     */
    public function delete(Provider $provider)
    {
        if ($provider->delete()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.providers.delete_error'));
    }
}
