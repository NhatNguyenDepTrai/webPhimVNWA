<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Company;

class CompanyController extends Controller
{
    function showCompany()
    {
        $data = Company::first();
        $dataProvince = [];
        $dataDistrict = [];
        $dataWard = [];
        return Inertia::render('Company', ['data' => $data, 'dataProvince' => $dataProvince, 'dataDistrict' => $dataDistrict, 'dataWard' => $dataWard]);
    }
    function UpdateCompany(Request $request)
    {
        if (!$request->url_avatar_full) {
            return response()->json(['error' => 'Vui lòng chọn logo full', 'column' => 'url_avatar_full']);
        } else {
            $data['url_avatar_full'] = $request->url_avatar_full;
        }

        if (!$request->url_avatar_icon) {
            return response()->json(['error' => 'Vui lòng chọn logo icon', 'column' => 'url_avatar_icon']);
        } else {
            $data['url_avatar_icon'] = $request->url_avatar_icon;
        }

        if (!$request->url_favicon) {
            return response()->json(['error' => 'Vui lòng chọn favicon', 'column' => 'url_favicon']);
        } else {
            $data['url_favicon'] = $request->url_favicon;
        }
        if (!$request->url_video) {
            return response()->json(['error' => 'Vui lòng nhập mã video youtube', 'column' => 'url_video']);
        } else {
            $data['url_video'] = $request->url_video;
        }

        if (!$request->name) {
            return response()->json(['error' => 'Vui lòng nhập tên công ty', 'column' => 'name']);
        } else {
            $data['name'] = $request->name;
        }
        if (!$request->short_name) {
            return response()->json(['error' => 'Vui lòng nhập tên công ty viết tắt', 'column' => 'short_name']);
        } else {
            $data['short_name'] = $request->short_name;
        }
        if (!$request->slogan) {
            return response()->json(['error' => 'Vui lòng nhập slogan', 'column' => 'slogan']);
        } else {
            $data['slogan'] = $request->slogan;
        }
        if (!$request->sub_slogan) {
            return response()->json(['error' => 'Vui lòng nhập sub_slogan', 'column' => 'sub_slogan']);
        } else {
            $data['sub_slogan'] = $request->sub_slogan;
        }
        if (!$request->website) {
            return response()->json(['error' => 'Vui lòng nhập link website', 'column' => 'website']);
        } else {
            $data['website'] = $request->website;
        }
        if (!$request->phone) {
            return response()->json(['error' => 'Vui lòng nhập số điện thoại', 'column' => 'phone']);
        } else {
            $data['phone'] = $request->phone;
        }
        if (!$request->hotline) {
            return response()->json(['error' => 'Vui lòng nhập hotline', 'column' => 'hotline']);
        } else {
            $data['hotline'] = $request->hotline;
        }
        if (!$request->mail) {
            return response()->json(['error' => 'Vui lòng nhập mail', 'column' => 'mail']);
        } else {
            $data['mail'] = $request->mail;
        }
        if (!$request->support_mail) {
            return response()->json(['error' => 'Vui lòng nhập support_mail', 'column' => 'support_mail']);
        } else {
            $data['support_mail'] = $request->support_mail;
        }

        if (!$request->address) {
            return response()->json(['error' => 'Vui lòng nhập số nhà, tên đường', 'column' => 'address']);
        } else {
            $data['address'] = $request->address;
        }

        if (!$request->meta_image) {
            return response()->json(['error' => 'Vui lòng chọn meta image', 'column' => 'meta_image']);
        } else {
            $data['meta_image'] = $request->meta_image;
        }

        if (!$request->meta_title) {
            return response()->json(['error' => 'Vui lòng nhập meta title', 'column' => 'meta_title']);
        } else {
            $data['meta_title'] = $request->meta_title;
        }

        if (!$request->meta_desc) {
            return response()->json(['error' => 'Vui lòng nhập meta desc', 'column' => 'meta_desc']);
        } else {
            $data['meta_desc'] = $request->meta_desc;
        }
        if (!$request->url_avatar_about) {
            return response()->json(['error' => 'Vui lòng nhập ảnh about', 'column' => 'url_avatar_about']);
        } else {
            $data['url_avatar_about'] = $request->url_avatar_about;
        }
        if (!$request->shortAbout) {
            return response()->json(['error' => 'Vui lòng nhập short about', 'column' => 'shortAbout']);
        } else {
            $data['shortAbout'] = $request->shortAbout;
        }
        if (!$request->about) {
            return response()->json(['error' => 'Vui lòng nhập phần giới thiệu công ty', 'column' => 'about']);
        } else {
            $data['about'] = $request->about;
        }
        $data['zalo'] = $data['facebook'] = $data['instagram'] = $data['youtube'] = $data['tiktok'] = $data['telegram'] = $data['linkedin'] = '';
        if ($request->zalo) {
            $data['zalo'] = $request->zalo;
        }
        if ($request->facebook) {
            $data['facebook'] = $request->facebook;
        }
        if ($request->instagram) {
            $data['instagram'] = $request->instagram;
        }
        if ($request->youtube) {
            $data['youtube'] = $request->youtube;
        }
        if ($request->tiktok) {
            $data['tiktok'] = $request->tiktok;
        }
        if ($request->telegram) {
            $data['telegram'] = $request->telegram;
        }
        if ($request->linkedin) {
            $data['linkedin'] = $request->linkedin;
        }
        Company::find(1)->update($data);
        return $data;
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
