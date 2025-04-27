<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Email extends Model
{
    use HasFactory;

    protected $fillable = ['id_data', 'email','active'];

    public function data(): BelongsTo
    {
        return $this->belongsTo(Data::class,'id_data','id');
    }
}
