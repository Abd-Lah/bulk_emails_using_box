<?php

namespace App\Jobs;

use App\Models\Email;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProcessCsvFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $dataId;
    protected $filePath;

    public function __construct($dataId, $filePath)
    {
        $this->dataId = $dataId;
        $this->filePath = $filePath;
    }

    public function handle()
    {
        try {
            $file = new \SplFileObject(Storage::path($this->filePath));
            $emails = [];

            while (!$file->eof()) {
                $row = $file->fgetcsv();

                if ($row === false) {
                    continue; // Skip empty lines
                }

                foreach ($row as $email) {
                    if (str_contains($email, "@")) {
                        $emails[] = [
                            'id_data' => $this->dataId,
                            'email' => $email,
                            'active' => false,
                            'created_at' => now(),
                            'updated_at' => null,
                        ];
                    }
                }

                // Insert emails in batches of 1000
                if (count($emails) >= 1000) {
                    $this->insertEmails($emails);
                    $emails = [];
                }
            }

            // Insert any remaining emails
            if (!empty($emails)) {
                $this->insertEmails($emails);
            }

            Log::info('ProcessCsvFile job completed successfully.');
        } catch (\Exception $exception) {
            Log::error('Error processing ProcessCsvFile job: ' . $exception->getMessage());
        }
    }

    private function insertEmails(array $emails)
    {
        Email::insert($emails);
    }
}
