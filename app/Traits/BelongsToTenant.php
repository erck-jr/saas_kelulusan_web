<?php

namespace App\Traits;

use App\Models\School;
use Illuminate\Database\Eloquent\Builder;

trait BelongsToTenant
{
    /**
     * Boot the trait to apply tenant global scope and automatic school_id assignment.
     */
    protected static function bootBelongsToTenant()
    {
        // Automatically filter queries by school_id when active school is set
        static::addGlobalScope('tenant', function (Builder $builder) {
            if (app()->bound('current_school') && !(auth()->check() && auth()->user()->role === 'superadmin')) {
                $builder->where($builder->getQuery()->from . '.school_id', app('current_school')->id);
            }
        });

        // Automatically assign school_id when creating new records
        static::creating(function ($model) {
            if (app()->bound('current_school') && empty($model->school_id)) {
                $model->school_id = app('current_school')->id;
            }
        });
    }

    /**
     * Get the school that owns the model.
     */
    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
