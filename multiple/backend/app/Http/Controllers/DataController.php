<?php

namespace App\Http\Controllers;

use App\Models\Data;
use App\Models\Email;
use App\Models\SmtpAccount;
use Illuminate\Http\Request;
use App\Jobs\ProcessCsvFile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class DataController extends Controller
{
    public function get_data(){
        return Data::all();
    }
    public function get_data_emails(Request $request){
        $data = Data::find($request->input('id'));
        $emails = $data->emails()->paginate(8);
        return $emails;    }
    public function search_by_email(Request $request)
    {
        $email = $request->input('email');
        $user = Email::where('email', $email)->get();
        if($user){
            return response()->json($user);
        }else{
            return response()->json(['message' => 'not found']);
        }

    }

    public function uploadData(Request $request)
    {
        // Validate the request data
        $request->validate([
            'file' => 'required|file|mimes:csv,txt', // Adjust max file size as needed
            'id' => 'sometimes|exists:data,id',
            'name' => 'sometimes|string',
            'ispName' => 'sometimes|string',
        ]);

        // Process the request data
        $dataId = $request->input('id');
        $dataName = $request->input('name');
        $ispName = $request->input('ispName');
        $file = $request->file('file');

        // Store the file in a temporary location
        $filePath = Storage::putFileAs('temp', $file, 'temp.csv');

        // Create a new dataset if $dataId is not provided
        if (is_null($dataId)) {
            $newData = Data::create(['name' => $dataName, 'isp' => $ispName]);
            $dataId = $newData->id;
        }

        // Dispatch the job to handle the CSV upload in the background
        ProcessCsvFile::dispatch($dataId, $filePath)->onQueue('insert_data');

        // Return a success response
        return response()->json(['message' => 'Data upload process started.']);
    }

    public function dataCount(Request $request)
    {
        $dataId = $request->input('id');

        // Use eager loading to get the count of emails associated with the specified data ID
        $countData = Email::where('id_data', $dataId)->count();

        // Use caching for the count of active SMTP accounts
        $countSMTP = SmtpAccount::where('active', true)->count();

        return response()->json(['countData' => $countData, 'countSMTP' => $countSMTP]);
    }
    public function delete_email(Request $request)
    {
        $user = Email::findOrFail($request->input('id'));
        if($user){
            $user->delete();
            return response()->json($user);
        }else{
            return response()->json(['message' => 'User Not Found']);
        }

    }
}
