<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait Uuid
{
    /**
     * Boot Uuid.
     */
    public static function bootUuid()
    {
        static::creating(function (Model $model) {
            $model->setAttribute($model->getUuidField(), Str::uuid()->toString());

            return true;
        });
    }

    public function getUuidField(): string
    {
        return 'uuid';
    }

    /**
     * @return Builder
     */
    public function scopeUuid(Builder $builder, string $uuid)
    {
        return $builder->where($this->getUuidField(), $uuid);
    }
}
