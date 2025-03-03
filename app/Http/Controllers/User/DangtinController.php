<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

use App\Models\ShopProduct;
use App\Models\ShopProductDescription;
use App\Models\ShopCategory;
use App\Models\User;
use App\Models\ShopProductContact;
use App\Models\ShopOption;

class DangtinController extends Controller
{

    use \App\Traits\LocalizeController;
    
    public $data = [];

    public function index() {
        // session()->forget('category_selected');
        $user = auth()->user();
        if($user->type == 2 && request('post_type') == 'sell')
            return redirect()->back();
        
        $data = [
            'seo_title' => 'Đăng tin',
            'categories'    => (new \App\Admin\Models\AdminShopCategory)->getTreeCategoriesAdmin(),
            'provinces' => \App\Models\LocationProvince::get(),
            'countries' => \App\Models\LocationCountry::get(),
            'user'  => $user
        ];
        if(session('category_selected') != null)
        {
            $category = (new ShopCategory)->getDetail(session('category_selected'));

            if(!$category)
                session()->forget('category_selected');
            else
            $data['category'] = $category;
        }
        // dd($data);
        if(auth()->user()->type != 3)
            return view($this->templatePath .'.dangtin.index', $data);
        else
            return view($this->templatePath .'.dangtin.deny');
    }

    public function package(Request $request)
    {
        $request_all = $request->all();
        // dd($request_all);
        $this->data['package_current'] = \App\Model\Package::find($request_all['package']);
        $this->data['hot'] = $request_all['hot'];
        $this->data['duration'] = $request_all['duration'];
        $this->data['date_start'] = $request_all['date_start'];
        $this->data['date_end'] = $request_all['date_end'];
        // $view = view('theme.dangtin.form.post_type', ['data'=>$this->data])->render();
        $this->data['duration_view'] = view('theme.dangtin.form.duration', ['data'=>$this->data])->render();
        $this->data['price_post_view'] = view('theme.dangtin.form.price_post', ['data'=>$this->data])->render();
        return response()->json($this->data);
    }

    public function editPost($id)
    {
        $product = (new ShopProduct)->getDetail($id, '', 0);
        if($product!='' && $product->user_id == auth()->user()->id)
        {
            $categories = $product->getCategories();
            if($categories)
                $category_current = end($categories);

            if(session()->has('category_selected_change'))
                $category   = (new ShopCategory)->getDetail(session()->get('category_selected_change'));
            else
                $category   = (new ShopCategory)->getDetail($category_current['id']??0);

            if(!session()->has('category_selected'))
            {
                session()->put('category_selected', $category_current['id']??0);
            }
            session()->forget('category_selected_change');
            if(!$category)
                session()->forget('category_selected');

            $catalogues = $product->getCatalogue()->where('type', 'catelogue')->get();
            $certificates = $product->getCatalogue()->where('type', 'certificate')->get();
            // dd($catalogues);

            $data = [
                'product' => $product,
                'catalogues' => $catalogues,
                'certificates' => $certificates,
                'category' => $category,
                'categories' => $product->categories,
                'user'  => auth()->user(),
                'seo'   => [
                    'seo_title' => 'Sửa tin '. $product->name??($product->sku??'')
                ]
            ];
            return view($this->templatePath .'.dangtin.index', $data);
        }
        else
            return view('errors.404');
    }

