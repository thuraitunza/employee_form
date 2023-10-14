<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function nrc(): BelongsTo
    {
        return $this->belongsTo(NRC::class);
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    public function educations(): HasMany
    {
        return $this->hasMany(Education::class);
    }

    public function postals(): HasMany
    {
        return $this->hasMany(Postal::class);
    }

    public function references(): HasMany
    {
        return $this->hasMany(Reference::class);
    }
}
