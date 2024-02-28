<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Product;
use App\Models\Category;
use App\Models\Year;
use App\Models\Nation;
use App\Models\Type;
use App\Models\ProType;

class ProductCinemaController extends Controller
{
    function createSlug($slug)
    {
        $check = Product::where('slug', $slug)->first();
        return $check ? true : false;
    }
    function updateSlug($slug, $id)
    {
        $check = Product::where('slug', $slug)
            ->whereNotIn('id', [$id])
            ->first();
        return $check ? true : false;
    }
    public function loadDataTable()
    {
        $data = Product::where('id_category', 3)->with('episodes')->with('types')->with('year')->with('nation')->latest()->get();

        foreach ($data as $key => $value) {
            $value->create_time = Carbon::parse($value->created_at)->format('H:i , d/m/Y ');
            $value->update_time = Carbon::parse($value->updated_at)->format('H:i , d/m/Y ');
            $year = $value->year;
            $value->nameYear = $year->name;
            $nation = $value->nation;
            $value->nameNation = $nation->name;
        }
        $trashCount = Product::where('id_category', 3)->onlyTrashed()->count();

        return response()->json(['data' => $data, 'trashCount' => $trashCount]);
    }
    function showIndex()
    {
        $jsonData = $this->loadDataTable()->getContent(); // Lấy nội dung JSON response
        $data = json_decode($jsonData, true)['data']; // Giải mã JSON và lấy giá trị của 'data'
        $trashCount = json_decode($jsonData, true)['trashCount'];
        return Inertia::render('ProductCinema/Show', ['data' => $data, 'trashCountNumber' => $trashCount]);
    }

