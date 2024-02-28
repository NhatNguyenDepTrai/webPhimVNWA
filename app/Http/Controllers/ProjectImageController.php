<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Project;
use App\Models\CategoryProject;
use App\Models\ListSlug;
use App\Models\ListImage;
use App\Models\ListView;
class ProjectImageController extends Controller
{
    function createSlug($slug)
    {
        $check = ListSlug::where('slug', $slug)->first();
        return $check ? true : false;
    }
    function updateSlug($slug, $tb, $id)
    {
        $check = ListSlug::where('slug', $slug)
            ->whereNotIn('tb', [$tb])
            ->whereNotIn('id_tb', [$id])
            ->first();
        return $check ? true : false;
    }
    public function loadAllDataCategoryProject()
    {
        $data = CategoryProject::select('id', 'name')->get();
        return response()->json(['data', $data]);
    }
    public function loadDataTable()
    {
        $data = Project::with('listImages')
            ->where('id_category_project', 2)
            ->with('categoryProject')
            ->get();

        foreach ($data as $key => $value) {
            $value->create_time = Carbon::parse($value->created_at)->format('H:i , d/m/Y ');
            $value->update_time = Carbon::parse($value->updated_at)->format('H:i , d/m/Y ');
            $value->view = ListView::where('tb', 'projects')
                ->where('id_tb', $value->id)
                ->count();

            $category_project = $value->categoryProject;

            if ($category_project) {
                $value->nameCategoryProject = $category_project->name;
            } else {
                $value->nameCategoryProject = 'Trống';
            }
        }

        $trashCount = Project::where('id_category_project', 2)
            ->onlyTrashed()
            ->count();

        return response()->json(['data' => $data, 'trashCount' => $trashCount]);
    }
    function showIndex()
    {
        $jsonData = $this->loadDataTable()->getContent(); // Lấy nội dung JSON response
        $data = json_decode($jsonData, true)['data']; // Giải mã JSON và lấy giá trị của 'data'
        $trashCount = json_decode($jsonData, true)['trashCount'];

        return Inertia::render('ProjectImage/Show', ['data' => $data, 'trashCountNumber' => $trashCount]);
    }

    function showTrash()
    {
        $data = Project::with('listImages')
            ->where('id_category_project', 2)
            ->onlyTrashed()
            ->get();

        foreach ($data as $key => $value) {
            $value->create_time = Carbon::parse($value->created_at)->format('H:i , d/m/Y ');
            $value->update_time = Carbon::parse($value->updated_at)->format('H:i , d/m/Y ');
            $value->delete_at = Carbon::parse($value->deleted_at)->format('H:i , d/m/Y ');
            $value->delete_time = Carbon::parse($value->deleted_at)
                ->subDays(30)
                ->format('H:i , d/m/Y ');
            $value->view = ListView::where('tb', 'projects')
                ->where('id_tb', $value->id)
                ->count();
        }
        $trashCount = Project::onlyTrashed()->count();

        return Inertia::render('ProjectImage/Trash', ['data' => $data, 'trashCount' => $trashCount]);
    }

    function create(Request $rq)
    {
        $tb = 'projects';
        $listSubImage = $rq->listSubImage;
        $data = [];
        $data['url_bg'] = $rq->url_bg;
        $data['desc'] = $rq->desc;
        $data['content'] = $rq->content;
        $data['id_category_project'] = 2;

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

        if (!$rq->slug) {
            return response()->json(['error' => 'Có lỗi xảy ra, không cập nhập được slug, hãy load lại trang', 'column' => 'slug']);
        } else {
            if ($this->createSlug($rq->slug)) {
                return response()->json(['error' => 'Đã có đường dẫn này, nhập đường dẫn khác để tối ưu SEO', 'column' => 'slug']);
            }
            $data['slug'] = $rq->slug;
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

        $id_tb = Project::create($data)->id;
        ListSlug::create([
            'tb' => $tb,
            'id_tb' => $id_tb,
            'name' => $rq->name,
            'slug' => $rq->slug,
        ]);

        foreach ($listSubImage as $key => $value) {
            ListImage::create([
                'tb' => $tb,
                'id_tb' => $id_tb,
                'url_image' => $value,
            ]);
        }
        return response()->json(['success' => 'Cập nhập dữ liệu thành công']);
    }
    function showEdit($id)
    {
        $data = Project::with('listImages')->find($id);
        return Inertia::render('ProjectImage/Edit', ['data' => $data]);
    }
    function update(Request $rq, $id)
    {
        $tb = 'projects';
        $listSubImage = $rq->listSubImage;
        $data = [];
        $data['url_bg'] = $rq->url_bg;
        $data['desc'] = $rq->desc;
        $data['content'] = $rq->content;
        $data['id_category_project'] = 2;

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

        if (!$rq->slug) {
            return response()->json(['error' => 'Có lỗi xảy ra, không cập nhập được slug, hãy load lại trang', 'column' => 'slug']);
        } else {
            if ($this->updateSlug($rq->slug, $tb, $id)) {
                return response()->json(['error' => 'Đã có đường dẫn này, nhập đường dẫn khác để tối ưu SEO', 'column' => 'slug']);
            }
            $data['slug'] = $rq->slug;
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

        Project::where('id', $id)->update($data);
        ListSlug::where('tb', $tb)
            ->where('id_tb', $id)
            ->update(['name' => $rq->name, 'slug' => $rq->slug]);
        ListImage::where('tb', $tb)
            ->where('id_tb', $id)
            ->delete();
        foreach ($listSubImage as $key => $value) {
            ListImage::create([
                'tb' => $tb,
                'id_tb' => $id,
                'url_image' => $value,
            ]);
        }
        return response()->json(['success' => 'Cập nhập dữ liệu thành công']);
    }
}
