<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use App\Libraries\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Post, App\Models\Rating_Product, App\Models\Page, App\Models\Join_Category_Post, App\Models\Category, App\Models\Theme, App\Models\Join_Category_Theme, App\Models\Category_Theme, App\Models\Variable, App\Models\Theme_variable_sku_value, App\Models\Theme_variable_sku, App\Models\Brand, App\Models\Slider, App\Models\Sponser, App\Models\Addtocard, App\Models\Addtocard_Detail, App\Models\Video_page, App\Models\Discount_code, App\Models\Admin;
use Auth;
use Illuminate\Support\Facades\Hash;

class AjaxController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function ajax_delete(Request $rq){
        $type = $rq->type;
        $check_data = $rq->seq_list;
        $arr = array();
        $values = "";
        for($i=0;$i<count($check_data);$i++):
            $values .= (int)$check_data[$i].",";
            $arr[]=(int)$check_data[$i];
        endfor;
        $groupID = substr($values, 0, -1);
        switch ($type) {
            case 'video':
                //xóa thumbnail
                $url_upload = $_SERVER['DOCUMENT_ROOT'].'/images/videos/';
                foreach ($arr as $it) {
                    $data_page = Video_page::where('id', '=', $it)->get();
                    foreach ($data_page as $row) { 
                        $img = $row->thumb;
                        if($img != ''){
                            $pt = $url_upload.$img; 
                            if (file_exists($pt))
                            {
                                unlink($pt);
                            }
                        }
                    }
                }
                $loadDelete = Video_page::whereIn('id', $arr)->delete();
                return 1;
                break;
            case 'page':
                //xóa thumbnail
                $url_upload = $_SERVER['DOCUMENT_ROOT'].'/images/page/';
                foreach ($arr as $it) {
                    $data_page = Page::where('id', '=', $it)->get();
                    foreach ($data_page as $row) { 
                        $img = $row->thubnail;
                        if($img != ''){
                            $pt = $url_upload.$img; 
                            if (file_exists($pt))
                            {
                                unlink($pt);
                            }
                        }
                    }
                }
                $loadDelete = Page::whereIn('id', $arr)->delete();
                return 1;
                break;
            case 'block':
                \App\Models\BlockContent::whereIn('id', $arr)->delete();
                return 1;
                break;
            case 'post':
                Post::whereIn('id', $arr)->delete();
                \App\Models\PostCategoryJoin::whereIn('post_id', $arr)->delete();
                return 1;
                break;
            case 'category':
                Category::whereIn('id', $arr)->delete();
                return 1;
                break;
            case 'product':
                \App\Models\ShopProduct::whereIn('id', $arr)->delete();
                \App\Models\ShopProductCategory::whereIn('product_id', $arr)->delete();
                if(count($arr))
                {
                    foreach($arr as $post_id)
                    {
                        $features_old = \App\Models\ShopProductItem::where('product_id', $post_id)->select()->pluck('id');
                        \App\Models\ShopProductItemFeature::whereIn('product_item_id', $features_old)->delete();
                        \App\Models\ShopProductItem::where('product_id', $post_id)->delete();
                    }
                }

                return 1;
                break;
            case 'product-category':
                \App\Models\ShopCategory::whereIn('id', $arr)->delete();
                foreach ($arr as $it) {
                    \App\Models\ShopCategory::where('parent', $it)->update(['parent' => 0]);
                }
                \App\Models\ShopProductCategory::whereIn('category_id', $arr)->delete();
                return 1;
                break;
            case 'category_product':
                \App\Models\ShopCategory::whereIn('id', $arr)->delete();
                \App\Models\ShopProductCategory::whereIn('category_id', $arr)->delete();
                return 1;
                break;
            case 'user_admin':
                //xóa user admin
                $loadDelete = Admin::whereIn('id', $arr)->delete();

                //delete products
                $productDelete = Theme::all();
                if($loadDelete){
                  foreach($productDelete as $value){
                    foreach($arr as $value_id){
                     if($value->admin_id==$value_id){
                        $value->delete();
                        break;
                    }
                } 
            }//foreach
        }
        return 1;
        break;
            case 'order':
                $loadDelete = Addtocard::whereIn('cart_id', $arr)->delete();
                $addToCardDelete = Addtocard_Detail::whereIn('cart_id', $arr)->delete();
                return 1;
                break;
            case 'variable_product':
                $loadDelete = Variable::whereIn('id', $arr)->delete();
                return 1;
                break;
            case 'brand':
                //xóa thumbnail
                $url_upload = $_SERVER['DOCUMENT_ROOT'].'/images/brand/';
                foreach ($arr as $it) {
                    $data_brand = Brand::where('brandID', '=', $it)->get();
                    foreach ($data_brand as $row) { 
                        $img = $row->brandThumb;
                        if($img != ''){
                            $pt = $url_upload.$img; 
                            if (file_exists($pt))
                            {
                                unlink($pt);
                            }
                        }
                    }
                }
                $loadDelete = Brand::whereIn('brandID', $arr)->delete();
                return 1;
                break;
            case 'slider':
                //xóa thumbnail
                $url_upload = $_SERVER['DOCUMENT_ROOT'];
                foreach ($arr as $it) {
                    $data_slider = Slider::where('id', $it)->get();
                    foreach ($data_slider as $row) { 
                        $img_pc = $row->src;
                        if($img_pc != ''){
                            $pt = $url_upload.$img_pc; 
                            if (file_exists($pt))
                            {
                                unlink($pt);
                            }
                        }

                        $img_mobile = $row->src_mobile;
                        if($img_mobile != ''){
                            $pt = $url_upload.$img_mobile; 
                            if (file_exists($pt))
                            {
                                unlink($pt);
                            }
                        }
                    }
                }
                $loadDelete = Slider::whereIn('id', $arr)->delete();
                return 1;
                break;
            case 'sponser':
                //xóa thumbnail
                $url_upload = $_SERVER['DOCUMENT_ROOT'];
                foreach ($arr as $it) {
                    $data_slider = Sponser::where('id', '=', $it)->get();
                    foreach ($data_slider as $row) { 
                        $img_pc = 'images/sponser/'.$row->thumbnail;
                        if($img_pc != ''){
                            $pt = $url_upload.$img_pc; 
                            if (file_exists($pt))
                            {
                                unlink($pt);
                            }
                        }
                    }
                }
                $loadDelete = Sponser::whereIn('id', $arr)->delete();
                return 1;
                break;
            case 'discount-code':
                $loadDelete = Discount_code::whereIn('id', $arr)->delete();
                return 1;
                break;
                case 'discount-code':
                $loadDelete = Discount_code::whereIn('id', $arr)->delete();
                return 1;
                break;
            case 'rating':
                    $loadDelete = \App\Plugins\Cms\ProductReview\Models\PluginModel::whereIn('id', $arr)->delete();
                    return 1;
                    break;
            case 'search_history':
                $histories = \App\Models\ChiSoTraCuuView::whereIn('id', $arr)->get();
                if($histories->count())
                {
                    foreach($histories as $item)
                    {
                        $pdf_path = public_path('pdf/tracuu_'. $item->id .'.pdf');
                        if(is_file($pdf_path))
                            unlink($pdf_path);

                        \App\Models\ChiSoTraCuuView::find($item->id)->delete();
                    }
                }
                return 1;
                break;
            case 'type':
                \App\Models\ShopType::whereIn('id', $arr)->delete();
                return 1;
                break;
            case 'subscription':
                \App\Models\User_register_email::whereIn('id', $arr)->delete();
                return 1;
                break;

            case 'email_template':
                \App\Models\ShopEmailTemplate::whereIn('id', $arr)->delete();
                return 1;
                break;


            default:
                # code...
                break;
        }
    }

    public function processThemeFast(Request $request){
        $id = (int)$request->id;
        $origin_price = $request->origin_price;
        $promotion_price = $request->promotion_price;
        // $order_short = $request->order_short;
        $start_event = $request->start_event;
        $end_event = $request->end_event;
        if($id>0):
            $data = array(
                'price_origin' => $origin_price,
                'price_promotion' => $promotion_price,
                // 'order_short' => $order_short,
                'start_event' => $start_event,
                'end_event' => $end_event,
                'updated' => date('Y-m-d H:i:s')
            );
            $respons =Theme::where ("id","=",$id)->update($data);
            echo 'OK';
        else:
            echo 'Lỗi';
        endif;
        exit();
    }

    public function update_new_item_status(Request $request){
        if(isset($request['check']) && $request['sid']!=""):
            $status = $request['check'];
            $postID = (int)$request['sid'];
            if($postID>0):
                $respons1 = Theme::where ("id","=",$postID)->update(array('item_new'=>$status));
                echo "OK";
            else:
                echo "Lỗi";
            endif;
        endif;
    }

    public function update_process_flash_sale(Request $request){
        if(isset($request['check']) && $request['sid']!=""):
            $status=$request['check'];
            $postID=(int)$request['sid'];
            if($postID>0):
                $respons1 = Theme::where ("id","=",$postID)->update(array('flash_sale'=>$status));
                echo "OK";
            else:
                echo "Lỗi";
            endif;
        endif;
    }

    public function update_process_sale_top_week(Request $request){
        if(isset($request['check']) && $request['sid']!=""):
            $status=$request['check'];
            $postID=(int)$request['sid'];
            if($postID>0):
                $respons1 = Theme::where ("id","=",$postID)->update(array('sale_top_week'=>$status));
                echo "OK";
            else:
                echo "Lỗi";
            endif;
        endif;
    }

    public function update_process_propose(Request $request){
        if(isset($request['check']) && $request['sid']!=""):
            $status=$request['check'];
            $postID=(int)$request['sid'];
            if($postID>0):
                $respons1 = Theme::where ("id","=",$postID)->update(array('propose'=>$status));
                echo "OK";
            else:
                echo "Lỗi";
            endif;
        endif;
    }

    public function updateStoreStatus(Request $request){
        if(isset($request['check']) && $request['sid'] != ""):
            $status = $request['check'];
            $postID = (int)$request['sid'];
            if($postID > 0):
                $respons1 = Theme::where ("id", "=", $postID)->update(array('store_status' => $status));
                echo "OK";
            else:
                echo "Lỗi";
            endif;
        endif;
    }

    public function loadVariable(){
        $result="";
        $child_parent=array();
        $slug_variable_parrent="";
        $group_child=array();
        $html_col_header="";
        $datas = json_decode(stripslashes($_POST['data']));
        $id_key_parent="";
        $count_item=count($datas);
        if($datas && count($datas)>0):
            $mh=0;
            for($i=0; $i<count($datas); $i++):
                $mh++;
                $variable_child="";
                $key_child="";
                $array_child=array();
                $variable_id=(int)$datas[$i];
                if($variable_id>0):
                    $variables=Variable_Theme::where('id',$variable_id)
                    ->where('status',0)
                    ->first();
                    if($variables):
                        $slug_variable_parrent=$variables->slug;
                        $variable_childs=Variable_Theme::where('parent',$variable_id)
                            ->where('status',0)
                            ->get();
                        if($variable_childs):
                            $html_col_header .='<div class="table-cell readonly">'.$variables->variable_theme_name.'</div>';
                            $id_key_parent .=$variables->variable_themeID.",";
                            foreach ($variable_childs as $variable_child):
                                $key_child=$variable_child->variable_theme_slug;
                                //$array_key[$key_child]=array($variable_child->variable_theme_name);
                                $array_child[$key_child]=$variable_child->variable_theme_name."_".$variable_child->variable_themeID;
                                $group_child=$array_child;
                            endforeach;
                        endif;
                    endif;
                endif;
                $child_parent[$slug_variable_parrent] =$group_child;
            endfor;
            //print_r($child_parent);
            $array_fitters=Helpers::variations($child_parent);
            if($array_fitters && count($array_fitters)>0):
                    $id_key_parent=substr($id_key_parent, 0, -1);
                    //print_r($array_fitters);
                    $result .='<input type="hidden" name="parent_variable_group" value="'.$id_key_parent.'"/>
                    <div class="edit-main variation-table">
                        <div class="table-header">
                            <input type="hidden" name="number_parent_variable" id="number_parent_variable" value="'.$mh.'"/>
                            '.$html_col_header.'
                            <div class="table-cells">
                                <div class="table-cell">Giá</div>
                                <div class="table-cell table-cell-two">Image</div>
                            </div>
                        </div>
                        <div class="table-body">';
                            $explode_ex=array();
                            for($m=0;$m<count($array_fitters);$m++):
                                $result .='<div class="table-row">';
                                $k=0;
                                foreach ($array_fitters[$m] as $key => $value):
                                    $k++;
                                    $explode_ex = explode("_", $value);
                                    $result .='<div class="table-cell readonly">'.$explode_ex[0].'</div><input type="hidden" name="variable_'.$m.$k.'" value="'.$explode_ex[1].'">';
                                endforeach;
                                $result .='<div class="table-cells">
                                        <div class="table-cell">
                                            <div class="anhduong-input__prefix">₫<span class="anhduong-input__prefix-split"></span><!----><!----></div>
                                            <input type="text"  class="anhduong-input__input form-control" name="price_aviable_'.$m.'">
                                        </div>
                                        <div class="table-cell table-cell-two">
                                            <div class="group_variable_images clear">
                                                <div class="inside clear">
                                                    <div class="text_input_file_image_variable">
                                                        <input class="myfile_gallery_store_select form-control" type="text" value="" size="50" placeholder="Hình ảnh" name="text_upload_gallery_variable_'.$m.'">
                                                    </div>
                                                    <div class="mybutton_upload_img">
                                                        <input class="upload_gallery_variable_select" type="file"  id="upload_gallery_variable_'.$m.'" name="upload_gallery_variable_'.$m.'">UP
                                                    </div>
                                                </div><!--inside-->
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                            endfor;
                            $result .='<input type="hidden" name="count_item_list" value="'.$m.'"/>
                        </div>
                    </div>';
            else:
                $result ="";
            endif;
        else:
            $result ="";
        endif;
        return $result;
    }

    public function checkPassword(Request $request){
        $current_password = $request->current_password;
        if(!Hash::check($request->current_password, Auth::guard('admin')->user()->password)){
            echo 'Mật khẩu hiện tại không chính xác';
        }
        else{
            //echo 'Mật khẩu chính xác';
        }
    }
}
