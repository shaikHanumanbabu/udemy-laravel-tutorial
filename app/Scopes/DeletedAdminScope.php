<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;

class DeletedAdminScope implements Scope
{
    public function apply(EloquentBuilder $builder, Model $model)
    {
        if(Auth::check() && Auth::user()->is_admin) {
            $builder->withTrashed();
        }
    }
}
