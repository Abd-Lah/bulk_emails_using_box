<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Data extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'isp'];

    public function emails(): HasMany
    {
        return $this->hasMany(Email::class, 'id_data');
    }
}
