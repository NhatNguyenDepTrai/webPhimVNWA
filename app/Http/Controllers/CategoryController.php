<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Category;
class CategoryController extends Controller
{
    public function loadDataTable()
    {
        $data = Category::all();
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

        return Inertia::render('Category/Show', ['data' => $data]);
    }
    function showEdit($id)
    {
        $data = Category::find($id);

        return Inertia::render('Category/Edit', ['data' => $data]);
    }
    function update(Request $rq, $id)
    {
        $data = [];
        if (!$id) {
            return response()->json(['error' => 'Có lỗi xảy ra, không cập nhập được slug, hãy load lại trang', 'column' => 'slug']);
        }

        if (!$rq->meta_title) {
            return response()->json(['error' => 'Vui lòng nhập tiêu đề link để tối ưu SEO', 'column' => 'meta_title']);
        } else {
            $data['meta_title'] = $rq->meta_title;
        }

        if (!$rq->meta_image) {
            return response()->json(['error' => 'Vui lòng chọn ảnh link để tối ưu SEO', 'column' => 'meta_image']);
        } else {
            $data['meta_image'] = $rq->meta_image;
        }

        if (!$rq->meta_desc) {
            return response()->json(['error' => 'Vui lòng nhập mô tả link để tối ưu SEO', 'column' => 'meta_desc']);
        } else {
            $data['meta_desc'] = $rq->meta_desc;
        }
        try {
            Category::where('id', $id)->update($data);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Có lỗi xảy ra, vui lòng load lại trang', 'column' => 'meta_desc']);
        }

        return response()->json(['success' => 'Cập nhập dữ liệu thành công']);
    }
}
