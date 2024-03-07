<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;
use App\Models\ProductBanner;
use App\Models\Product;

class ProductBannerController extends Controller
{
    public function loadDataTable()
    {
        $data = ProductBanner::with('product:id,name,full_name,url_bg')->orderBy('ORD', 'ASC')->get();

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

        return Inertia::render('ProductBanner/Show', ['data' => $data]);
    }
    function getDataProduct()
    {
        $data = Product::where('status', 1)
            ->doesnthave('product_banner')
            ->latest()
            ->get(['id', 'url_avatar', 'url_bg', 'name', 'full_name']);
        return response()->json(['data' => $data], 200);
    }
    function addProductInProductBanner(Request $request)
    {
        foreach ($request->dataProduct as $value) {
            ProductBanner::create([
                'id_product' => $value['id'],
            ]);
        }
        return true;
    }
}
