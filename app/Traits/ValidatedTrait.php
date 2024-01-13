<?php

namespace App\Traits;

use App\Enums\ValidationStatus;
use Illuminate\Database\Eloquent\Builder;


trait ValidatedTrait
{
    public function scopeValidated(Builder $query)
    {
        return $query->whereRelation("validations", "status", ValidationStatus::VALIDATED);
        // return $query->whereHas('validations', function ($subQuery) {
        //     $subQuery->where('status', ValidationStatus::VALIDATED)->whereNotNull('validated_at');
        // });
    }
}
