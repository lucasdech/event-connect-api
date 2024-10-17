<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\EventRepository;
use App\Models\Event;
use App\Validators\EventValidator;

/**
 * Class EventRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class EventRepositoryEloquent extends BaseRepository implements EventRepository
{

    protected $fieldSearchable = [
        'title',
        'location',
    ];
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Event::class;
    }

    /**
     * Use Validator
     */
    public function validator()
    {
        return EventValidator::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
