<?php

// SendSingleEmailJob.php
// SendSingleEmailJob.php

namespace App\Jobs;

use App\Events\EmailSent;
use App\Models\SmtpAccount;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Mailer\Exception\TransportException;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Batchable, SerializesModels;

    public $requestData;
    public $account;
    public $mail;

    public function __construct($requestData, $account, $mail)
    {
        $this->requestData = $requestData;
        $this->account = $account;
        $this->mail = $mail;
    }

    public function handle()
    {
        $transport = Transport::fromDsn(sprintf(
            'smtp://%s:%s@%s:%s',
            urlencode($this->account->email),
            urlencode($this->account->password),
            $this->account->host,
            $this->account->port
        ));

        $email = (new Email())
            ->from(new Address($this->account->email, $this->requestData['fromName']))
            ->to($this->mail)
            ->priority(Email::PRIORITY_HIGH)
            ->subject($this->requestData['subject'])
            ->html($this->requestData['htmlContent']);

        try {
            $transport->send($email);
            event(new EmailSent('an email sent', 'success'));
        } catch (TransportException $transportException) {
            Log::error('Email sending failed: ' . $transportException->getMessage());
            event(new EmailSent($this->account->username, 'failed'));
        } catch (\Exception $exception) {
            Log::error('Email sending failed: ' . $exception->getMessage());
            event(new EmailSent($this->account->username, 'failed'));
        }
    }
}

