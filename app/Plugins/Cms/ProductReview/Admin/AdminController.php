<?php
#App\Plugins\Cms\ProductReview\Admin\AdminController.php

namespace App\Plugins\Cms\ProductReview\Admin;

use App\Http\Controllers\RootAdminController;
use App\Plugins\Cms\ProductReview\AppConfig;
use SCart\Core\Admin\Models\AdminProduct;
use App\Plugins\Cms\ProductReview\Admin\Models\AdminProductReview;

use App\Models\ShopProductDescription;

class AdminController extends RootAdminController
{
    public $plugin;

    public function __construct()
    {
        parent::__construct();
        $this->plugin = new AppConfig;
    }

    public function index()
    {
        $data = [
            'title' => trans($this->plugin->pathPlugin.'::lang.admin.list'),
            'subTitle' => '',
            'icon' => 'fa fa-indent',
            'menuRight' => [],
            'menuLeft' => [],
            'topMenuRight' => [],
            'topMenuLeft' => [],
            'urlDeleteItem' => sc_route_admin('admin_product_review.delete'),
            'removeList' => 1, // 1 - Enable function delete list item
            'buttonRefresh' => 1, // 1 - Enable button refresh
            'buttonSort' => 1, // 1 - Enable button sort
            'css' => '', 
            'js' => '',
        ];

        $listTh = [
            'id'    => 'id',
            'date' => trans($this->plugin->pathPlugin.'::lang.date'),
            'product' => trans($this->plugin->pathPlugin.'::lang.product'),
            'customer' => trans($this->plugin->pathPlugin.'::lang.customer'),
            'point' => trans($this->plugin->pathPlugin.'::lang.point'),
            'comment' => trans($this->plugin->pathPlugin.'::lang.comment'),
            'status' => trans($this->plugin->pathPlugin.'::lang.status'),
        ];
        $sort_order = sc_clean(request('sort_order') ?? 'id_desc');
        $arrSort = [
            'id__desc' => trans($this->plugin->pathPlugin.'::lang.admin.sort_order.id_desc'),
            'id__asc' => trans($this->plugin->pathPlugin.'::lang.admin.sort_order.id_asc'),
        ];

        $dataSearch = [
            'sort_order' => $sort_order,
            'arrSort'    => $arrSort,
        ];
        $dataTmp = (new AdminProductReview)->getReviewListAdmin($dataSearch);

        $dataTr = [];
        foreach ($dataTmp as $key => $row) {
            $dataTr[] = [
                'id' => $row['id'],
                'date' => $row['created_at'] ?? date('d/m/Y H:i', $row['rate_date']),
                'product' => '<a href="'. url(AdminProduct::find($row->product_id)->alias) .'" target=_new>'. ShopProductDescription::where('product_id', $row->product_id)->first()->name .'</a>',
                'customer' => '<a href="'. ($row->customer_id ? sc_route_admin('admin_customer.edit', ['id' =>$row->customer_id]) : 'javascript:;').'" target=_new>'.$row->name.'</a>',
                'point' => $row['point'],
                'comment' => [
                    'id' => $row['id'],
                    'comment' => $row['comment'],
                    'replies' => (new AdminProductReview)->where('parent', $row['id'])->orderByDesc('id')->get()
                ],
                'status' => '<input class="change-status" name="status" data-id="'.$row['id'].'" type="checkbox" '.($row['status']?'checked':'').' >',
                
            ];
        }
        $data['listTh'] = $listTh;
        $data['dataTr'] = $dataTr;
        $data['pagination'] = $dataTmp
            ->appends(request()->except(['_token', '_pjax']))
            ->links($this->templatePathAdmin.'component.pagination');
        $data['resultItems'] = trans($this->plugin->pathPlugin.'::lang.admin.result_item', ['item_from' => $dataTmp->firstItem(), 'item_to' => $dataTmp->lastItem(), 'item_total' => $dataTmp->total()]);

        //menuSort
        $optionSort = '';
        foreach ($arrSort as $key => $status) {
            $optionSort .= '<option  ' . (($sort_order == $key) ? "selected" : "") . ' value="' . $key . '">' . $status . '</option>';
        }
        $data['urlSort'] = sc_route_admin('admin_product_review.index', request()->except(['_token', '_pjax', 'sort_order']));

        $data['optionSort'] = $optionSort;
        //=menuSort

        //menuRight
        $data['menuRight'][] = '<span data-toggle="tooltip" data-original-title="'.trans($this->plugin->pathPlugin.'::lang.status_default_help').'"><input class="check-status-mode"  name="ProductReview_status_default" type="checkbox" '.(sc_config_global('ProductReview_status_default')?'checked':'').' ></span>'.trans($this->plugin->pathPlugin.'::lang.status_default');
        //=menuRight

        $routeUpdate = sc_route_admin('admin_config_global.update');
        $routeChangeStatus = sc_route_admin('admin_product_review.update_status');
        $msgSuccess = sc_language_render('admin.msg_change_success');
        $token = csrf_token();
        $data['js'] = <<<EOT
        <script>
        $("input.change-status, input.check-status-mode").bootstrapSwitch();

        $('input.change-status').on('switchChange.bootstrapSwitch', function (event, state) {
            var valueSet;
            if (state == true) {
                valueSet =  '1';
            } else {
                valueSet = '0';
            }
            $('#loading').show();
            $.ajax({
              type: 'POST',
              dataType:'json',
              url: "$routeChangeStatus",
              data: {
                "_token": "$token",
                "id": $(this).data('id'),
                "value": valueSet
              },
              success: function (response) {
                if(parseInt(response.error) ==0){
                  alertMsg('success', '$msgSuccess');
                }else{
                  alertMsg('error', response.msg);
                }
                $('#loading').hide();
              }
            });
        }); 

        
        $('input.check-status-mode').on('switchChange.bootstrapSwitch', function (event, state) {
            var valueSet;
            if (state == true) {
                valueSet =  '1';
            } else {
                valueSet = '0';
            }
            $('#loading').show();
            $.ajax({
              type: 'POST',
              dataType:'json',
              url: "$routeUpdate",
              data: {
                "_token": "$token",
                "name": $(this).attr('name'),
                "value": valueSet
              },
              success: function (response) {
                if(parseInt(response.error) ==0){
                  alertMsg('success', '$msgSuccess');
                }else{
                  alertMsg('error', response.msg);
                }
                $('#loading').hide();
              }
            });
        }); 

        </script>
EOT;        
    
    return view('admin.review.list')->with($data);
        /*return view($this->templatePathAdmin.'screen.list')
            ->with($data);*/
    }

