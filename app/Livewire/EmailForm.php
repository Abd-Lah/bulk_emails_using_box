<?php

namespace App\Livewire;

use Livewire\Component;
use App\Livewire\Forms\Email;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class EmailForm extends Component
{
    public Email $form;

    protected $rules = [
        'form.host' => 'required|string',
        'form.port' => 'required|integer|min:1',
        'form.email' => 'required|email',
        'form.key' => 'required|string',
    ];
    


    public function check_account()
    {
        $this->validate();

        try {

            // Create transport
            $transport = new EsmtpTransport($this->form->host, $this->form->port);
            $transport->setUsername($this->form->email);
            $transport->setPassword($this->form->key);

            // Attempt to connect and EHLO/HELO the server
            $transport->start();

            // Dispatch event to create transport in ContentEditor component
            $this->dispatch('create-transport', $this->form->all());

            session()->flash('success', 'Connection successful!');

        } catch (TransportExceptionInterface $e) {
            session()->flash('error', 'Connection failed: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.email-form');
    }
}
