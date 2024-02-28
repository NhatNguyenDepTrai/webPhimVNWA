<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Brand;
use App\Models\ListSlug;
use App\Models\ListImage;
use App\Models\ListView;

class BrandController extends Controller
{
    public function loadDataTable()
    {
        $data = Brand::all();
        foreach ($data as $key => $value) {
            $value->create_time = Carbon::parse($value->created_at)->format('H:i , d/m/Y ');
            $value->update_time = Carbon::parse($value->updated_at)->format('H:i , d/m/Y ');
            $value->view = ListView::where('tb', 'brands')
                ->where('id_tb', $value->id)
                ->count();
        }
        $trashCount = Brand::onlyTrashed()->count();

        return response()->json(['data' => $data, 'trashCount' => $trashCount]);
    }
    function showIndex()
    {
        $jsonData = $this->loadDataTable()->getContent(); // Lấy nội dung JSON response
        $data = json_decode($jsonData, true)['data']; // Giải mã JSON và lấy giá trị của 'data'
        $trashCount = json_decode($jsonData, true)['trashCount'];

        return Inertia::render('Brand/Show', ['data' => $data, 'trashCountNumber' => $trashCount]);
    }
    function create(Request $rq)
    {
        $tb = 'brands';
        $data = [];

        $data['desc'] = $rq->desc;
        $data['link'] = $rq->link;
        if (!$rq->url_avatar) {
            return response()->json(['error' => 'Vui lòng chọn ảnh đại diện', 'column' => 'url_avatar']);
        } else {
            $data['url_avatar'] = $rq->url_avatar;
        }
        if (!$rq->name) {
            return response()->json(['error' => 'Vui lòng nhập tên dữ liệu', 'column' => 'name']);
        } else {
            $data['name'] = $rq->name;
        }

        Brand::create($data);

        return response()->json(['success' => 'Cập nhập dữ liệu thành công']);
    }
    function showEdit($id)
    {
        $data = Brand::find($id);

        return Inertia::render('Brand/Edit', ['data' => $data]);
    }
    function update(Request $rq, $id)
    {
        $tb = 'brands';
        $data = [];
        $data['link'] = $rq->link;
        $data['desc'] = $rq->desc;
        if (!$id) {
            return response()->json(['error' => 'Có lỗi xảy ra, hãy load lại trang', 'column' => 'id']);
        }
        if (!$rq->url_avatar) {
            return response()->json(['error' => 'Vui lòng chọn ảnh đại diện', 'column' => 'url_avatar']);
        } else {
            $data['url_avatar'] = $rq->url_avatar;
        }
        if (!$rq->name) {
            return response()->json(['error' => 'Vui lòng nhập tên dữ liệu', 'column' => 'name']);
        } else {
            $data['name'] = $rq->name;
        }
        Brand::where('id', $id)->update($data);

        return response()->json(['success' => 'Cập nhập dữ liệu thành công']);
    }

    function showTrash()
    {
        $data = Brand::onlyTrashed()->get();
        foreach ($data as $key => $value) {
            $value->create_time = Carbon::parse($value->created_at)->format('H:i , d/m/Y ');
            $value->update_time = Carbon::parse($value->updated_at)->format('H:i , d/m/Y ');
            $value->delete_at = Carbon::parse($value->deleted_at)->format('H:i , d/m/Y ');
            $value->delete_time = Carbon::parse($value->deleted_at)
                ->subDays(30)
                ->format('H:i , d/m/Y ');
            $value->view = ListView::where('tb', 'brands')
                ->where('id_tb', $value->id)
                ->count();
        }
        $trashCount = Brand::onlyTrashed()->count();

        return Inertia::render('Brand/Trash', ['data' => $data, 'trashCount' => $trashCount]);
    }
}