    function check_base64_image($base64) {
        $img = imagecreatefromstring($base64);

        if (!$img) {
            return false;
        }

        $size = getimagesizefromstring($data);

        if (!$size || $size[0] == 0 || $size[1] == 0 || !$size['mime']) {
            return false;
        }

        return true;
    }
    public function post(Request $request)
    {
        $user = auth()->user();
        $data = request()->all();

        $status = 2; // chờ duyệt và chờ thanh toán - do ko du tien thanh toan, edit bai dang

        $title = htmlspecialchars($data['title']??'');
        $dataStore = [
            'slug' => !empty($data['title'])?Str::slug($title):'',
            'price' => !empty($data['price']) ? str_replace(',', '', $data['price']) : 0,
            'price_max' => !empty($data['price_max']) ? str_replace(',', '', $data['price_max']) : 0,
            'cost' => !empty($data['cost']) ? str_replace(',', '', $data['cost']) : 0,
            'user_id' => $user->id,
            'address' => $data['address']??'',
            'address1' => $data['province']??'',
            'address2' => $data['district']??'',
            'address3' => $data['ward']??'',
            'address_end' => $data['address_end']??'',
            'address_full' => $data['address_full']??'',
            'stock' => $data['stock']??0,
            'acreage' => $data['acreage']??0,
            'status' => $status,
            'post_type' => $data['post_type']??'', //buy/sell
            'country_manufacture' => $data['country_manufacture']??'', //nuoc sx
        ];
        if(!empty($data['date_available']))
            $dataStore['date_available'] = date('Y-m-d', strtotime(str_replace('/','-', $data['date_available'])));

        if(!empty($data['location_origin']))
        {
            $location_origin = sc_location_convert($data['location_origin']);
            $dataStore['country'] = $location_origin['country']??'';
            $dataStore['address1'] = $location_origin['address1']??'';
            $dataStore['address2'] = $location_origin['address2']??'';
            $dataStore['address3'] = $location_origin['address3']??'';
            $dataStore['address'] = $location_origin['address']??'';
        }
        // dd($data);
        if(!$data['id'] && $user->countEndDate())
        {
            $dataStore['package_id'] = $user->package_id??0;
        }
        // dd($user->countEndDate());
        
        $product = ShopProduct::updateOrCreate(
            [
                'id' => $data['id']??0
            ],
            $dataStore
        );
        if($product)
        {
            if($data['id'])
            {
                $product->descriptions()->delete();
                $product->categories()->detach();
                $product->options()->delete();
            }

            if(!empty($data['option']) && count($data['option']))
            {
                $product->createOption($data['option']);
            }

            $dataDes = [
                'post_id' => (int)$product->id,
                'lang' => 'vi',
                'name' => $title??'',
                'description' => htmlspecialchars($data['content']??''),
                'content' => htmlspecialchars($data['content'] ?? ''),
            ];
            ShopProductDescription::create($dataDes);

            $product_sku = date('Y') . $product->id;
            $gallery = [];

            if(!empty($data['gallery']))
            {
                $gallery_reponse = $this->upGallery($data['gallery']);
                // dd($gallery_reponse);
                $gallery = $gallery_reponse['gallery'];
            }
            if(!empty($data['catalogue_file']))
            {
                $catalogue_files = $this->upFile($data['catalogue_file']);
                $product->createCatalogue($catalogue_files);
            }
            if(!empty($data['certificate_file']))
            {
                $catalogue_files = $this->upFile($data['certificate_file']);
                $product->createCatalogue($catalogue_files, 'certificate');
            }

            $gallery_old = $data['gallery_old']??[];
            // dd($gallery_old);
            $galleries  = [];
            if($product->gallery)
            {
                if(count($gallery_old))
                {
                    $galleries = unserialize($product->gallery);
                    $gallery_old = array_map('intval', $data['gallery_old']);
                    
                    foreach($galleries as $key => $item)
                    {
                        if(!in_array($key, $gallery_old))
                            unset($galleries[$key]);
                    }
                }
                
            }
            // dd('fdà');

            //remove gallery
            $img_remove = $request->img_remove;
            if(is_array($img_remove)){
                foreach($img_remove as $img){
                    $key = array_search($img, $galleries);
                    unset($galleries[$key]);
                }
            }
            if(is_array($galleries)){
                $galleries = array_merge($galleries, $gallery);
            }
            else
                $galleries = $gallery;

            // dd($galleries);
            $gallery_list = $galleries ? serialize($galleries) : '';
            $product->update([
                'gallery' => $gallery_list ?? '',
                'sku' => $product_sku,
                'image' => $galleries[0] ?? '',
            ]);

            if(!empty($data['category']))
            {                
                $category = (new ShopCategory)->getDetail($data['category']);
                // $arr_category = [$category->id];
                $product->categories()->attach($category);
                $category_parents = (new ShopCategory)->getParentList($category->parent);
                $category_parents = array_reverse($category_parents);
                foreach($category_parents as $item)
                {
                    $product->categories()->attach($item->id);
                }
                
                
            }

            session()->forget('category_selected');
            // return redirect(route('dangtin.success'));
            $view = view($this->templatePath .'.dangtin.includes.success', compact('product'))->render();
            return response()->json([
                'error' => 0,
                'view'  => $view,
                'message'   => 'Success'
            ]);
        }
    }

