<?php

namespace App\Http\Controllers;

use App\Models\CategoryNew;
use App\Models\CmtNew;
use App\Models\News;
use App\Models\User;
use App\Services\CategoryNewSrc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    protected $categoryNewSrc;

    public function __construct(CategoryNewSrc $categoryNewSrc)
    {
        $this->categoryNewSrc = $categoryNewSrc;
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function blog()
    {
        // Seo website
        $titleSeo = config('common.title_seo_blog');
        $keywordSeo = config('common.keyword_seo_blog');
        $descriptionSeo = config('common.des_seo_blog');

        $cateMenu = CategoryNew::select('name', 'slug')->orderBy('stt_new', 'ASC')
            ->where('is_public', 1)
            ->where('slug', '<>', 'blogs')->get();

        $newAll = News::select('name', 'slug', 'desc', 'view_count', 'image', 'alt_img', 'title_img', 'user_id', 'created_at')
            ->with(['user:id,name,slug'])->latest()->paginate(10);
        // Nếu số trang hiện tại vượt quá số trang cuối cùng, điều chỉnh trang hiện tại về trang cuối cùng
        if ($newAll->currentPage() > $newAll->lastPage()) {
            // Lấy dữ liệu của trang cuối cùng
            $newAll = News::select('name', 'slug', 'desc', 'view_count', 'image', 'alt_img', 'title_img', 'user_id', 'created_at')
                ->with(['user:id,name,slug'])
                ->latest()
                ->paginate(10, ['*'], 'page', $newAll->lastPage());
        }

        $viewer = News::select('name', 'slug')->orderBy('view_count', 'DESC')->take(10)->get();
        $outstand = News::select('name', 'slug', 'image', 'alt_img', 'title_img')->where('is_outstand', 1)->orderBy('created_at', 'DESC')->take(10)->get();

        return view('cntt.home.blogs.blog', compact(
            'titleSeo', 'keywordSeo', 'descriptionSeo',
            'cateMenu', 'viewer', 'outstand', 'newAll'
        ));
    }

    public function cateBlog(Request $request, $slug)
    {
        $cateMenu = CategoryNew::select('name', 'slug')->orderBy('stt_new', 'ASC')
            ->where('is_public', 1)
            ->where('slug', '<>', 'blogs')->get();
        // Tin tức bài viết 
        $newArt = News::where('slug', $slug)->first();
        if (!empty($newArt)) {
            $titleSeo = (!empty($newArt->title_seo)) ? $newArt->title_seo : config('common.title_seo_blog');
            $keywordSeo = (!empty($newArt->keyword_seo)) ? $newArt->keyword_seo : config('common.keyword_seo_blog');
            $descriptionSeo = (!empty($newArt->des_seo)) ? $newArt->des_seo : config('common.des_seo_blog');
            // Thêm số lượt xem bài viết vào bảng news
            $newArt->view_count = ($newArt->view_count ?? 0) + 1;
            $newArt->save();

            $sameCate = News::select('name', 'slug', 'image', 'alt_img', 'title_img')
                ->where('cate_id', $newArt->cate_id)
                ->where('id', '!=', $newArt->id)
                ->orderBy('created_at', 'DESC')->take(10)
                ->get();

            $titleCate = CategoryNew::where('id', $newArt->cate_id)->first();
            $allParents = $titleCate->getAllParents();
            // Lấy sản phẩm liên quan nếu có
            $relatedPro = !empty($titleCate->related_pro) ? $titleCate->getRelatedPro() : null;
            // Lấy ảnh chính cho từng sản phẩm
            if(!empty($relatedPro)) {
                $relatedPro->each(function ($productImg) {
                    $productImg->main_image = $productImg->getMainImage(); // Thêm ảnh chính vào đối tượng sản phẩm
                });
            }
            // Comments
            $commentsQuery = CmtNew::select('id', 'content', 'parent_id', 'new_id', 'user_id', 'name', 'slugNew', 'star', 'created_at')
                ->where('cmt_news.new_id', $newArt->id)
                ->where('cmt_news.parent_id', 0)
                ->orderBy('cmt_news.created_at', 'DESC');

            if (Auth::check() && Auth::user()->hasPermission('replay_cmtnew')) {
                $commentsQuery->with([
                    'replies' => function ($query) {
                        $query->select('id', 'content', 'parent_id', 'new_id', 'user_id', 'name', 'slugNew', 'star', 'email', 'is_public', 'created_at');
                    }
                ]);
            } else {
                $commentsQuery->where(function($query) {
                    $query->where('cmt_news.is_public', 1) // Hiển thị bình luận công khai
                        ->orWhere(function($query) {
                            $query->whereNotNull('cmt_news.user_id')->where('cmt_news.user_id', Auth::id());
                        });
                })->with([
                    'cmtChild' => function ($query) {
                        $query->select('id', 'content', 'parent_id', 'new_id', 'user_id', 'name', 'slugNew', 'star', 'email', 'is_public', 'created_at');
                    }
                ]);
            }
    
            $comments = $commentsQuery->paginate(5);
            if ($request->ajax()) {
                return view('cntt.home.blogs.partials.comment', compact('comments'))->render(); // Trả về view khi gọi bằng AJAX
            }
            // Tính tổng số bình luận (cha + con)
            $totalCommentsCount = CmtNew::where('new_id', $newArt->id)
                ->when(!Auth::check() || !Auth::user()->hasPermission('replay_cmtnew'), function($query) {
                    $query->where(function($query) {
                        $query->where('is_public', 1) // Hiển thị bình luận công khai
                            ->orWhere(function($query) {
                                $query->where('user_id', Auth::id())
                                    ->whereNotNull('user_id'); // Chỉ hiển thị của user hiện tại
                            });
                    });
                })->count();
            $user = Auth::user();
            
            return view('cntt.home.blogs.detail', compact(
                'titleSeo', 'keywordSeo', 'descriptionSeo',
                'cateMenu', 'newArt', 'allParents',
                'sameCate', 'titleCate',
                'comments', 'totalCommentsCount', 'user'
            ));
        }
        // Danh mục tin tức bài viết
        $cateNew = CategoryNew::where('slug', $slug)->value('id');
        if (empty($cateNew)) {
            abort(404);
        }
        $childrenIds = $this->categoryNewSrc->getAllChildrenIds($cateNew);
        $newArray = array_merge([$cateNew], $childrenIds);

        $titleCate = CategoryNew::findOrFail($cateNew);
        $allParents = $titleCate->getAllParents();

        $titleSeo = $titleCate->title_seo ?? config('common.title_seo_blog');
        $keywordSeo = $titleCate->keyword_seo ?? config('common.keyword_seo_blog');
        $descriptionSeo = $titleCate->des_seo ?? config('common.des_seo_blog');

        $news = News::select('name', 'slug', 'desc', 'view_count', 'image', 'alt_img', 'title_img', 'user_id', 'created_at')
            ->whereIn('cate_id', $newArray)
            ->latest()->paginate(10);
        // Nếu số trang hiện tại vượt quá số trang cuối cùng, điều chỉnh trang hiện tại về trang cuối cùng
        if ($news->currentPage() > $news->lastPage()) {
            // Chuyển hướng đến trang cuối cùng
            $news = News::select('name', 'slug', 'desc', 'view_count', 'image', 'alt_img', 'title_img', 'user_id', 'created_at')
                ->whereIn('cate_id', $newArray)
                ->latest()
                ->paginate(10, ['*'], 'page', $news->lastPage());
        }
        $viewer = News::select('name', 'slug')
            ->whereIn('cate_id', $newArray)
            ->orderBy('view_count', 'DESC')->take(10)->get();
        $outstand = News::select('name', 'slug', 'image', 'alt_img', 'title_img')
            ->whereIn('cate_id', $newArray)->where('is_outstand', 1)
            ->latest()->take(10)->get();
        // Lấy sản phẩm liên quan nếu có
        $relatedPro = !empty($titleCate->related_pro) ? $titleCate->getRelatedPro() : null;

        // Lấy ảnh chính cho từng sản phẩm
        if(!empty($relatedPro)) {
            $relatedPro->each(function ($productImg) {
                $productImg->main_image = $productImg->getMainImage(); // Thêm ảnh chính vào đối tượng sản phẩm
            });
        }
        
        return view('cntt.home.blogs.cateBlog', compact(
            'titleSeo', 'keywordSeo', 'descriptionSeo',
            'cateMenu', 'titleCate', 'allParents',
            'news', 'viewer', 'outstand', 'relatedPro'
        ));
    }

    public function detailBlog($slugParent, $slug)
    {
        $cateMenu = CategoryNew::select('name', 'slug')->orderBy('stt_new', 'ASC')
            ->where('is_public', 1)
            ->where('slug', '<>', 'blogs')->get();

        $cateNew = News::where('slug', $slug)->value('id');
        $childrenIds = $this->categoryNewSrc->getAllChildrenIds($cateNew);
        $newArray = array_merge([$cateNew], $childrenIds);

        $titleCate = CategoryNew::findOrFail($cateNew);
        $allParents = $titleCate->getAllParents();
        $titleSeo = $titleCate->title_seo ?? config('common.title_seo_blog');
        $keywordSeo = $titleCate->keyword_seo ?? config('common.keyword_seo_blog');
        $descriptionSeo = $titleCate->des_seo ?? config('common.des_seo_blog');

        $news = News::select('name', 'slug', 'desc', 'view_count', 'image', 'alt_img', 'title_img', 'user_id', 'created_at')
            ->where('cate_id', $newArray)
            ->latest()->paginate(10);
        // Nếu số trang hiện tại vượt quá số trang cuối cùng, điều chỉnh trang hiện tại về trang cuối cùng
        if ($news->currentPage() > $news->lastPage()) {
            // Chuyển hướng đến trang cuối cùng
            $news = News::select('name', 'slug', 'desc', 'view_count', 'image', 'alt_img', 'title_img', 'user_id', 'created_at')
                ->where('cate_id', $newArray)
                ->latest()
                ->paginate(10, ['*'], 'page', $news->lastPage());
        }
        $viewer = News::select('name', 'slug')
            ->where('cate_id', $newArray)
            ->orderBy('view_count', 'DESC')->take(10)->get();
        $outstand = News::select('name', 'slug', 'image', 'alt_img', 'title_img')
            ->where('cate_id', $newArray)->where('is_outstand', 1)
            ->latest()->take(10)->get();
        // Lấy sản phẩm liên quan nếu có
        $relatedPro = !empty($titleCate->related_pro) ? $titleCate->getRelatedPro() : null;

        // Lấy ảnh chính cho từng sản phẩm
        if(!empty($relatedPro)) {
            $relatedPro->each(function ($productImg) {
                $productImg->main_image = $productImg->getMainImage(); // Thêm ảnh chính vào đối tượng sản phẩm
            });
        }

        return view('cntt.home.blogs.childBlog', compact(
            'titleSeo', 'keywordSeo', 'descriptionSeo',
            'cateMenu', 'titleCate', 'news',
            'viewer', 'outstand', 'allParents'
        ));
    }

    public function author()
    {
        $users = User::select('id', 'name', 'slug', 'content', 'image', 'title_img', 'alt_img',
            'facebook', 'twitter', 'instagram', 'skype', 'linkedin')
            ->whereHas('roles')
            ->with('roles')->latest()->paginate(10);

        // Seo website
        $titleSeo = 'Author at Nvidiavn';
        $keywordSeo = 'author';
        $descriptionSeo = 'Author at Nvidiavn';

        // Nếu số trang hiện tại vượt quá số trang cuối cùng, điều chỉnh trang hiện tại về trang cuối cùng
        if ($users->currentPage() > $users->lastPage()) {
            // Lấy dữ liệu của trang cuối cùng
            $user = User::select('id', 'name', 'slug', 'content', 'image', 'title_img', 'alt_img',
            'facebook', 'twitter', 'instagram', 'skype', 'linkedin')
                ->whereHas('roles')
                ->with('roles')
                ->latest()
                ->paginate(10, ['*'], 'page', $users->lastPage());
        }

        $cateMenu = CategoryNew::select('name', 'slug')->orderBy('stt_new', 'ASC')
            ->where('is_public', 1)
            ->where('slug', '<>', 'blogs')->get();
        $viewer = News::select('name', 'slug')
            ->orderBy('view_count', 'DESC')
            ->take(10)->get();

        return view('cntt.home.blogs.author', compact(
            'titleSeo', 'keywordSeo', 'descriptionSeo',
            'cateMenu', 'viewer', 'users'
        ));
    }

    public function inforAuthor($slug)
    {
        $user = User::select('id', 'name', 'slug', 'content', 'image', 'title_img', 'alt_img',
            'facebook', 'twitter', 'instagram', 'skype', 'linkedin')
            ->where('slug', $slug)->first();
        if(empty($user)) {
            abort(404, 'URL không hợp lệ');
        }
        // Seo website
        $titleSeo = $user->name . ' - Author at Nvidiavn';
        $keywordSeo = $user->name;
        $descriptionSeo = $user->name . ' - ' . $user->alt_img;
        
        $cateMenu = CategoryNew::select('name', 'slug')->orderBy('stt_new', 'ASC')
            ->where('is_public', 1)
            ->where('slug', '<>', 'blogs')->get();

        $newAll = News::select('name', 'slug', 'desc', 'view_count', 'image', 'alt_img', 'title_img', 'user_id', 'created_at')
            ->with('user:id,name') // Eager load quan hệ user với các cột cần thiết
            ->where('user_id', $user->id)
            ->latest()->paginate(10);
        // Nếu số trang hiện tại vượt quá số trang cuối cùng, điều chỉnh trang hiện tại về trang cuối cùng
        if ($newAll->currentPage() > $newAll->lastPage()) {
            // Lấy dữ liệu của trang cuối cùng
            $newAll = News::select('name', 'slug', 'desc', 'view_count', 'image', 'alt_img', 'title_img', 'user_id', 'created_at')
                ->with('user:id,name') // Eager load quan hệ user với các cột cần thiết
                ->where('user_id', $user->id)
                ->latest()
                ->paginate(10, ['*'], 'page', $newAll->lastPage());
        }

        $viewer = News::select('name', 'slug')
            ->where('user_id', $user->id)
            ->orderBy('view_count', 'DESC')
            ->take(10)->get();
        $outstand = News::select('name', 'slug', 'image', 'alt_img', 'title_img')
            ->where('user_id', $user->id)
            ->where('is_outstand', 1)
            ->orderBy('created_at', 'DESC')
            ->take(10)->get();

        return view('cntt.home.blogs.authorInfor', compact(
            'titleSeo', 'keywordSeo', 'descriptionSeo',
            'cateMenu', 'viewer', 'outstand', 'newAll', 'user'
        ));
    }
}
