<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentRequest;
use App\Models\Package;
use App\Models\User;
use App\Models\UserUpgrade;
use Carbon\Carbon;

class PurchaseController extends Controller
{

    public $title_head = 'Lịch sử thanh toán';
    public $admin_view = 'admin.purchase';

    public function index()
    {
        $db = PaymentRequest::with('getUser')->whereHas('getUser', function($query){
            return $query->where('fullname', '<>', '');
        });

        if(request()->keyword)
        {
            $keyword = request()->keyword;
            $db = $db->where('payment_code', trim($keyword));
        }

        $posts = $db->orderbyDesc('created_at')->paginate(20);
        $data = [
            'title'   =>   $this->title_head,
            'posts'   =>   $posts,
        ];
        return view($this->admin_view .'.index', $data);
    }

    public function edit($id)
    {
        $history = PaymentRequest::find($id);

        $data = [
            'title'   => $this->title_head,
            'history'   => $history,
            'user'   => User::find($history->user_id),
            'url_action'   => route('admin_purchase.post'),
        ];

        return view($this->admin_view .'.single', $data);
    }

    public function post()
    {
        $data = request()->all();
        $id = $data['id'] ?? 0;

        if($id)
        {
            PaymentRequest::find($id)->update([
                'status'    => $data['status']
            ]);
            $history = PaymentRequest::find($id);
            // dd($history);
            $package = Package::find($history->package_id);
            $user = User::find($history->user_id);
            // dd($package);
            
            if($data['status'] == 1 && $history->payment_success == 0)
            {
                $amount_affiliate = $user->processInviteFee($history->amount);
                
                // dd($affiliate_fee);
                PaymentRequest::find($id)->update([
                    'payment_success'    => 1
                ]);
                
                /*$download = $user->download + $package->download;
                User::find($history->user_id)->update([
                    'download'  => $download
                ]);*/
                User::find($history->user_id)->update([
                    'package_id'  => $history->package_id
                ]);
                $user->sendEmailUpgradeSuccess($history->package_id);

                $package_day = \App\Models\PackageDay::find($history->day_id);
                $end_date = Carbon::now();

                UserUpgrade::updateOrCreate([
                    'user_id'   => $history->user_id,
                    'payment_code'  => $history->payment_code,
                    'package_id'  => $history->package_id,
                    'day_id'  => $history->day_id,
                    'amount'  => $history->amount,
                    'amount_affiliate'  => $amount_affiliate,
                    'end_date'  => $package_day->getEndDate()
                ]);

            }
        }
        return redirect( route('admin_purchase.edit', $id) );
    }

    public function viewTipHistory()
    {
        $this->data['history'] = Payment::orderbyDesc('created_at')->get();
        // dd($this->data['history']);
        return view('admin.payment.payment-view-tip', $this->data);
    }

    public function creditSpent()
    {
        $this->data['credit_spent'] = PaymentRequest::with('getUser')->where('post_id', '<>', 0)->orderbyDesc('id')->get();
        $this->data['credit_spent_total'] = (new PaymentRequest)->totalSpent();
        
        return view('admin.payment.credit-spent', $this->data);
    }
}