    function service()
    {
        $user = auth()->user();
        $data = [
            'seo_title' => 'Đăng tin dich vu',
            'user' => $user,
            'user_company' => $user->getCompany,
            'categories'    => (new ShopCategory)->getList([]),
            'provinces' => \App\Models\LocationProvince::get()
        ];
        return view($this->templatePath .'.dangtin.service', $data);
    }
    function postservice()
    {
        $user = auth()->user();
        
        $data = request()->all();
        dd($data);
    }

    public function upGallery($files)
    {

        $folderPath = 'upload/post/';
        $year = date('Y');
        $m = date('m');
        $dir = $folderPath . $year;
        $dir_m = $folderPath . $year.'/'.$m;

        if (is_dir(public_path($dir)) === false) {
            mkdir(public_path($dir));
        }
        if (is_dir(public_path($dir_m)) === false) {
            mkdir(public_path($dir_m));
        }

        $image = '';
        foreach ($files as $key => $file) {
            $filename_original = $file->getClientOriginalName();

            $filename_ = pathinfo($filename_original, PATHINFO_FILENAME);
            $extension_ = pathinfo($filename_original, PATHINFO_EXTENSION);

            $file_slug = Str::slug($filename_);
            $file_name = uniqid(). '-' . $file_slug . '.' . $extension_;
            $img_name = '/' . $dir_m . '/' . $file_name;
            $gallery[] = $img_name;

            // dd($file->getRealPathgetPathname());
            $image_resize = Image::make($file->getPathname());
            /* insert watermark at bottom-right corner with 10px offset */
            $image_resize->insert(public_path('theme/images/logo-text-white.png'), 'center-center', 0, 0);

            $image_resize->save( public_path($dir_m.'/'.$file_name) );
            if($image == '')
                $image = $img_name;
        }

        return [
            'gallery'   => $gallery??[],
            'image'   => $image
        ];
    }

    public function upFile($files)
    {
        $folderPath = 'upload/files/';
        $year = date('Y');
        $m = date('m');
        $dir = $folderPath . $year;
        $dir_m = $folderPath . $year.'/'.$m;
        if (is_dir($dir) === false) {
            mkdir($dir);
        }
        if (is_dir($dir_m) === false) {
            mkdir($dir_m);
        }

        foreach ($files as $key => $file) {
            $filename_original = $file->getClientOriginalName();
            $filename_ = pathinfo($filename_original, PATHINFO_FILENAME);
            $extension_ = pathinfo($filename_original, PATHINFO_EXTENSION);

            $file_slug = Str::slug($filename_);
            $file_name = uniqid(). '-' . $file_slug . '.' . $extension_;
            $img_name = '/' . $dir_m . '/' . $file_name;
            $gallery[] = $img_name;
            
            $file->move($dir_m, $file_name);
        }
        return $gallery??[];
    }

    public function success()
    {
        return view($this->templatePath .'.dangtin.success');
    }

    function categorySelect()
    {
        $id = request()->id;
        $category = (new ShopCategory)->getDetail($id);
        if($category)
        {
            $category = (new ShopCategory)->getDetail($id);

            session()->put('category_selected', $category->id);
            session()->put('category_selected_change', $category->id);
        }
        return response()->json([
            'error' => 0,
            'message'   => 'Success'
        ]);
    }

    /*public function getPostTypeContent()
    {
        $data = request()->all();
        $id = $data['id'];
        $post_type = $data['post_type'];
        $category_id = session('category_selected')??0;

        $view 
    }*/
}
