<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\ShopCategoryDescription;

use App\Models\ShopProductCategory;
use App\Models\ShopProduct;

class ShopContact extends Model
{
    protected $table = 'shop_contact';
    protected  $guarded = []; // array category id

    public function createContact($data, $type = '')
    {
        
        // dd($data);
        $contact = ShopContact::create([
            'user_id' => $data['user_id'],
            'to_user_id' => $data['user_id']??0,
            'product_id' => $data['product_id']??0,
            'type' => $data['option'][104]??'',
            'title' => $data['title'],
            'content' => $data['content'],
            'from' => $data['from']??'',
            'to' => $data['to']??'',
            'request_file' => $data['request_file']??'',
            'currency' => $data['currency']??'',
        ]);
        if($type=='user')
            $this->createSuccessToUser($contact, $data['attach']??[]);
        else
            $this->createSuccess($contact, $data['attach']??[], $type);
        return true;
    }

    public function createSuccessToUser($contact, $attach=[])
    {
        $checkContent = (new ShopEmailTemplate)->where('group', 'contact_baogia_success')->where('status', 1)->first();
        $checkContentToUser = (new ShopEmailTemplate)->where('group', 'contact_baogia_to_user')->where('status', 1)->first();

        if ($checkContent && $checkContentToUser) 
        {
            $user = User::find($contact->user_id);
            $to_user = User::find($contact->to_user_id);

            $content = $checkContent->text;
            $contentToUser = $checkContentToUser->text;
            $url_upgrade = route('account_upgrade');
            $dataFind = [
                '/\{\{\$userName\}\}/',
                '/\{\{\$id\}\}/',
                '/\{\{\$dataFrom\}\}/',
                '/\{\{\$dataTo\}\}/',
                '/\{\{\$dataTitle\}\}/',
                '/\{\{\$dataContent\}\}/',
            ];
            $dataReplace = [
                $user->fullname,
                $contact->id,
                $contact->from,
                $contact->to,
                $contact->title,
                $contact->content,
            ];
            $content = preg_replace($dataFind, $dataReplace, $content);
            $dataView = [
                'content' => htmlspecialchars_decode($content)
            ];

            $config = [
                'to' => $user->email,
                'subject' => $checkContent->subject,
            ];

            $contentToUser = preg_replace($dataFind, $dataReplace, $contentToUser);
            $dataViewToUser = [
                'content' => htmlspecialchars_decode($contentToUser)
            ];
            $configToUser = [
                'to' => $to_user->email,
                'subject' => $checkContentToUser->subject,
            ];

            sc_send_mail('email.customer_verify', $dataView, $config, $attach);
            sc_send_mail('email.customer_verify', $dataViewToUser, $configToUser, $attach);
            return true;
        }
    }

    public function createSuccess($contact, $attach=[])
    {
        $checkContent = (new ShopEmailTemplate)->where('group', 'contact_baogia_success')->where('status', 1)->first();
        $checkContentAdmin = (new ShopEmailTemplate)->where('group', 'contact_baogia_admin')->where('status', 1)->first();

        if ($checkContent && $checkContentAdmin) 
        {
            $user = User::find($contact->user_id);
            $content = $checkContent->text;
            $contentAdmin = $checkContentAdmin->text;
            $url_upgrade = route('account_upgrade');
            $dataFind = [
                '/\{\{\$userName\}\}/',
                '/\{\{\$id\}\}/',
                '/\{\{\$dataFrom\}\}/',
                '/\{\{\$dataTo\}\}/',
                '/\{\{\$dataTitle\}\}/',
                '/\{\{\$dataContent\}\}/',
            ];
            $dataReplace = [
                $user->fullname,
                $contact->id,
                $contact->from,
                $contact->to,
                $contact->title,
                $contact->content,
            ];
            $content = preg_replace($dataFind, $dataReplace, $content);
            $dataView = [
                'content' => htmlspecialchars_decode($content)
            ];

            $config = [
                'to' => $user->email,
                'subject' => $checkContent->subject,
            ];

            $contentAdmin = preg_replace($dataFind, $dataReplace, $contentAdmin);
            $dataViewAdmin = [
                'content' => htmlspecialchars_decode($contentAdmin)
            ];
            $configAdmin = [
                // 'to' => 'huunamtn@gmail.com', // setting_option('email_admin'),
                'to' => setting_option('email_admin'),
                'subject' => $checkContentAdmin->subject,
            ];

            sc_send_mail('email.customer_verify', $dataView, $config, $attach);
            sc_send_mail('email.customer_verify', $dataViewAdmin, $configAdmin, $attach);
            return true;
        }
    }
}
