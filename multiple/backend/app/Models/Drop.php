<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static orderBy(string $string, string $string1)
 */
class Drop extends Model
{
    use HasFactory;
    protected $fillable = [
        'status',
        'data',
        'range_acc',
        'range_email',
        'subject',
        'from_name',
        'html_content'
    ];

}
