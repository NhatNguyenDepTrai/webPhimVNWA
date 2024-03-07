<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\CategoryProject;
use App\Models\ListSlug;
use App\Models\ListImage;
use App\Models\ListView;
use App\Models\Province;
use App\Models\District;
use App\Models\Ward;
use App\Models\Server;
use App\Models\Product;
use App\Models\Episode;
use App\Models\Category;
class VinawebappController extends Controller
{
    function showDashboard()
    {
        $listProductError = [];

        $ListServerError = Episode::whereDoesntHave('servers')
            ->orWhereHas('servers', function ($query) {
                $query->whereNull('embed_url')->orWhere('embed_url', '');
            })
            ->get();
        foreach ($ListServerError as $key => $value) {
            $listProductError[$key]['episode'] = $value->name;
            $product = Product::find($value->id_product);
            $listProductError[$key]['product'] = $product->name;
            $category = Category::find($product->id_category);
            $listProductError[$key]['category'] = $category->name;
        }
        return Inertia::render('Dashboard', ['data' => $listProductError]);
    }
    function changeStatus(Request $request)
    {
        DB::table($request->tb)
            ->where('id', $request->id)
            ->update(['status' => $request->status]);
        return response()->json('Oke');
    }
    function changeHighlight(Request $request)
    {
        DB::table($request->tb)
            ->where('id', $request->id)
            ->update(['highlight' => $request->highlight]);
        return response()->json('Oke');
    }
    function deleteItems(Request $request)
    {
        if ($request->trash == true) {
            DB::table($request->tb)
                ->whereIn('id', $request->dataId)
                ->update(['deleted_at' => now()]);
            return response()->json(['type' => 'success', 'mess' => 'Xóa dữ liệu thành công']);
        } else {
            try {
                DB::table($request->tb)
                    ->whereIn('id', $request->dataId)
                    ->delete();

                DB::table('list_slugs')
                    ->where('tb', $request->tb)
                    ->whereIn('id_tb', $request->dataId)
                    ->delete();
                return response()->json(['type' => 'success', 'mess' => 'Xóa dữ liệu thành công']);
            } catch (\Throwable $th) {
                return response()->json(['type' => 'error', 'mess' => $th->errorInfo]);
            }
        }
    }
    function restoreItems(Request $request)
    {
        DB::table($request->tb)
            ->whereIn('id', $request->dataId)
            ->update(['deleted_at' => null]);
        return response()->json('Khôi phục dữ liệu thành công');
    }
    function changeORD(Request $request)
    {
        DB::table($request->tb)
            ->where('id', $request->id)
            ->update(['ord' => $request->value]);
        return response()->json('Update ORD Success');
    }

    function getDataDistrict($id)
    {
        $data = District::where('id_province', $id)->get();
        return response()->json(['data' => $data]);
    }
    function getDataWard($id)
    {
        $data = Ward::where('id_district', $id)->get();
        return response()->json(['data' => $data]);
    }
}
