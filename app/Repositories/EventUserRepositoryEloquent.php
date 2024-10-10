<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\EventUserRepository;
use App\Models\EventUser;
use App\Validators\EventUserValidator;

/**
 * Class EventUserRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class EventUserRepositoryEloquent extends BaseRepository implements EventUserRepository
{

    protected $fieldSearchable = [
        'participations.event.title',
        'participations.event.location',
        'participations.event.starting_at'
    ];
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return EventUser::class;
    }

    /**
     * Use Validator
     */
    public function validator()
    {
        return EventUserValidator::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
