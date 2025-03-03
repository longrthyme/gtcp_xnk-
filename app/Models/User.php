<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;

class User extends Authenticatable
{
    use Notifiable;

    public $set_affiliate = 3;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'firstname',
        'lastname',
        'fullname',
        'email',
        'email_verified_at',
        'wallet',
        'about_me',
        'provider_id',
        'provider',
        'birthday',
        'phone',
        'full_phone',
        'password',
        'remember_token',
        'address',
        'country',
        'province',
        'district',
        'city',
        'postal_code',
        'ward',
        'avatar',
        'status',
        'company',
        'company_date',
        'mst',
        'role',
        'type',
        'account_type',
        'job',
        'cccd',
        'cccd_date',
        'cccd_place',
        'website',
        'time_learned',
        'course_completed',
        'certificate_issued',
        'code',
        'invited_code',
        'package_id',
        'bank_account',
        'bank_number',
        'bank_name',
        'bank_branch',
    ];

    protected $with = ['sessions'];

    public function sessions()
    {
        return $this->hasMany(Session::class);
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function accessRole()
    {
        if($this->role == 1)
            return true;
        return false;
    }

    public function wishlist()
    {
        return [];
    }

    function getPhone($phonehide = 0)
    {
        if(!$phonehide && auth()->check())
            return $this->phone;
        return str_replace( substr($this->phone, -5), '*****', $this->phone );
    }
    
    function getUrl()
    {
        return sc_route('author.detail', ['id' => $this->id]);
    }

    public function getUrlBaoGia()
    {
        return sc_route('customer.baogia', ['id' => $this->id]);
    }

    public function getAddress($type='')
    {
        $province = LocationProvince::where('name', $this->province)->first();
        $district = LocationDistrict::where('name', $this->district)->first();
        $ward = LocationWard::where('type_name', $this->ward)->first();
        $arr = array_filter([$ward->type_name??'', $district->name??'', $province->name??'']);
        if(count($arr))
        {
            $arr = implode(', ', $arr);
            return $arr;
        }
        return;
    }

    function getDayJoin()
    {
        $now = Carbon::now();
        return $now->diffInDays($this->created_at);
    }

    function getInvited()
    {
        return $this->hasMany(User::class, 'invited_code', 'code');
    }

    function getCompany()
    {
        return $this->hasOne(UserCompany::class, 'user_id', 'id');
    }

    function getType()
    {
        return $this->hasOne(UserType::class, 'id', 'type');
    }
    function getRole()
    {
        return $this->hasOne(UserRole::class, 'id', 'role');
    }

    function getVerify()
    {
        return $this->hasOne(UserVerify::class, 'user_id', 'id')->where('status', 0);
    }

    public function profile()
    {
        if (self::$profile === null) {
            self::$profile = Auth::user();
        }
        return self::$profile;
    }

    public function getCodeInvite()
    {
        if(empty($this->code))
        {
            $code = auto_code('U', $this->id);
            self::find($this->id)->update(['code' => $code]);
            return $code;
        }
        return $this->code;
    }
    public function getUrlInvite()
    {
        return sc_route('customer.invite', ['code' => $this->getCodeInvite()]);   
    }

    public function checkAffiliate()
    {
        if($this->type == $this->set_affiliate)
            return true;
        return false;
    }

    public function checkViewXNK()
    {
        if(!$this->countEndDate())
            return false;

        $upgrade = $this->getUpgrade();
        $package = $this->getPackage;
        $package_option = $package->options()->where('option_id', 15)->first();

        // if($upgrade->package_id == 3 && $upgrade->day_id != 1)
        if($package_option && $upgrade->day_id != 1)
            return true;

        return false;
    }

    /*
    $amount int
    */
    public function processInviteFee($amount = 0)
    {
        if($amount == 0)
            return $amount;

        $affiliate_fee = (float)setting_option('affiliate-fee');
        if($this->invited_code != '' && $affiliate_fee > 0)
        {
            $amount = $amount * $affiliate_fee;
            $user_invite = User::where('code', $this->invited_code)->first();
            $user_invite->wallet = $user_invite->wallet + $amount;
            $user_invite->save();
        }
        return $amount;
    }

    /**
     * Check customer has Check if the user is verified
     *
     * @return boolean
     */
    public function isVerified()
    {
        return ! is_null($this->email_verified_at)  || $this->provider_id ;
    }

    /**
     * Check customer need verify email
     *
     * @return boolean
     */
    public function hasVerifiedEmail()
    {
        return !$this->isVerified() && sc_config('customer_verify');
    }
    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerifyReject($data = [])
    {
        $checkContent = (new ShopEmailTemplate)->where('group', 'customer_verify_reject')->where('status', 1)->first();

        if ($checkContent) 
        {
            $userEditURL = \Illuminate\Support\Facades\URL::temporarySignedRoute(
                'customer.verify_process',
                \Carbon\Carbon::now()->addMinutes(config('auth.verification', 60)),
                [
                    'id' => $this->id,
                    'token' => sha1($this->email),
                ]
            );

            $content = $checkContent->text;
            $dataFind = [
                '/\{\{\$website\}\}/',
                '/\{\{\$dataContent\}\}/',
                '/\{\{\$userEditURL\}\}/',
            ];
            $dataReplace = [
                url('/'),
                $data['note']??'',
                $userEditURL,
            ];
            $content = preg_replace($dataFind, $dataReplace, $content);
            $dataView = [
                'content' => htmlspecialchars_decode($content)
            ];

            $config = [
                'to' => $this->email,
                'subject' => $checkContent->subject,
            ];

            sc_send_mail('email.customer_verify', $dataView, $config, $dataAtt = []);
            return true;
        }
    }
    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerifySuccess()
    {
        $checkContent = (new ShopEmailTemplate)->where('group', 'customer_verify_success')->where('status', 1)->first();

        if ($checkContent) 
        {
            $content = $checkContent->text;
            $url_upgrade = route('account_upgrade');
            $dataFind = [
                '/\{\{\$userName\}\}/',
                '/\{\{\$userUsername\}\}/',
                '/\{\{\$url_upgrade\}\}/',
                '/\{\{\$urlDangtin\}\}/',
            ];
            $dataReplace = [
                $this->fullname,
                $this->username,
                $url_upgrade,
                sc_route('dangtin'),
            ];
            $content = preg_replace($dataFind, $dataReplace, $content);
            $dataView = [
                'content' => htmlspecialchars_decode($content)
            ];

            $config = [
                'to' => $this->email,
                'subject' => $checkContent->subject,
            ];

            sc_send_mail('email.customer_verify', $dataView, $config, $dataAtt = []);
            return true;
        }
    }
    public function sendEmailVerify()
    {
        // dd($this->hasVerifiedEmail());
        if ($this->hasVerifiedEmail()) 
        {
            $minute_to_verify = config('auth.verification', 60);

            // $url = route('customer.verify_process');
            $url = \Illuminate\Support\Facades\URL::temporarySignedRoute(
                'customer.verify_process',
                \Carbon\Carbon::now()->addMinutes($minute_to_verify),
                [
                    'id' => $this->id,
                    'token' => sha1($this->email),
                ]
            );

            $checkContent = (new ShopEmailTemplate)->where('group', 'customer_verify')->where('status', 1)->first();

            if ($checkContent) {
                $content = $checkContent->text;
                $dataFind = [
                    '/\{\{\$title\}\}/',
                    '/\{\{\$reason_sendmail\}\}/',
                    '/\{\{\$note_sendmail\}\}/',
                    '/\{\{\$note_access_link\}\}/',
                    '/\{\{\$url_verify\}\}/',
                    '/\{\{\$button\}\}/',
                ];
                $dataReplace = [
                    'Xin chào!',
                    'Vui lòng nhấp vào nút bên dưới để xác minh địa chỉ email của bạn.',
                    'Liên kết mật khẩu này sẽ hết hạn trong vòng '. $minute_to_verify .' phút.<br><br>Nếu bạn chưa tạo tài khoản, bạn không cần thực hiện thêm hành động nào.',
                    'Nếu bạn gặp sự cố khi nhấp vào button Xác thực email, sao chép và dán URL bên dưới vào trình duyệt web của bạn '. $url,
                    $url,
                    'Xác thực email',
                ];
                $content = preg_replace($dataFind, $dataReplace, $content);
                $dataView = [
                    'content' => $content,
                ];
    
                $config = [
                    'to' => $this->email,
                    'subject' => $checkContent->subject,
                ];
    
                sc_send_mail('email.customer_verify', $dataView, $config, $dataAtt = []);
                return true;
            }
        }
        return false;
    }
    /**
     * Send the email verification notification to admin.
     *
     * @return void
     */
    public function sendEmailVerifyToAdmin()
    {
        // dd($this->hasVerifiedEmail());
        if ($this->hasVerifiedEmail()) 
        {
            // $url = route('customer.verify_process');
            $url = route('admin_user.verify_edit', $this->id);

            $checkContent = (new ShopEmailTemplate)->where('group', 'customer_verify_admin')->where('status', 1)->first();

            if ($checkContent) {
                $content = $checkContent->text;
                $dataFind = [
                    '/\{\{\$userFullName\}\}/',
                    '/\{\{\$urlVerify\}\}/',
                ];
                $dataReplace = [
                    $this->fullname,
                    $url,
                ];
                $content = preg_replace($dataFind, $dataReplace, $content);
                $dataView = [
                    'content' => htmlspecialchars_decode($content),
                ];
    
                $config = [
                    'to' => setting_option('email_admin'),
                    'subject' => $checkContent->subject,
                ];
    
                sc_send_mail('email.customer_verify', $dataView, $config, $dataAtt = []);
                return true;
            }
        }
        return false;
    }

    function createVerify($dataInsert)
    {
        $this->getVerify()->delete();
        UserVerify::create($dataInsert);
    }

    public function sendEmailUpgradeSuccess($package_id)
    {
        $checkContent = (new ShopEmailTemplate)->where('group', 'customer_upgrade_success')->where('status', 1)->first();

        if ($checkContent) 
        {
            $package = Package::find($package_id);
            // dd($package);
            $content = $checkContent->text;
            $dataFind = [
                '/\{\{\$userName\}\}/',
                '/\{\{\$packageName\}\}/',
            ];
            $dataReplace = [
                $this->fullname,
                $package->name??'',
            ];
            $content = preg_replace($dataFind, $dataReplace, $content);
            $dataView = [
                'content' => htmlspecialchars_decode($content)
            ];

            $config = [
                'to' => $this->email,
                'subject' => $checkContent->subject,
            ];

            sc_send_mail('email.customer_verify', $dataView, $config, $dataAtt = []);
            return true;
        }
    }

    public function getPackage()
    {
        return $this->hasOne(Package::class, 'id', 'package_id');
    }

    public function getPackagePayment()
    {
        $package = $this->getPackage;
        if($package)
            $upgrade = UserUpgrade::where('package_id', $package->id)->orderbyDesc('id')->first();
        if(!empty($upgrade))
        {
            $payment = PaymentRequest::where('payment_code', $upgrade->payment_code)->first();
            return $payment;
        }
    }

    public function getUpgrade()
    {
        $package = $this->getPackage;
        if($package)
        {
            $upgrade = UserUpgrade::where('package_id', $package->id)->where('user_id', $this->id)->orderbyDesc('id')->first();
            // dd($upgrade);
            return $upgrade;
        }
        return;
    }

    public function countEndDate()
    {
        $now  = Carbon::now();
        $upgrade = $this->getUpgrade();
        if($upgrade)
        {
            // dd($now->diffInDays($upgrade->end_date));
            return $now->diffInDays($upgrade->end_date);
        }
        return 0;
    }

    function options()
    {
        return $this->hasMany(UserOption::class, 'user_id', 'id');
    }
    function getOptions($json_decode_text=true)
    {
        $options = $this->options()->pluck('value', 'option_id')->toArray();

        foreach($options as $key => $item)
        {
            $value = json_decode($item);
            if(is_array($value))
            {
                if($json_decode_text)
                    $value = implode(', ', $value);

                $options[$key] = $value;
            }

        }
        
        return $options;
    }
    public function getOption($option_id='')
    {
        $option = $this->options->where('option_id',$option_id)->first();
        if($option)
        {
            $value = json_decode($option->value);
            if(is_array($value))
                return $value;
            else
                return $option->value;
        }
    }
    function createOption($data)
    {
        $options = ShopOption::whereIn('id', array_keys($data))->get();
        // dd($options);
        foreach($options as $item)
        {
            $option_id = $data[$item->id]?$item->id:0;
            $option_value = $data[$option_id]??'';
            if(is_array($option_value))
            {
                $option_value = json_encode($option_value);
            }

            if($item->type_data == 'number')
                $option_value = str_replace(',', '',  $option_value);
            
            if($option_id)
            {
                UserOption::create([
                    'user_id' => $this->id,
                    'option_id' => $option_id,
                    'value' => $option_value,
                ]);
            }
        }
    }

    public function posts()
    {
        return $this->hasMany(ShopProduct::class, 'user_id');
    }

    public function checkVote($user_vote)
    {
        $check_vote = \App\Models\UserVote::where('user_id', $this->id)->where('user_vote', $user_vote)->first();
        if($check_vote)
            return false;
        return true;
    }

    public function getVote()
    {
        return $this->hasMany(UserVote::class, 'user_vote', 'id');
    }

    public function getVoteCount()
    {
        $vote = $this->getVote();
        $total = $vote->sum('vote');
        // dd($vote->get());
        $avg = 0;
        if($total)
            $avg = round($total/$vote->count());
        return $avg;
    }
}
