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

    public function mount()
    {
        if(session()->has('data'))
        {
            $this->form = session('data');
            session()->forget('data');
        }
    }

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
            session()->flash('success', 'Connected');
            session()->flash('data' ,$this->form);
            $transport->stop();
            return $this->redirect('/email-content', navigate: true);
        } catch (TransportExceptionInterface $e) {
            session()->flash('error', 'Connection failed !');
        }
    }

    public function render()
    {
        return view('livewire.email-form');
    }
}
