<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailNotify;
use App\Models\Contact;

class ContactController extends Controller
{
    use \App\Traits\LocalizeController;
    
    public $data = [
        'error' => false,
        'success' => false,
        'message' => ''
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function index(){
        $this->localized();
        $this->data['page'] = \App\Page::where('slug', 'contact')->first();
        return view($this->templatePath .'.page.contact', ['data' => $this->data]);
    }

    public function getContact(Request $request,$type)
    {
        if($type == 'request-contact')
        {
            $this->data['status'] = 'success';
            $this->data['type'] = $type;
            $this->data['url_current'] = $request->url_current;
            $this->data['product_title'] = $request->product_title;
            $this->data['view'] = view('theme.page.includes.get-contact-form', ['data' => $this->data ])->render();
        }

        return response()->json($this->data);
    }
    
    public function submit(Request $rq) {
        $detail = $rq->input('contact', false);
        // dd($detail);
        if($detail){
            $email = new \App\Mail\contactMail($detail);
            $sendto =  setting_option('email');
            try {
                $package_id = $detail['package_id']??0;
                Contact::create([
                    'package_id'  => $package_id,
                    'name'  => $detail['name']??'',
                    'email'  => $detail['email']??'',
                    'subject'  => $detail['subject']??'',
                    'content'  => $detail['message']??'',
                ]);
                Mail::to($sendto)->send($email);

            } catch (\Exception $e) {
                $url_back = $rq->url_back??url('contact.html');
                return redirect($url_back)->with(['error' => true, 'message' => $e->getMessage()]);
            }
            $url_back = $rq->url_back??url('contact.html');
            return redirect($url_back)->with(['success' => true, 'message' => 'Gửi ý kiến thành công']);
        }
    }
}
