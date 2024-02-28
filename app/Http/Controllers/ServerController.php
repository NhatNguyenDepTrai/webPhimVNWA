<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Server;

class ServerController extends Controller
{
    function create($id_episode, Request $rq)
    {
        if (!$id_episode) {
            return response()->json(['error' => 'Có lỗi xảy ra, vui lòng load lại trang']);
        }
        if (!$rq->type) {
            return response()->json(['error' => 'Thiếu loại server!']);
        }

        if ($rq->embed_url) {
            $embed_url = str_replace(' ', '', $rq->embed_url);
            $embed_url = str_replace('"', '', $embed_url);

            if (Server::where('embed_url', $embed_url)->first()) {
                return response()->json(['error' => 'Đã có  embed url này']);
            } else {
                Server::create(['id_episode' => $id_episode, 'type' => $rq->type, 'embed_url' => $embed_url]);
                return response()->json(['success' => 'Thêm ' . $rq->embed_url . '  thành công']);
            }
        } else {
            return response()->json(['error' => 'Nhập embed url']);
        }
    }
}
