<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Gornymedia\Shortcodes\Facades\Shortcode;

use App\Models\ShopProduct;
use App\Models\ShopCategory;
use App\Models\User;
use App\Models\Wishlist;
use App\Models\Page;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    use \App\Traits\LocalizeController;
    public $data = [];
    public $view_path;

    public function __construct()
    {
        parent::__construct();
        $this->view_path = $this->templatePath .'.product';
    }

    public function category($slug, $slug_sub='')
    {
        sc_statistical_log();

        $data = request()->all();
        
        $category = (new ShopCategory)->getDetail($slug, "slug");
        if($category)
        {
            $category_id = $category->id;
            
            $category_sub = (new ShopCategory)->getDetail($slug_sub, "slug");
            
            
            if($category_sub)
            {
                $category_id = $category_sub->id;
                $category_sub_name = $category_sub->name;
            }

            if($slug_sub == 'Chao-gia')
                $category_sub_name = 'Chào giá';
            elseif($slug_sub == 'yeu-cau-chao-gia')
                $category_sub_name = 'Yêu cầu chào giá';
            elseif($slug_sub == 'hang-nhap-khau')
                $category_sub_name = 'Hàng nhập khẩu';

            $category_id = request('category')??$category_id;

            $categories = (new ShopCategory)->getList(['parent' => $category->id]);

            $dataReponse = [
                'slug'  => $slug,
                'slug_sub'  => $slug_sub,
                'category'  => $category,
                'category_sub'  => $category_sub,
                'categories'  => $categories,
                'category_id'  => $category_id,
                'url_action_filter'  => route('product.filter_ajax', ['slug' => $slug, 'slug_sub' => $slug_sub]),
                'countries' => \App\Models\LocationCountry::orderBy('sort', 'asc')->get(),
                'seo_title' => $category->seo_title!=''? $category->seo_title : $category->name . ' '. ($category_sub_name??''),
                'seo_image' => asset($category->image),
                'seo_description'   => $category->seo_description ?? '',
                'seo_keyword'   => $category->seo_keyword ?? '',
            ];


            $templateCategory_path = $this->view_path . ".$slug.index"; // goi index cua danh muc cha
            $templateCategorySub_path = $this->view_path .".$slug.$slug_sub"; // goi blade view danh muc sub

            if($slug_sub == 'cong-ty-logistic')
            {
                $page = (new Page)->getDetail('cong-ty-logistic', 'slug');
                $user_role = \App\Models\UserRole::where('slug', 'logistic')->first();
                if($user_role)
                    $dataReponse['customers'] = User::where('role', $user_role->id)->paginate(20);

                $dataReponse['seo_title'] = $page->name??'';
                $dataReponse['seo_image'] = asset($page->image??'');
                
                if (View::exists($templateCategorySub_path))
                {

                    return view($templateCategorySub_path, $dataReponse)->compileShortcodes();
                }
                else
                {
                    return view($this->view_path .'.content', $dataReponse)->compileShortcodes();
                }
            }

            if(request('type_get') != 'ajax')
            {
                $dataReponse['category_folder'] = $this->view_path . ".$slug";

                if (View::exists($templateCategorySub_path))
                    $dataReponse['category_path'] = $templateCategorySub_path;
                elseif (View::exists($templateCategory_path))
                    $dataReponse['category_path'] = $templateCategory_path;

                if($slug_sub)
                {
                    $option = \App\Models\ShopOption::get();
                    foreach($option as $item)
                    {
                        $item_slug = Str::slug($item->name);
                        if($item_slug == $slug_sub)
                        {
                            // dd($item_slug);
                            $dataReponse['seo_title'] = $dataReponse['seo_title'] . ' - '. $item->name;
                            break;
                        }

                    }
                }

                // dd($dataReponse);
                return view($this->view_path .'.category', $dataReponse)->compileShortcodes();
            }
            else //filter ajax
            {
                return $this->filterAjax($data, $category, $category_id);
            }
        }
        else
            return $this->product($slug);
    }

    public function product($slug)
    {
        sc_statistical_log();
        $product = (new ShopProduct)->getDetail($slug, $type="slug");
        // dd($product);

        if($product)
        {
            $categories = $product->getCategories();
            // dd($categories);
            $category_main = current($categories);
            $category_main = (new ShopCategory)->getDetail($category_main['id']);

            $category_end = end($categories);
            $category = (new ShopCategory)->getDetail($category_end['id']);

    
            $dataReponse = [
                'customer'  => $product->getAuth,
                'categories'  => $categories,
                'category_main'  => $category_main,
                'category'  => $category,
                'product'  => $product,
                'options'  => $product->getOptions(),
                'galleries'  => $product->getGallery(),
                'languages' => \App\Models\ShopLanguage::getListActive(),
                'seo' => $product->getSeo()
            ];
            // dd($dataReponse);
            $view_path = $this->view_path . '.' . $category_main->slug . '.single';
            if (View::exists($view_path))
                return view($view_path, $dataReponse);
            else
                return view($this->view_path .'.single', $dataReponse);
            
        }
        else
            return view('errors.404');
    }

    public function filterAjax($data, $category, $category_id='')
    {
        // $data = request()->all();
        $url_current = $data['url_current'];
        $parent_id = $data['category_parent']??0;
        unset($data['url_current']);
        unset($data['type_get']);
        unset($data['category_parent']);

        $dataSearch = array_merge($data, [
            'sort_order'    => 'created_at__desc',
            'post_type'    => $data['post_type']??'',
        ]);
        // dd($dataSearch);

        $parameter = array_filter($data);
        if($parameter)
        {
            $parameter = http_build_query($parameter, '', '&' );
        }
        else
            $parameter = '';
            $products = (new ShopProduct);

            if(!empty($data['category']) && $data['category'] != '')
            {
                $category_parent[] = (int)$data['category'];
            }
            elseif($parent_id)
                $category_parent[] = (int) $parent_id;
            
            $products = $products->setCategory($category_parent);
            
            $products = $products->getList($dataSearch);
            // dd($dataSearch);
            $templateName = $this->templatePath .".product.$category->slug.product-list";

            $cate_ = (new ShopCategory)->getDetail($parent_id);
            $slug = $category->slug;
            $slug_sub = '';
            
            if($parent_id != $category->id)
            {
                $slug_sub = $cate_->slug;
            }
            $categories = (new ShopCategory)->getList(['parent' => $category->id]);
            $category_sub = (new ShopCategory)->getDetail($slug_sub, "slug");

            $templateCategory_path = $this->view_path . ".$slug.index"; // goi index cua danh muc cha
            $templateCategorySub_path = $this->view_path .".$slug.$slug_sub"; // goi blade view danh muc sub

            $dataReponse = [
                'products'  => $products,
                'transportation'  => $data['transportation']??'',
                'slug'  => $slug,
                'slug_sub'  => $slug_sub??'',
                'category'  => $category,
                'category_sub'  => $category_sub,
                'categories'  => $categories,
                'category_folder' => $this->view_path . ".$slug",
                'url_action_filter'  => route('product.filter_ajax', ['slug' => $slug, 'slug_sub' => $slug_sub]),
            ];

            // dd($dataReponse);
            if (View::exists($templateCategorySub_path))
            {
                $dataReponse['category_path'] = $templateCategorySub_path;
                $view = view($templateCategorySub_path, $dataReponse)->render();
            }
            elseif (View::exists($templateCategory_path))
            {
                $dataReponse['category_path'] = $templateCategory_path;
                $view = view($templateCategory_path, $dataReponse)->render();
            }
            else
                $view = view($this->templatePath .'.product.product_list', $dataReponse)->render();

            return response()->json([
                'error' => 0,
                'view'  => $view,
                'url'   => $url_current ."?$parameter",
                'message'   => 'Success'
            ]);
        
    }

    function search()
    {
        $data = request()->all();
        $products = new ShopProduct;
        if(request('category'))
        {
            $category = ShopCategory::find(request('category'));
            return redirect(sc_route('product', ['slug' => $category->slug, 'keyword' => $data['keyword']??'']));
            // $products = $products->setCategory(request('category'));
        }

        $products = $products->getList([
            'keyword'   => $data['keyword']??'',
            'category'   => $data['keyword']??''
        ]);
        // dd($products);
        $categories = (new ShopCategory)->getList([]);
        $dataReponse = [
            'categories'  => $categories,
            'products'  => $products,
            'languages' => \App\Models\ShopLanguage::getListActive(),
            'seo_title' => 'Tìm kiếm',
        ];
        return view($this->view_path .'.search', $dataReponse);
    }

    public function baogia($id)
    {
        $product = (new ShopProduct)->getDetail($id);
        if(!$product)
            return redirect(url('/'));

        $dataReponse = [
            'product'   => $product,
            'user'   => User::find($product->user_id),
            'seo' => $product->getSeo()
        ];
        $dataReponse['seo']['seo_title'] = 'Yêu cầu chào giá '.$dataReponse['seo']['seo_title'];
        $dataReponse['seo']['seo_description'] = 'Yêu cầu chào giá '.$dataReponse['seo']['seo_description'];
        return view($this->templatePath .'.product.contact', $dataReponse);
    }
    public function baogiaProcess($id)
    {
        $product = (new ShopProduct)->getDetail($id);
        if(!$product)
            return redirect(url('/'));

        $data = request()->all();
        $data['product_id'] = $id;
        $data['user_id'] = auth()->user()->id;
        
        $contact = (new \App\Models\ShopContact)->createContact($data);
        if($contact)
            return redirect(url('van-chuyen/yeu-cau-chao-gia'))->with(['message' => 'Gửi yêu cầu chào giá thành công']);
    }

    public function savePost(Request $request)
    {
        $this->localized();

        $id = $request->id;
        $type = 'save';
        if(auth()->check())
        {
            $user = auth()->user();
            $data_db = array(
                'product_id' => $id,
                'user_id' => $user->id,
            );

            $db = Wishlist::where('product_id', $id)->where('user_id', $user->id)->first();
            if($db != ''){
                $db->delete();
                $type = 'remove';
            }
            else
                Wishlist::create($data_db)->save();

            $count_wishlist = Wishlist::where('user_id', $user->id)->count();
            $this->data['count_wishlist'] = $count_wishlist;
            $this->data['status'] = 'success';
        }
        else{
            $wishlist = json_decode(\Cookie::get('wishlist'));
            $key = false;
            

            if($wishlist != '')
                $key = array_search( $id, $wishlist);
            if($key !== false){
                unset($wishlist[$key]);
                $type = 'remove';
            }
            else{
                $wishlist[] = $id;
            }
            $this->data['count_wishlist'] = count($wishlist);
            $this->data['status'] = 'success';
            $cookie = \Cookie::queue('wishlist', json_encode($wishlist), 1000000000);
        }
        $this->data['type'] = $type;
        $this->data['view'] = view($this->templatePath .'.product.includes.wishlist-icon', ['type'=>$type, 'id'=>$id])->render();
        
        return response()->json($this->data);
    }

    //xem bai viet cua thanh vien
    public function customerPost($user_id=0)
    {
        if($user_id)
        {
            $user = User::find($user_id);
            $dataReponse = [
                'seo_title' => 'Tin đăng của thành viên "'. $user->fullname .'"',
                'user'  => $user,
                'products' => (new ShopProduct)->getList([
                    'user_id' => $user_id
                ])
            ];
            
            return view($this->templatePath .'.customer.customer-post', $dataReponse);
        }
        else{
            return view('errors.404');
        }
    }
    //xem bai viet cua thanh vien
}
