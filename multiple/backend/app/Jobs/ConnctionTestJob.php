<?php

namespace App\Jobs;

// ConnectionTestJob.php

namespace App\Jobs;

use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Mailer\Exception\TransportException;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;

// Corrected class name: ConnectionTestJob
class ConnctionTestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Batchable, SerializesModels;

    protected $account;

    public function __construct($account)
    {
        $this->account = $account;
    }

    public function handle()
    {
        try {
            $connect = new Mailer(Transport::fromDsn(sprintf(
                'smtp://%s:%s@%s:%s',
                urlencode($this->account->email),
                urlencode($this->account->password),
                $this->account->host,
                $this->account->port
            )));

            // Send a test email to check the connection
            $connect->send((new Email())->from($this->account->email)->to($this->account->email)->text('test'));

            // If the send is successful, update the account status
            $this->account->update(['active' => true]);
        } catch (TransportException $transportException) {
            // Log the error and update the account status
            Log::error('Error: ' . $transportException->getMessage());
            $this->account->update(['active' => false]);
        } catch (\Exception $exception) {
            // Log other exceptions
            Log::error('Error: ' . $exception->getMessage());
        }
    }
}



