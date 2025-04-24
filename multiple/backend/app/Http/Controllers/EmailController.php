<?php

namespace App\Http\Controllers;

use App\Jobs\ConnctionTestJob;
use App\Jobs\SendEmailJob;
use App\Models\Drop;
use App\Models\SmtpAccount;
use Illuminate\Http\Request;
use App\Events\EmailSent;
use App\Jobs\SendBatchEmailsJob;
use Illuminate\Support\Facades\Bus;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Log;


class EmailController extends Controller
{
    public function checkAvailableAccount()
    {
        $accounts = SmtpAccount::all();

        $jobs = [];

        foreach ($accounts as $account) {
            $jobs[] = new ConnctionTestJob($account);
        }

        // Dispatch the batch after adding all jobs
        Bus::batch($jobs)
            ->then(function (Batch $batch) {

            })
            ->name('CheckAccountBatch') // Set your desired name here
            ->onConnection('database') // Set your queue connection here
            ->onQueue('CheckAccount')
            ->dispatch();

        return [];
    }


    public function sendBatchEmails(Request $request)
    {
        $request->validate([
            'id' => 'sometimes',
            'data' => 'required|string',
            'start' => 'required|numeric',
            'end' => 'required|numeric',
            'rcpt' => 'sometimes',
            'subject' => 'required|string',
            'fromName' => 'required|string',
            'htmlContent' => 'required|string',
            'accountIdStart' => 'required|numeric',
            'accountIdEnd' => 'required|numeric',
        ]);

        if($request->input('rcpt') != '')
        {
            $drop = Drop::create([
                'status' => 'test',
                'data' => '',
                'from_name' => $request->input('fromName'),
                'subject' => $request->input('subject'),
                'html_content' => $request->input('htmlContent'),
                'range_acc' => '[ '.$request->input('smtpAccountStart') .' ---> ' .$request->input('smtpAccountEND').' ]',
                'range_email' => '',
            ]);
        }else {
            $drop = Drop::create([
                'status' => 'send',
                'data' => $request->input('data'),
                'from_name' => $request->input('fromName'),
                'subject' => $request->input('subject'),
                'html_content' => $request->input('htmlContent'),
                'range_acc' => '[ '.$request->input('smtpAccountStart') .' ---> ' .$request->input('smtpAccountEND').' ]',
                'range_email' => '[ '.$request->input('start') .' ---> ' .$request->input('end').' ]',
            ]);
        }
        try {
            $accounts = SmtpAccount::where('active', true)
                ->skip($request->input('accountIdStart'))
                ->take($request->input('accountIdEnd'))
                ->get();

            if (count($accounts) > 0) {
                $mail = $request->input('rcpt');
                $requestData = $request->all();
                $batch = [];
                foreach ($accounts as $account) {
                    // Add each SendEmailJob to the batch
                    $batch[] = new SendEmailJob($requestData, $account, $mail);
                }

                // Dispatch the batch of jobs
                Bus::batch($batch)
                ->name('EmailBatch'.$drop->id)
                ->onConnection('database')
                ->onQueue('email_jobs')
                ->dispatch();


            } else {
                Log::error('No account activated !!');
            }
        } catch (\Exception $e) {
            Log::error("Error dispatching email batch: {$e->getMessage()}");
            event(new EmailSent($e->getMessage(), 'error'));
        }

        return ['message' => 'Sending ...'];

    }
}
