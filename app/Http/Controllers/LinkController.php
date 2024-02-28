<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
namespace App\Http\Controllers;
use Carbon\Carbon;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Link;
use App\Models\ListView;
class LinkController extends Controller
{
    public function loadDataTable()
    {
        $data = Link::get();
        foreach ($data as $key => $value) {
            $value->create_time = Carbon::parse($value->created_at)->format('H:i , d/m/Y ');
            $value->update_time = Carbon::parse($value->updated_at)->format('H:i , d/m/Y ');
            $value->view = ListView::where('tb', 'links')
                ->where('id_tb', $value->id)
                ->count();
        }

        return response()->json(['data' => $data]);
    }
    function showIndex()
    {
        $jsonData = $this->loadDataTable()->getContent(); // Lấy nội dung JSON response
        $data = json_decode($jsonData, true)['data']; // Giải mã JSON và lấy giá trị của 'data'

        return Inertia::render('Link/Show', ['data' => $data]);
    }
    function create(Request $rq)
    {
        $tb = 'links';
        $data = [];
        $data['desc'] = $rq->desc;

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

        if (!$rq->value) {
            return response()->json(['error' => 'Vui lòng nhập liên kết', 'column' => 'value']);
        } else {
            $data['value'] = $rq->value;
        }

        $id_tb = Link::create($data)->id;
        return response()->json(['success' => 'Cập nhập dữ liệu thành công']);
    }
    function showEdit($id)
    {
        $data = Link::find($id);

        return Inertia::render('Link/Edit', ['data' => $data]);
    }
    function update(Request $rq, $id)
    {
        $tb = 'links';
        $data = [];
        $data['desc'] = $rq->desc;

        if (!$id) {
            return response()->json(['error' => 'Có lỗi xảy ra, không cập nhập được value, hãy load lại trang', 'column' => 'value']);
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

        if (!$rq->value) {
            return response()->json(['error' => 'Vui lòng nhập liên kết', 'column' => 'value']);
        } else {
            $data['value'] = $rq->value;
        }

        Link::where('id', $id)->update($data);
        return response()->json(['success' => 'Cập nhập dữ liệu thành công']);
    }
}
