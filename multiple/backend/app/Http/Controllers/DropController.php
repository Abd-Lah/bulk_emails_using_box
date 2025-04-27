<?php

namespace App\Http\Controllers;

use App\Models\Drop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DropController extends Controller
{
    //
    public function index(){
        $data = [];
        $drops = Drop::orderBy('created_at', 'desc')->get();
        foreach ($drops as $drop){
            $data[] = [
                'id' => $drop->id,
                'status' => $drop->status,
                'data' => $drop->data,
                'range_acc' => $drop->range_acc,
                'range_email' => $drop->range_email,
                'subject' => $drop->subject,
                'from_name' => $drop->from_name,
                'html_content' => $drop->html_content,
                'onQueue' => DB::table('jobs')->where('queue',$drop->id)->count(),
            ];
        }
        return $data;
    }
}
