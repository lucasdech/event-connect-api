<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class SearchUserCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        if (request()->has('search')) {
            $searchTerm = request()->get('search');
            $model = $model->where('name', 'like', '%' . $searchTerm . '%');
        }
        
        return $model;
    }
}

