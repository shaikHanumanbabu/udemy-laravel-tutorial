<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Query\Builder;

class LatestScope implements Scope
{
    public function apply(EloquentBuilder $builder, Model $model)
    {
        $builder->orderBy($model::CREATED_AT, 'desc');
    }
}
