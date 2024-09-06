<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ForbiddenWordRepository;
use App\Models\ForbiddenWord;
use App\Validators\ForbiddenWordValidator;

/**
 * Class ForbiddenWordRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ForbiddenWordRepositoryEloquent extends BaseRepository implements ForbiddenWordRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ForbiddenWord::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
