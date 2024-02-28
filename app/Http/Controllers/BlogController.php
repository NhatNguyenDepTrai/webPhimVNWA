<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Blog;
use App\Models\CategoryBlog;
use App\Models\BlogTag;
use App\Models\ListSlug;
use App\Models\ListBlogTag;
use App\Models\ListImage;
use App\Models\ListView;

class BlogController extends Controller
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
    public function loadDataTable()
    {
        $data = Blog::with('listImages')
            ->with('categoryBlog')
            ->with('tags')
            ->get();
        foreach ($data as $value) {
            $value->create_time = Carbon::parse($value->created_at)->format('H:i , d/m/Y ');
            $value->update_time = Carbon::parse($value->updated_at)->format('H:i , d/m/Y ');
            $value->view = ListView::where('tb', 'blogs')
                ->where('id_tb', $value->id)
                ->count();
            $category_blog = $value->categoryBlog;
            if ($category_blog) {
                $value->nameCategoryBlog = $category_blog->name;
            } else {
                $value->nameCategoryBlog = 'Trống';
            }
        }
        $trashCount = Blog::onlyTrashed()->count();
        return response()->json(['data' => $data, 'trashCount' => $trashCount]);
    }
    function showIndex()
    {
        $jsonData = $this->loadDataTable()->getContent(); // Lấy nội dung JSON response
        $data = json_decode($jsonData, true)['data']; // Giải mã JSON và lấy giá trị của 'data'
        $trashCount = json_decode($jsonData, true)['trashCount'];

        return Inertia::render('Blog/Show', ['data' => $data, 'trashCountNumber' => $trashCount]);
    }
    function showCreate()
    {
        $data = CategoryBlog::get(['id', 'name']);
        $listBlogTag = BlogTag::where('status', 1)->get(['id', 'name']);
        $dataTag = [];
        foreach ($listBlogTag as $key => $value) {
            $dataTag[$key]['label'] = $value->name;
            $dataTag[$key]['value'] = $value->id;
        }

        return Inertia::render('Blog/Create', ['dataCategoryBlog' => $data, 'dataBlogTag' => $dataTag]);
    }
    function create(Request $rq)
    {
        $tb = 'blogs';
        $data = [];
        $data['id_category_blog'] = 1;
        $data['desc'] = $rq->desc;
        $data['content'] = $rq->content;

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

        $id_tb = Blog::create($data)->id;
        ListSlug::create([
            'tb' => $tb,
            'id_tb' => $id_tb,
            'name' => $rq->name,
            'slug' => $rq->slug,
        ]);

        return response()->json(['success' => 'Cập nhập dữ liệu thành công']);
    }
    function showEdit($id)
    {
        $data = Blog::with('listImages')
            ->with('tags')
            ->find($id);
        $dataCategoryBlog = CategoryBlog::get(['name', 'id']);
        $listBlogTag = BlogTag::where('status', 1)->get(['id', 'name']);
        $dataTag = [];
        foreach ($listBlogTag as $key => $value) {
            $dataTag[$key]['label'] = $value->name;
            $dataTag[$key]['value'] = $value->id;
        }

        $dataBlogTagSelected = [];
        if ($data->tags) {
            foreach ($data->tags as $key => $value) {
                $dataBlogTagSelected[$key] = $value->id;
            }
        }
        // return $dataBlogTagSelected;
        return Inertia::render('Blog/Edit', ['data' => $data, 'dataCategoryBlog' => $dataCategoryBlog, 'dataBlogTag' => $dataTag, 'dataBlogTagSelected' => $dataBlogTagSelected]);
    }
    function update(Request $rq, $id)
    {
        try {
            $tb = 'blogs';
            $data = [];
            $data['id_category_blog'] = 1;
            $data['desc'] = $rq->desc;
            $data['content'] = $rq->content;
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
            $blog = Blog::find($id);
            $blog->update($data);
            $blog->save();
            ListSlug::where('tb', $tb)
                ->where('id_tb', $id)
                ->update(['name' => $rq->name, 'slug' => $rq->slug]);

            return response()->json(['success' => 'Cập nhập dữ liệu thành công']);
        } catch (\Exception $e) {
            DB::rollback();
            // Xử lý lỗi (ví dụ: log lỗi, thông báo người dùng, v.v.)
            return response()->json(['error' => 'Đã xảy ra lỗi trong quá trình cập nhật.'], 500);
        }
    }

    function showTrash()
    {
        $data = Blog::with('listImages')
            ->onlyTrashed()
            ->get();
        foreach ($data as $key => $value) {
            $value->create_time = Carbon::parse($value->created_at)->format('H:i , d/m/Y ');
            $value->update_time = Carbon::parse($value->updated_at)->format('H:i , d/m/Y ');
            $value->delete_at = Carbon::parse($value->deleted_at)->format('H:i , d/m/Y ');
            $value->delete_time = Carbon::parse($value->deleted_at)
                ->subDays(30)
                ->format('H:i , d/m/Y ');
            $value->view = ListView::where('tb', 'blogs')
                ->where('id_tb', $value->id)
                ->count();
        }
        $trashCount = Blog::onlyTrashed()->count();

        return Inertia::render('Blog/Trash', ['data' => $data, 'trashCount' => $trashCount]);
    }
}
