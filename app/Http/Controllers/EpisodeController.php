<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Product;
use App\Models\Episode;

class EpisodeController extends Controller
{
    public function makeSlug($string)
    {
        $search = ['#(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)#', '#(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)#', '#(ì|í|ị|ỉ|ĩ)#', '#(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)#', '#(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)#', '#(ỳ|ý|ỵ|ỷ|ỹ)#', '#(đ)#', '#(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)#', '#(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)#', '#(Ì|Í|Ị|Ỉ|Ĩ)#', '#(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)#', '#(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)#', '#(Ỳ|Ý|Ỵ|Ỷ|Ỹ)#', '#(Đ)#', '/[^a-zA-Z0-9\-\_]/'];
        $replace = ['a', 'e', 'i', 'o', 'u', 'y', 'd', 'A', 'E', 'I', 'O', 'U', 'Y', 'D', '-'];
        $string = preg_replace($search, $replace, $string);
        $string = preg_replace('/(-)+/', '-', $string);
        $string = strtolower($string);
        return $string;
    }
    public function loadDataTable($id_product)
    {
        $data = Episode::where('id_product', $id_product)->with('servers')->get();

        return response()->json(['data' => $data]);
    }
    function create($id_product, Request $rq)
    {
        if ($rq->name) {
            $slug = $this->makeSlug($rq->name);
            if (Episode::where('slug', $slug)->where('id_product', $id_product)->first()) {
                return response()->json(['error' => 'Đã có tên này']);
            } else {
                Episode::create(['id_product' => $id_product, 'name' => $rq->name, 'slug' => $slug]);
                return response()->json(['success' => 'Thêm ' . $rq->name . '  thành công']);
            }
        } else {
            return response()->json(['error' => 'Nhập tên']);
        }
    }
    function update($id_product, $id, Request $rq)
    {
        if ($rq->name) {
            $slug = $this->makeSlug($rq->name);
            if (
                Episode::whereNotIn('id', [$id])
                    ->where('id_product', $id_product)
                    ->where('slug', $slug)
                    ->first()
            ) {
                return response()->json(['error' => 'Đã có tên này']);
            } else {
                Episode::where('id', $id)
                    ->where('id_product', $id_product)
                    ->update(['name' => $rq->name, 'slug' => $slug]);
                return response()->json(['success' => 'Sửa  tên tập thành công thành công']);
            }
        } else {
            return response()->json(['error' => 'Nhập tên']);
        }
    }
}
