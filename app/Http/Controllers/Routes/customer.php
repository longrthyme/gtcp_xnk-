<?php 

	Route::get('/dang-nhap', 'Auth\LoginController@index')->name('login');
    Route::post('/dang-nhap', 'Auth\LoginController@post');
    Route::get('/dang-ky', 'Auth\RegisterController@index')->name('register');
    Route::post('/dang-ky', 'Auth\RegisterController@register');
    Route::get('/dang-ky-thanh-cong', 'CustomerController@registerSuccess')->name('register_success');
    Route::get('/da-gui-xac-thuc-tai-khoan', 'CustomerController@verifySent')->name('customer.verify_sent');

    Route::post('customer/login-or-register', 'CustomerController@loginOrregister')->name('login_or_register');

    Route::get('/tin-dang/thanh-vien-user{id}', 'ProductController@customerPost')->name('customer.customer_post');

    Route::group(['prefix' => 'forget'], function() {
        //user forget password
        Route::get('password', 'Auth\ForgotPasswordController@forget')->name('forget');
        Route::post('password', 'Auth\ForgotPasswordController@actionForgetPassword')->name('actionForgetPassword');

        Route::get('password-step-2', 'Auth\ForgotPasswordController@forgetPassword_step2')->name('forgetPassword_step2');
        Route::post('password-step-2', 'Auth\ForgotPasswordController@actionForgetPassword_step2')->name('actionForgetPassword_step2');

        Route::get('password-step-3', 'Auth\ForgotPasswordController@forgetPassword_step3')->name('forgetPassword_step3');
        Route::post('password-step-3', 'Auth\ForgotPasswordController@actionForgetPassword_step3')->name('actionForgetPassword_step3');
    });
    
    Route::group(['middleware' => ['auth', 'IsVerifyEmail']], function () {
         //page author
        Route::group(['prefix' => 'thanh-vien'], function() {
            Route::get('/', 'CustomerController@author')->name('author');
            Route::get('{id}', 'CustomerController@authorDetail')->name('author.detail');
        });
    });

    
    Route::group(['middleware' => ['auth', 'IsVerifyEmail']], function () {
       
        Route::group(['prefix' => 'customer'], function() {
            
            Route::get('/thong-tin', 'CustomerController@profile')->name('customer.profile');
            Route::post('/thong-tin', 'CustomerController@updateProfile');

            Route::post('/edit-avatar', 'CustomerController@editAvatar')->name('customer.edit_avatar');
            Route::post('/update-company', 'CustomerController@updateCompany')->name('customer.update_company');

            // Route::get('/payment-history', 'PaymentController@paymentHistory')->name('customer.payment_history');

            Route::get('/my-orders', array('as' => 'customer.my-orders', 'uses' => 'CustomerController@myOrder'));
            Route::get('/my-orders-detail/{id_cart}', array('as' => 'customer.myordersdetail', 'uses' => 'CustomerController@myOrderDetail'));
            Route::get('/my-point', array('as' => 'customer.point', 'uses' => 'CustomerController@myPoint'));

            Route::get('/change-pass', array('as' => 'customer.changePassword', 'uses' => 'CustomerController@changePassword'));
            Route::post('/change-pass', array('as' => 'customer.post.ChangePassword', 'uses' => 'CustomerController@postChangePassword'));

            Route::get('/tin-dang', 'CustomerController@myPost')->name('customer.post');
            Route::get('/refused', 'CustomerController@refused')->name('customer.refused');

            Route::get('/affiliate', 'CustomerController@affiliate')->name('customer.affiliate');
        });
    });

    Route::group(['middleware' => 'auth'], function () {
        Route::group(['prefix' => 'contact-us'], function() {
            Route::get('yeu-cau-chao-gia/{id}', 'CustomerController@chaogia')->name('customer.baogia');
            Route::post('yeu-cau-chao-gia/{id}', 'CustomerController@chaogiaProcess');
        });

        Route::group(['prefix' => 'customer'], function() {
            Route::get('/', 'CustomerController@index')->name('customer.dashboard');

            //Process url verify
            
            Route::post('/email/verify-resend', 'CustomerController@resendVerification')->name('customer.verify_resend');

            Route::post('/accept-invite-code', 'CustomerController@acceptInvite')->name('customer.accept_invidte');
        });
    });
    Route::group(['prefix' => 'customer'], function() {
        Route::get('/email/verify/{id}/{token}', 'CustomerController@verificationProcessData')->name('customer.verify_process');
        Route::post('/email/verify/{id}/{token}', 'CustomerController@verificationProcess');

        Route::get('/verify', 'CustomerController@verification')->name('customer.verify');
    });

    Route::get('/logout', array('as' => 'customer.logout', 'uses' => 'CustomerController@logoutCustomer'));
    Route::get('/me/invite/{code}', 'Auth\RegisterController@index')->name('customer.invite');


    Route::group(['prefix' => 'payment'], function() {
        Route::get('payment-return', 'Payment\VNPayController@paymentReturn')->name('payment_vnpay.return');
        // Route::post('/payment-type', 'PaymentController@paymentType')->name('payment.type');
        Route::get('payment-success', 'PurchaseController@paymentSuccess')->name('payment.success');
        Route::get('payment-type', 'PurchaseController@paymentType')->name('payment.type');
    });

    Route::group(['middleware' => 'auth'], function () {
        Route::group(['prefix' => 'purchase'], function() {
            Route::get('{id}', 'PackageController@purchaseProcess')->name('purchase.detail');
            
            Route::get('checkout/{code}', 'PackageController@purchaseDetail')->name('purchase_checkout.detail');
            
            Route::post('checkout', 'PackageController@purchasePayment')->name('purchase.payment');

            Route::get('history', array('as' => 'payment_history', 'uses' => 'PackageController@paymentHistory'));
            Route::get('cancel/{id}', array('as' => 'purchase.cancel', 'uses' => 'PackageController@purchaseCancel'));
            Route::post('/payment-point', array('as' => 'purchase.checkout', 'uses' => 'PackageController@paymentPointCheckout'));
        });
    });

    Route::get('account-upgrade', 'PackageController@package')->name('account_upgrade');