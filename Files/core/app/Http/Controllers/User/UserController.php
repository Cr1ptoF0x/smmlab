<?php

namespace App\Http\Controllers\User;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Lib\GoogleAuthenticator;
use App\Models\Deposit;
use App\Models\Order;
use App\Models\Referral;
use App\Models\Service;
use App\Models\SupportTicket;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller {
    public function home() {
        $pageTitle                   = 'Dashboard';
        $user                        = auth()->user();
        $widget['balance']           = $user->balance;
        $widget['total_spent']       = Order::where('status', '!=', Status::ORDER_REFUNDED)->where('user_id', $user->id)->sum('price');
        $widget['total_transaction'] = Transaction::where('user_id', $user->id)->count();
        $widget['total_order']       = Order::directOrder()->where('user_id', $user->id)->count();
        $widget['pending_order']     = Order::directOrder()->where('user_id', $user->id)->pending()->count();
        $widget['processing_order']  = Order::directOrder()->where('user_id', $user->id)->processing()->count();
        $widget['completed_order']   = Order::directOrder()->where('user_id', $user->id)->completed()->count();
        $widget['cancelled_order']   = Order::directOrder()->where('user_id', $user->id)->cancelled()->count();

        $widget['total_dripfeed_order']      = Order::dripfeedOrder()->where('user_id', $user->id)->count();
        $widget['pending_dripfeed_order']    = Order::dripfeedOrder()->where('user_id', $user->id)->pending()->count();
        $widget['processing_dripfeed_order'] = Order::dripfeedOrder()->where('user_id', $user->id)->processing()->count();
        $widget['completed_dripfeed_order']  = Order::dripfeedOrder()->where('user_id', $user->id)->completed()->count();

        $widget['refunded_order'] = Order::directOrder()->where('user_id', $user->id)->refunded()->count();
        $widget['deposit']        = Deposit::successful()->where('user_id', $user->id)->sum('amount');

        $widget['total_ticket']      = SupportTicket::where('user_id', $user->id)->count();
        $widget['referral_earnings'] = Transaction::where('remark', 'referral_commission')->where('user_id', auth()->id())->sum('amount');
        $orders                      = Order::where('user_id', $user->id)->with(['category', 'user', 'service'])->orderBy('id', 'desc')->take(10)->get();
        $bestSellingServices         = Service::active()->with('category')
            ->withCount(['orders as total_orders' => function ($query) {
                $query->where('status', '!=', Status::ORDER_CANCELLED);
            }])->having('total_orders', '>', 0)->orderBy('total_orders', 'desc')->take(10)->get();

        return view('Template::user.dashboard', compact('pageTitle', 'widget', 'orders', 'bestSellingServices'));
    }

    public function depositHistory(Request $request) {
        $pageTitle = 'Deposit History';
        $scopes    = ['', 'initiated', 'successful', 'rejected'];
        $scope     = $request->status;

        if (!in_array($scope, $scopes)) {
            $notify[] = ['error', 'Unauthorized action'];
            return to_route('user.deposit.history')->withNotify($notify);
        }

        $user       = auth()->user();
        $currencies = Deposit::where('user_id', $user->id)->distinct()->pluck('method_currency');

        $gateways = Deposit::where('user_id', $user->id)->distinct()->with(['gateway' => function ($gateway) {
            $gateway->select('code', 'name');
        }])->get('method_code');

        $deposits = Deposit::where('user_id', $user->id)->when($scope, function ($query) use ($scope) {
            $query->$scope();
        })->searchable(['trx'])->filter(['method_currency', 'method_code'])->dateFilter()->with('gateway')->orderBy('id', 'desc');

        $deposits = $deposits->paginate(getPaginate());

        return view('Template::user.deposit_history', compact('pageTitle', 'deposits', 'currencies', 'gateways'));
    }

    public function referrals() {
        $pageTitle = 'My Referrals';
        $user      = auth()->user();
        $maxLevel  = Referral::max('level');
        return view('Template::user.referrals', compact('pageTitle', 'user', 'maxLevel'));
    }

    public function show2faForm() {
        $ga        = new GoogleAuthenticator();
        $user      = auth()->user();
        $secret    = $ga->createSecret();
        $qrCodeUrl = $ga->getQRCodeGoogleUrl($user->username . '@' . gs('site_name'), $secret);
        $pageTitle = '2FA Security';
        return view('Template::user.twofactor', compact('pageTitle', 'secret', 'qrCodeUrl'));
    }

    public function create2fa(Request $request) {
        $user = auth()->user();
        $request->validate([
            'key'  => 'required',
            'code' => 'required',
        ]);
        $response = verifyG2fa($user, $request->code, $request->key);
        if ($response) {
            $user->tsc = $request->key;
            $user->ts  = Status::ENABLE;
            $user->save();
            $notify[] = ['success', 'Two factor authenticator activated successfully'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'Wrong verification code'];
            return back()->withNotify($notify);
        }
    }

    public function disable2fa(Request $request) {
        $request->validate([
            'code' => 'required',
        ]);

        $user     = auth()->user();
        $response = verifyG2fa($user, $request->code);
        if ($response) {
            $user->tsc = null;
            $user->ts  = Status::DISABLE;
            $user->save();
            $notify[] = ['success', 'Two factor authenticator deactivated successfully'];
        } else {
            $notify[] = ['error', 'Wrong verification code'];
        }
        return back()->withNotify($notify);
    }

    public function transactions() {
        $pageTitle = 'Transactions';
        $remarks   = Transaction::distinct('remark')->orderBy('remark')->get('remark');

        $transactions = Transaction::where('user_id', auth()->id())->searchable(['trx'])->filter(['trx_type', 'remark'])->orderBy('id', 'desc')->paginate(getPaginate());

        return view('Template::user.transactions', compact('pageTitle', 'transactions', 'remarks'));
    }

    public function userData() {
        $user = auth()->user();

        if ($user->profile_complete == Status::YES) {
            return to_route('user.home');
        }

        $pageTitle  = 'User Data';
        $info       = json_decode(json_encode(getIpInfo()), true);
        $mobileCode = @implode(',', $info['code']);
        $countries  = json_decode(file_get_contents(resource_path('views/partials/country.json')));

        return view('Template::user.user_data', compact('pageTitle', 'user', 'countries', 'mobileCode'));
    }

    public function userDataSubmit(Request $request) {

        $user = auth()->user();

        if ($user->profile_complete == Status::YES) {
            return to_route('user.home');
        }

        $countryData  = (array) json_decode(file_get_contents(resource_path('views/partials/country.json')));
        $countryCodes = implode(',', array_keys($countryData));
        $mobileCodes  = implode(',', array_column($countryData, 'dial_code'));
        $countries    = implode(',', array_column($countryData, 'country'));

        $request->validate([
            'country_code' => 'required|in:' . $countryCodes,
            'country'      => 'required|in:' . $countries,
            'mobile_code'  => 'required|in:' . $mobileCodes,
            'username'     => 'required|unique:users|min:6',
            'mobile'       => ['required', 'regex:/^([0-9]*)$/', Rule::unique('users')->where('dial_code', $request->mobile_code)],
        ]);

        if (preg_match("/[^a-z0-9_]/", trim($request->username))) {
            $notify[] = ['info', 'Username can contain only small letters, numbers and underscore.'];
            $notify[] = ['error', 'No special character, space or capital letters in username.'];
            return back()->withNotify($notify)->withInput($request->all());
        }

        $user->country_code = $request->country_code;
        $user->mobile       = $request->mobile;
        $user->username     = $request->username;

        $user->address      = $request->address;
        $user->city         = $request->city;
        $user->state        = $request->state;
        $user->zip          = $request->zip;
        $user->country_name = @$request->country;
        $user->dial_code    = $request->mobile_code;

        $user->profile_complete = Status::YES;
        $user->save();

        return to_route('user.home');
    }

    public function attachmentDownload($fileHash) {
        $filePath  = decrypt($fileHash);
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        $title     = slug(gs('site_name')) . '- attachments.' . $extension;
        try {
            $mimetype = mime_content_type($filePath);
        } catch (\Exception $e) {
            $notify[] = ['error', 'File does not exists'];
            return back()->withNotify($notify);
        }
        header('Content-Disposition: attachment; filename="' . $title);
        header("Content-Type: " . $mimetype);
        return readfile($filePath);
    }

}
