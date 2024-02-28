<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use Inertia\Inertia;
use Carbon\Carbon;
class ContactController extends Controller
{
    public function loadDataTable()
    {
        $data = Contact::get();

        foreach ($data as $key => $value) {
            $value->create_time = Carbon::parse($value->created_at)->format('H:i , d/m/Y ');
            $value->update_time = Carbon::parse($value->updated_at)->format('H:i , d/m/Y ');
        }

        return response()->json(['data' => $data]);
    }
    function showIndex()
    {
        $jsonData = $this->loadDataTable()->getContent(); // Lấy nội dung JSON response
        $data = json_decode($jsonData, true)['data']; // Giải mã JSON và lấy giá trị của 'data'

        return Inertia::render('Contact/Show', ['data' => $data]);
    }
}
