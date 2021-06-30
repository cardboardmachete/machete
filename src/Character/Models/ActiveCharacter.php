<?php

namespace Machete\Character\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ActiveCharacter extends Character
{
    /**
     * Manually set the table to match what the parent
     * model's table is. Otherwise Eloquent tries to
     * do "magic" and get the `active_characters` table.
     */
    protected $table = 'characters';

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope(function (Builder $query) {
            $query->where('is_active', true)
                ->whereHas('account', function (Builder $query) {
                    $query->where('id', Auth::id());
                });
        });
    }
}
