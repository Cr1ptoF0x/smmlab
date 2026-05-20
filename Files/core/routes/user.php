<?php

use Illuminate\Support\Facades\Route;

Route::namespace('User\Auth')->name('user.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::controller('LoginController')->group(function () {
            Route::get('/login', 'showLoginForm')->name('login');
            Route::post('/login', 'login');
            Route::get('logout', 'logout')->middleware('auth')->withoutMiddleware('guest')->name('logout');
        });

        Route::controller('RegisterController')->group(function () {
            Route::get('register', 'showRegistrationForm')->name('register');
            Route::post('register', 'register');
            Route::post('check-user', 'checkUser')->name('checkUser')->withoutMiddleware('guest');
        });

        Route::controller('ForgotPasswordController')->prefix('password')->name('password.')->group(function () {
            Route::get('reset', 'showLinkRequestForm')->name('request');
            Route::post('email', 'sendResetCodeEmail')->name('email');
            Route::get('code-verify', 'codeVerify')->name('code.verify');
            Route::post('verify-code', 'verifyCode')->name('verify.code');
        });

        Route::controller('ResetPasswordController')->group(function () {
            Route::post('password/reset', 'reset')->name('password.update');
            Route::get('password/reset/{token}', 'showResetForm')->name('password.reset');
        });

        Route::controller('SocialiteController')->group(function () {
            Route::get('social-login/{provider}', 'socialLogin')->name('social.login');
            Route::get('social-login/callback/{provider}', 'callback')->name('social.login.callback');
        });
    });
});

Route::middleware('auth')->name('user.')->group(function () {
    Route::get('user-data', 'User\UserController@userData')->name('data');
    Route::post('user-data-submit', 'User\UserController@userDataSubmit')->name('data.submit');

    //authorization
    Route::middleware('registration.complete')->namespace('User')->controller('AuthorizationController')->group(function () {
        Route::get('authorization', 'authorizeForm')->name('authorization');
        Route::get('resend-verify/{type}', 'sendVerifyCode')->name('send.verify.code');
        Route::post('verify-email', 'emailVerification')->name('verify.email');
        Route::post('verify-mobile', 'mobileVerification')->name('verify.mobile');
        Route::post('verify-g2fa', 'g2faVerification')->name('2fa.verify');
    });

    Route::middleware(['check.status', 'registration.complete'])->group(function () {
        Route::namespace('User')->group(function () {
            Route::controller('UserController')->group(function () {
                Route::get('dashboard', 'home')->name('home');
                Route::get('download-attachments/{file_hash}', 'downloadAttachment')->name('download.attachment');
                Route::get('referrals', 'referrals')->name('referrals');

                //2FA
                Route::get('twofactor', 'show2faForm')->name('twofactor');
                Route::post('twofactor/enable', 'create2fa')->name('twofactor.enable');
                Route::post('twofactor/disable', 'disable2fa')->name('twofactor.disable');

                //Report
                Route::any('deposit/history', 'depositHistory')->name('deposit.history');
                Route::get('transactions', 'transactions')->name('transactions');

                Route::get('order', 'order')->name('order');
                Route::post('add-device-token', 'addDeviceToken')->name('add.device.token');
            });

            Route::controller('RefillController')->prefix('refill')->name('refill.')->group(function () {
                Route::get('', 'index')->name('index');
                Route::post('store/{id}', 'store')->name('store');
            });

            //Profile setting
            Route::controller('ProfileController')->group(function () {
                Route::get('profile-setting', 'profile')->name('profile.setting');
                Route::post('profile-setting', 'submitProfile');
                Route::get('change-password', 'changePassword')->name('change.password');
                Route::post('change-password', 'submitPassword');
            });

            //order Controller
            Route::controller('OrderController')->name('order.')->prefix('order')->group(function () {
                Route::get('history', 'history')->name('history');
                Route::get('pending', 'pending')->name('pending');
                Route::get('processing', 'processing')->name('processing');
                Route::get('completed', 'completed')->name('completed');
                Route::get('cancelled', 'cancelled')->name('cancelled');
                Route::get('refunded', 'refunded')->name('refunded');
                Route::get('/mass', 'massOrder')->name('mass');
                Route::post('/store-mass', 'massOrderStore')->name('mass.store');
                Route::get('overview/{id?}', 'orderOverview')->name('overview');
                Route::post('order/{serviceId?}', 'order')->name('create');
                Route::get('details/{id}', 'orderDetails')->name('details');
            });

            //Dripfeed order Controller
            Route::controller('DripfeedController')->name('dripfeed.')->prefix('dripfeed')->group(function () {
                Route::get('/', 'history')->name('history');
                Route::get('pending', 'pending')->name('pending');
                Route::get('processing', 'processing')->name('processing');
                Route::get('completed', 'completed')->name('completed');
                Route::get('cancelled', 'cancelled')->name('cancelled');
                Route::get('refunded', 'refunded')->name('refunded');
                Route::get('overview/{id?}', 'dripfeedOverview')->name('overview');
                Route::post('order/{serviceId?}', 'dripfeed')->name('create');
                Route::get('details/{id}', 'dripfeedDetails')->name('details');
            });

            //Api
            Route::controller('ApiController')->name('api.')->prefix('api')->group(function () {
                Route::get('index', 'api')->name('index');
                Route::post('generate-new-key', 'generateApiKey')->name('generateKey');
            });

            Route::controller('FavoriteController')->name('favorite.')->prefix('favorite')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/add', 'add')->name('add');
            });
        });

        // Payment
        Route::prefix('deposit')->name('deposit.')->controller('Gateway\PaymentController')->group(function () {
            Route::any('/', 'deposit')->name('index');
            Route::post('insert', 'depositInsert')->name('insert');
            Route::get('confirm', 'depositConfirm')->name('confirm');
            Route::get('manual', 'manualDepositConfirm')->name('manual.confirm');
            Route::post('manual', 'manualDepositUpdate')->name('manual.update');
        });
    });
});
