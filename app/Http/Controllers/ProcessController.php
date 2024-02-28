<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Process;
use Inertia\Inertia;
use Carbon\Carbon;

class ProcessController extends Controller
{
    public function loadDataTable()
    {
        $data = Process::get();

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

        return Inertia::render('Process/Show', ['data' => $data]);
    }
    function create(Request $rq)
    {
        $tb = 'processes';
        $data = [];

        if (!$rq->url_avatar) {
            return response()->json(['error' => 'Vui lòng chọn ảnh đại diện', 'column' => 'url_avatar']);
        } else {
            $data['url_avatar'] = $rq->url_avatar;
        }

        if (!$rq->url_avatar_mobile) {
            $data['url_avatar_mobile'] = $rq->url_avatar;
        } else {
            $data['url_avatar_mobile'] = $rq->url_avatar_mobile;
        }

        if (!$rq->name) {
            return response()->json(['error' => 'Vui lòng nhập tên dữ liệu', 'column' => 'name']);
        } else {
            $data['name'] = $rq->name;
        }

        if (!$rq->desc) {
            return response()->json(['error' => 'Vui lòng nhập mô tả dữ liệu', 'column' => 'desc']);
        } else {
            $data['desc'] = $rq->desc;
        }

        Process::create($data);

        return response()->json(['success' => 'Cập nhập dữ liệu thành công']);
    }
    function showEdit($id)
    {
        $data = Process::find($id);

        return Inertia::render('Process/Edit', ['data' => $data]);
    }

    function update(Request $rq, $id)
    {
        $tb = 'processes';
        $data = [];
        if (!$id) {
            return response()->json(['error' => 'Có lỗi xảy ra, không cập nhập được slug, hãy load lại trang', 'column' => 'slug']);
        }
        if (!$rq->url_avatar) {
            return response()->json(['error' => 'Vui lòng chọn ảnh đại diện', 'column' => 'url_avatar']);
        } else {
            $data['url_avatar'] = $rq->url_avatar;
        }

        if (!$rq->url_avatar_mobile) {
            $data['url_avatar_mobile'] = $rq->url_avatar;
        } else {
            $data['url_avatar_mobile'] = $rq->url_avatar_mobile;
        }

        if (!$rq->name) {
            return response()->json(['error' => 'Vui lòng nhập tên dữ liệu', 'column' => 'name']);
        } else {
            $data['name'] = $rq->name;
        }

        if (!$rq->desc) {
            return response()->json(['error' => 'Vui lòng nhập mô tả ', 'column' => 'desc']);
        } else {
            $data['desc'] = $rq->desc;
        }

        Process::where('id', $id)->update($data);

        return response()->json(['success' => 'Cập nhập dữ liệu thành công']);
    }
}
