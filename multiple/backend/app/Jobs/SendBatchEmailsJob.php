<?php

namespace App\Jobs;
namespace App\Jobs;

use App\Events\EmailSent;
use App\Models\SmtpAccount;
use Illuminate\Bus\Batch;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;

class SendBatchEmailsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function handle()
    {

    }
}
