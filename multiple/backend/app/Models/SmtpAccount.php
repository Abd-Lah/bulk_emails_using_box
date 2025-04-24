<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// app/Models/SmtpAccount.php

class SmtpAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'password',
        'host',
        'port',
        'encryption',
        'active'
        // other properties
    ];

    // other methods or relationships

    // Example constructor to initialize properties
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Initialize properties with default values if needed
        $this->email = $attributes['email'] ?? '';
        $this->password = $attributes['password'] ?? '';
        $this->host = $attributes['host'] ?? '';
        $this->port = $attributes['port'] ?? 0;
        // Initialize other properties if needed
    }
}
