<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class SearchUserCriteria.
 *
 * @package namespace App\Criteria;
 */
class SearchUserCriteria implements CriteriaInterface
{
 /**
     * Apply criteria in query repository
     *
     * @param \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->where('name', 'LIKE', '%' . request()->get('search') . '%');
        return $model;
    }
}