    /**
     * Update status
     *
     * @return  [type]  [return description]
     */
    public function updateStatus() {
        $data = request()->all();
        $id = $data['id'];
        $value = $data['value'];
        try {
            AdminProductReview::where('id', $id)
                ->update(['status' => $value]);
            $error = 0;
            $msg = sc_language_render('action.update_success');
        } catch (\Throwable $e) {
            $error = 1;
            $msg = $e->getMessage();
        }
        return response()->json([
            'error' => $error,
            'value' => $value,
            'msg'   => $msg,
            ]
        );
    }


/*
Delete list Item
Need mothod destroy to boot deleting in model
 */
public function deleteList()
{
    if (!request()->ajax()) {
        return response()->json(['error' => 1, 'msg' => 'Method not allow!']);
    } else {
        $ids = request('ids');
        $arrID = explode(',', $ids);
        AdminProductReview::destroy($arrID);
        return response()->json(['error' => 0, 'msg' => '']);
    }
}


    public function getReply()
    {
        $id = request()->id;
        if($id){
            $comment = AdminProductReview::find($id);
            $replies = (new AdminProductReview)->where('parent', $id)->orderByDesc('id')->get();
            return response()->json([
                'error' => 0,
                'view'  => view('admin.review.reply', compact('comment', 'replies'))->render(),
                'msg'   => 'Success'
            ]);
        }
    }

    public function updateReply()
    {
        $id = request()->id;
        if($id){
            $check = AdminProductReview::where('id', $id)->where('type', 'reply')->count();
            if($check){
                AdminProductReview::where('id', $id)->update(['comment' => request('comment')]);
                return response()->json(['error' => 0, 'msg' => 'Cập nhật thành công']);
            }
            else{
                AdminProductReview::create(['parent' => $id,'type' => 'reply', 'comment' => request('comment')]);
                return response()->json(['error' => 0, 'msg' => 'Thêm trả lời thành công']);
            }
        }
    }

    public function deleteReply()
    {
        $id = request()->id;
        if($id){
            AdminProductReview::destroy($id);
            return response()->json(['error' => 0, 'msg' => 'Xóa thành công']);
        }
        else
            return response()->json(['error' => 1, 'msg' => 'Method not allow!']);
    }

}
