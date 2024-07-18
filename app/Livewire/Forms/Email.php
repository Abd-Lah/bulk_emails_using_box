<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\Form;

class Email extends Form
{
    #[Rule('required|email')]
    public $email;
    #[Rule('required|min:8')]
    public $key;
    #[Rule('required|min:3')]
    public $host;
    #[Rule('required|numeric')]
    public $port;


}