    function showCreate()
    {
        $listYear = Year::where('status', 1)->get(['id', 'name', 'slug']);
        $listNation = Nation::where('status', 1)->get(['id', 'name', 'slug']);

        $listType = Type::where('status', 1)->get(['id', 'name']);
        $dataType = [];
        foreach ($listType as $key => $value) {
            $dataType[$key]['label'] = $value->name;
            $dataType[$key]['value'] = $value->id;
        }

        return Inertia::render('ProductCinema/Create', ['listYear' => $listYear, 'listNation' => $listNation, 'listType' => $dataType]);
    }
    function create(Request $rq)
    {
        $data = [];
        $data['id_category'] = 3;
        if (!$rq->full_name) {
            return response()->json(['error' => 'Vui lòng nhập tên đầy đủ của phim', 'column' => 'full_name']);
        } else {
            $data['full_name'] = $rq->full_name;
        }
        if (!$rq->name) {
            return response()->json(['error' => 'Vui lòng nhập tên phim', 'column' => 'name']);
        } else {
            $data['name'] = $rq->name;
        }
        if (!$rq->slug) {
            return response()->json(['error' => 'Có lỗi xảy ra, không cập nhập được slug, hãy load lại trang', 'column' => 'slug']);
        } else {
            if ($this->createSlug($rq->slug)) {
                return response()->json(['error' => 'Đã có đường dẫn này, nhập đường dẫn khác để tối ưu SEO', 'column' => 'slug']);
            }
            $data['slug'] = $rq->slug;
        }
        if (!$rq->desc) {
            return response()->json(['error' => 'Vui lòng nhập mô tả phim', 'column' => 'desc']);
        } else {
            $data['desc'] = $rq->desc;
        }
        if (!$rq->id_nation) {
            return response()->json(['error' => 'Vui lòng chọn quốc gia', 'column' => 'id_nation']);
        } else {
            $data['id_nation'] = $rq->id_nation;
        }
        if (!$rq->date) {
            return response()->json(['error' => 'Vui lòng chọn ngày, tháng phát hành', 'column' => 'date']);
        } else {
            $data['date'] = $rq->date;
        }
        if (!$rq->id_year) {
            return response()->json(['error' => 'Vui lòng chọn năm phát hành', 'column' => 'id_year']);
        } else {
            $data['id_year'] = $rq->id_year;
        }
        if (!$rq->types) {
            return response()->json(['error' => 'Vui lòng chọn thể loại', 'column' => 'types']);
        } else {
            $data['types'] = $rq->types;
        }

        if (!$rq->url_avatar) {
            return response()->json(['error' => 'Vui lòng chọn ảnh đại diện', 'column' => 'url_avatar']);
        } else {
            $data['url_avatar'] = $rq->url_avatar;
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

        $id_tb = Product::create($data)->id;
        foreach ($rq->types as $type_id) {
            ProType::create([
                'id_type' => $type_id,
                'id_product' => $id_tb,
            ]);
        }
        return response()->json(['success' => 'Cập nhập dữ liệu thành công']);
    }

    function showEdit($id)
    {
        $data = Product::where('id_category', 3)->with('types')->with('year')->with('nation')->find($id);

        $listYear = Year::where('status', 1)->get(['id', 'name', 'slug']);
        $listNation = Nation::where('status', 1)->get(['id', 'name', 'slug']);

        $listType = Type::where('status', 1)->get(['id', 'name']);
        $dataType = [];
        foreach ($listType as $key => $value) {
            $dataType[$key]['label'] = $value->name;
            $dataType[$key]['value'] = $value->id;
        }
        $dataTypeSelected = [];

        if ($data->types) {
            if ($data->types) {
                foreach ($data->types as $key => $value) {
                    $dataTypeSelected[$key] = $value->id;
                }
            }
        }

        return Inertia::render('ProductCinema/Edit', ['data' => $data, 'listYear' => $listYear, 'listNation' => $listNation, 'listType' => $dataType, 'dataTypeSelected' => $dataTypeSelected]);
    }
    function update(Request $rq, $id)
    {
        $data = [];
        $data['id_category'] = 3;
        if (!$rq->full_name) {
            return response()->json(['error' => 'Vui lòng nhập tên đầy đủ của phim', 'column' => 'full_name']);
        } else {
            $data['full_name'] = $rq->full_name;
        }
        if (!$rq->name) {
            return response()->json(['error' => 'Vui lòng nhập tên phim', 'column' => 'name']);
        } else {
            $data['name'] = $rq->name;
        }
        if (!$rq->slug) {
            return response()->json(['error' => 'Có lỗi xảy ra, không cập nhập được slug, hãy load lại trang', 'column' => 'slug']);
        } else {
            if ($this->updateSlug($rq->slug, $id)) {
                return response()->json(['error' => 'Đã có đường dẫn này, nhập đường dẫn khác để tối ưu SEO', 'column' => 'slug']);
            }
            $data['slug'] = $rq->slug;
        }
        if (!$rq->desc) {
            return response()->json(['error' => 'Vui lòng nhập mô tả phim', 'column' => 'desc']);
        } else {
            $data['desc'] = $rq->desc;
        }
        if (!$rq->id_nation) {
            return response()->json(['error' => 'Vui lòng chọn quốc gia', 'column' => 'id_nation']);
        } else {
            $data['id_nation'] = $rq->id_nation;
        }
        if (!$rq->date) {
            return response()->json(['error' => 'Vui lòng chọn ngày, tháng phát hành', 'column' => 'date']);
        } else {
            $data['date'] = $rq->date;
        }
        if (!$rq->id_year) {
            return response()->json(['error' => 'Vui lòng chọn năm phát hành', 'column' => 'id_year']);
        } else {
            $data['id_year'] = $rq->id_year;
        }
        if (!$rq->types) {
            return response()->json(['error' => 'Vui lòng chọn thể loại', 'column' => 'types']);
        }

        if (!$rq->url_avatar) {
            return response()->json(['error' => 'Vui lòng chọn ảnh đại diện', 'column' => 'url_avatar']);
        } else {
            $data['url_avatar'] = $rq->url_avatar;
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

        Product::where('id', $id)->update($data);
        ProType::where('id_product', $id)->delete();
        foreach ($rq->types as $type_id) {
            ProType::create([
                'id_type' => $type_id,
                'id_product' => $id,
            ]);
        }
        return response()->json(['success' => 'Cập nhập dữ liệu thành công']);
    }

    function showTrash()
    {
        $data = Product::onlyTrashed()->get();
        foreach ($data as $key => $value) {
            $value->create_time = Carbon::parse($value->created_at)->format('H:i , d/m/Y ');
            $value->update_time = Carbon::parse($value->updated_at)->format('H:i , d/m/Y ');
            $value->delete_at = Carbon::parse($value->deleted_at)->format('H:i , d/m/Y ');
            $value->delete_time = Carbon::parse($value->deleted_at)
                ->subDays(30)
                ->format('H:i , d/m/Y ');
        }
        $trashCount = Product::onlyTrashed()->count();

        return Inertia::render('ProductCinema/Trash', ['data' => $data, 'trashCount' => $trashCount]);
    }
}
