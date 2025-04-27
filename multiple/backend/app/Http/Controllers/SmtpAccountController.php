<?php
// app/Http/Controllers/SmtpAccountController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SmtpAccount;

class SmtpAccountController extends Controller
{
    public function index()
    {
        $accounts = SmtpAccount::all();
        return response()->json($accounts);
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:smtp_accounts',
            'password' => 'required',
            'encryption' => 'required',
            'host' => 'required',
            'port' => 'required',
        ]);

        SmtpAccount::create([
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'encryption' => $request->input('encryption'),
            'host' => $request->input('host'),
            'port' => $request->input('port'),
            'active' => true
        ]);

        return response()->json(['message' => 'SMTP account added successfully']);
    }

    public function getUser($id){
        $accounts = SmtpAccount::findOrFail($id);
        return response()->json($accounts);
    }

    public function update(Request $request,$id)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $account = SmtpAccount::where('id',$id)->first();
        if ($account) {
            if ($request->input('email') == $account->email) {
                $account->update([
                    'password' => $request->input('password')
                ]);
                return response()->json(['message' => 'account updated successfully']);
            } else {
                $request->validate([
                    'email' => 'unique:smtp_accounts',
                ]);
                $account->update([
                    'email' => $request->input('email'),
                    'password' => $request->input('password')
                ]);
                return response()->json(['message' => 'account updated successfully']);
            }
        }

    }

    public function delete($id)
    {
        $account = SmtpAccount::where('id',$id)->first();
        if ($account)
        {
            $account->delete();
            return  response()->json(['message' => 'account deleted successfully']);
        }
        else{
            return  response()->json(['message' => 'account not found,may already deleted!']);
        }

    }

        public function enable(Request $request,$id){
        $request->validate([
            'active' => 'required|boolean'
        ]);
        SmtpAccount::findOrfail($id)->update([
            'active' => $request->input('active')
        ]);
        return [];
    }
}
