<?php

namespace App\Livewire;

use App\Livewire\Forms\Email;
use Livewire\Component;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;
use Symfony\Component\Mime\Email as SymfonyEmail;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class ContentEditor extends Component
{
    public $fromName;
    public $fromEmail;
    public $recipients = [];
    public $subject;
    public $content;

    public Email $form;

    protected $rules = [
        'fromName' => 'required|string|max:255',
        'fromEmail' => 'required|email',
        'recipients' => 'required|array|min:1',
        'recipients.*' => 'email',
        'subject' => 'required|string|max:255',
        'content' => 'required',
    ];

    public function mount()
    {
        if(session('data')){
            $this->form = session()->get('data');
        }else {
            return $this->redirect('/', navigate: true);
        }
    }

    public function back(){
        session()->flash('data', $this->form);
        return $this->redirect('/', navigate: true);
    }

    public function sendEmail()
    {
        $this->validate();
        try {
            // Create transport
            $transport = new EsmtpTransport($this->form->host, $this->form->port);
            $transport->setUsername($this->form->email);
            $transport->setPassword($this->form->key);
            $transport->start();
            session()->flash('success', 'Transport connected successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Failed to connect transport: ' );
        }
        try {

            $mailer = new Mailer($transport);

            $email = (new SymfonyEmail())
                ->from(new Address($this->fromEmail, $this->fromName))
                ->subject($this->subject)
                ->html($this->content);

            foreach ($this->recipients as $recipient) {
                $email->addTo($recipient);
            }

            $mailer->send($email);

            session()->flash('success', 'Test email sent successfully!');
        } catch (TransportExceptionInterface $e) {
            session()->flash('error', 'Failed to send test email: ' . $e->getMessage());
        }
    }

    public function addRecipient()
    {
        $this->recipients[] = '';
    }

    public function removeRecipient($index)
    {
        unset($this->recipients[$index]);
        $this->recipients = array_values($this->recipients);
    }

    public function render()
    {
        return view('livewire.content-editor',$this->form);
    }
}
