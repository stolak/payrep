<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Traits\AccountTrait;
use App\Http\Traits\SessionTrait;
use App\Models\AccountChart;
use App\Models\Customer;
use App\Models\Loan;
use App\Models\Title;
use App\Models\User;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\URL;
use Session;

class RegistrationController extends Controller
{
    public function index(Request $request)
    {
        if (!(URL::previous() == URL::current())) {
            $request->session()->forget('category');
            $request->session()->forget('economiccode');
            $request->session()->forget('description');
        }
        $data['fees'] = DB::table('fee_charges')->where('id', 1)->value('amount');
        $data['rid'] = SessionTrait::validate($request, 'rid');
        $data['id'] = SessionTrait::validate($request, 'id');

        $currentProfile = Customer::find($data['rid']);

        if ($currentProfile) {
            $request->session()->forget('rid');
            $data['id'] = $currentProfile->id;
            $data['guarantorName'] = $currentProfile->guarrantor_full_name;
            $data['guarantorPhoneNumber'] = $currentProfile->guarrantor_phone;
            $data['guarantorEmail'] = $currentProfile->guarrantor_email;
            $data['guarantorHomeAddress'] = $currentProfile->guarrantor_h_address;
            $data['guarantorOfficeAddress'] = $currentProfile->guarrantor_o_address;

            $data['title'] = $currentProfile->titleID;
            $data['email'] = $currentProfile->email;
            $data['phoneNumber'] = $currentProfile->phone;
            $data['otherName'] = $currentProfile->middle_name;
            $data['firstName'] = $currentProfile->first_name;
            $data['lastName'] = $currentProfile->last_name;
            $data['marketer'] = $currentProfile->marketerID;
            $data['address'] = $currentProfile->address;
            $data['officeAddress'] = $currentProfile->office_address;
            $data['bvn'] = $currentProfile->bvn;
            $data['nin'] = $currentProfile->nin;
            $data['remark'] = $currentProfile->remarks;
            $data['status_office'] = $currentProfile->is_o_address_verified;
            $data['status_home'] = $currentProfile->is_h_address_verified;
            $data['state'] = $currentProfile->state;
            $data['lga'] = $currentProfile->lga;
            $data['business'] = $currentProfile->business;
            $data['guarantorBusiness'] = $currentProfile->guarantor_business;

        } else {
            $data['guarantorName'] = SessionTrait::validate($request, 'guarantorName');
            $data['guarantorPhoneNumber'] = SessionTrait::validate($request, 'guarantorPhoneNumber');
            $data['guarantorEmail'] = SessionTrait::validate($request, 'guarantorEmail');
            $data['guarantorHomeAddress'] = SessionTrait::validate($request, 'guarantorHomeAddress');
            $data['guarantorOfficeAddress'] = SessionTrait::validate($request, 'guarantorOfficeAddress');

            $data['title'] = SessionTrait::validate($request, 'title');
            $data['email'] = SessionTrait::validate($request, 'email');
            $data['phoneNumber'] = SessionTrait::validate($request, 'phoneNumber');
            $data['otherName'] = SessionTrait::validate($request, 'otherName');
            $data['firstName'] = SessionTrait::validate($request, 'firstName');
            $data['lastName'] = SessionTrait::validate($request, 'lastName');
            $data['marketer'] = SessionTrait::validate($request, 'marketer');
            $data['address'] = SessionTrait::validate($request, 'address');
            $data['officeAddress'] = SessionTrait::validate($request, 'officeAddress');
            $data['bvn'] = SessionTrait::validate($request, 'bvn');
            $data['nin'] = SessionTrait::validate($request, 'nin');
            $data['remark'] = SessionTrait::validate($request, 'remark');
            $data['state'] = SessionTrait::validate($request, 'state');
            $data['lga'] = SessionTrait::validate($request, 'lga');
            $data['business'] = SessionTrait::validate($request, 'business');
            $data['guarantorBusiness'] = SessionTrait::validate($request, 'guarantorBusiness');
            $data['status_office'] = $request->input('status_office');
            $data['status_home'] = $request->input('status_home');
        }
        if (isset($_POST['addnew'])) {

            $this->validate($request, [
                'email' => 'nullable|string|unique:customers,email',
                'email' => 'nullable|string|unique:users,email',
                'phoneNumber' => 'required|string|unique:users,username',
                'phoneNumber' => 'required|string|unique:customers,phone',
                'firstName' => 'required',
                'lastName' => 'required',
                'address' => 'required',
                'officeAddress' => 'required',
                'guarantorName' => 'required',
                'guarantorPhoneNumber' => 'required',
                'guarantorHomeAddress' => 'required',
                'guarantorOfficeAddress' => 'required',
            ]);
            $customer = DB::table('customers')->insertGetId([
                'titleID' => $request->input('title'),
                'first_name' => $request->input('firstName'),
                'middle_name' => $request->input('otherName'),
                'last_name' => $request->input('lastName'),
                'phone' => $request->input('phoneNumber'),
                'email' => $request->input('email'),
                'office_address' => $request->input('officeAddress'),
                'address' => $request->input('address'),
                'marketerID' => $request->input('marketer'),
                'guarrantor_full_name' => $request->input('guarantorName'),
                'bvn' => $request->input('bvn'),
                'nin' => $request->input('nin'),
                'guarrantor_phone' => $request->input('guarantorPhoneNumber'),
                'guarrantor_email' => $request->input('guarantorEmail'),

                'guarrantor_o_address' => $request->input('guarantorOfficeAddress'),
                'guarrantor_h_address' => $request->input('guarantorHomeAddress'),
                'is_o_address_verified' => $request->input('status_office') ? 1 : 0,
                'is_h_address_verified' => $request->input('status_home') ? 1 : 0,
                'state' => $request->input('state'),
                'lga' => $request->input('lga'),
                'business' => $request->input('business'),
                'guarantor_business' => $request->input('guarantorBusiness'),
                'remarks' => $request->input('remark'),
                'registerdBy' => Auth::user()->id,
            ]);

            $id = $request->input('email') ? DB::table('users')->insertGetId(array(
                'name' => $request->input('firstName') . ' ' . $request->input('lastName'),
                'username' => $request->input('phoneNumber'),
                'email' => $request->input('email'),
                'userrole' => 5,
                'usertype' => 3,
                'createdby' => Auth::user()->id,
                'password' => Hash::make('12345'),
            )) : null;
            $subheadid = DB::table('setup_subheads')->where('id', 1)->value('subhead_id');
            $subhead = AccountTrait::getSubheadDetails($subheadid);
            if ($subhead) {
                $account = DB::table('account_charts')->insertGetId([
                    'groupid' => $subhead->groupid,
                    'headid' => $subhead->headid,
                    'subheadid' => $subheadid,
                    'accountno' => 0, // resolve later
                    'accountdescription' => $request->input('firstName') . ' ' . $request->input('lastName'),
                    'status' => 1,
                    'rank' => 0,
                ]);
            }
            Customer::where('id', $customer)->update([
                'user_id' => $id,
                'account_id' => $account,
            ]);

            SessionTrait::forget(
                $request, array_keys($request->input())
            );
            return back()->with('message', 'New record successfully added.');
        }

        if (isset($_POST['update'])) {
            $this->validate($request, [
                'email' => 'required|string|unique:customers,email,' . $request->input('id'),
                'phoneNumber' => 'required|string|unique:customers,phone,' . $request->input('id'),
                'firstName' => 'required',
                'lastName' => 'required',
                'address' => 'required',
            ]);
            Customer::where('id', $request->input('id'))->update([
                'titleID' => $request->input('title'),
                'first_name' => $request->input('firstName'),
                'middle_name' => $request->input('otherName'),
                'last_name' => $request->input('lastName'),
                'phone' => $request->input('phoneNumber'),
                'email' => $request->input('email'),
                'office_address' => $request->input('officeAddress'),
                'address' => $request->input('address'),
                'marketerID' => $request->input('marketer'),
                'guarrantor_full_name' => $request->input('guarantorName'),
                'bvn' => $request->input('bvn'),
                'nin' => $request->input('nin'),
                'guarrantor_phone' => $request->input('guarantorPhoneNumber'),
                'guarrantor_email' => $request->input('guarantorEmail'),

                'guarrantor_o_address' => $request->input('guarantorOfficeAddress'),
                'guarrantor_h_address' => $request->input('guarantorHomeAddress'),
                'is_o_address_verified' => $request->input('status_office') ? 1 : 0,
                'is_h_address_verified' => $request->input('status_home') ? 1 : 0,
                'remarks' => $request->input('remark'),
            ]);
            SessionTrait::forget(
                $request, array_keys($request->input())
            );

            return back()->with('message', 'New record successfully added.');
        }

        if (isset($_POST['delete'])) {
            if (Loan::where('customer_id', $request->input('id'))->first()) {
                return back()->with('error_message', 'Client Already exist with transaction. Hence, record cannot be deleted!');
            }
            Customer::destroy($request->input('id'));
            return back()->with('message', ' Record successfully trashed.');
        }

        if (isset($_POST['deactivate'])) {
            Customer::where('id', $request->input('id'))->update([
                'status' => 0,
            ]);
            return back()->with('message', ' Record successfully deactivated.');
        }
        if (isset($_POST['activate'])) {
            $this->validate($request, [
                'bank' => 'required',
                'paymentDate' => 'required',
            ]);
            $customer_details = Customer::find($request->input('id'));

            if ($customer_details->status) {
                return back()->with('error_message', 'Oops Customer already activated!');
            }
            $ref = AccountTrait::RefNo();

            AccountTrait::debitAccount(
                $request->input('bank'),
                $data['fees'],
                $ref,
                date('Y-m-d'),
                'Registration fees: ' . $customer_details->first_name,
                Auth::User()->id,
                $ref
            );

            $account = DB::table('account_setups')->where('id', 2)->value('account_id');
            AccountTrait::creditAccount(
                $account,
                $data['fees'],
                $ref, date('Y-m-d'),
                'Registration fees: ' . $customer_details->first_name,
                Auth::User()->id,
                $ref);
            Customer::where('id', $request->input('id'))->update([
                'status' => 1,
            ]);
            return back()->with('message', ' Record successfully activated.');
        }

        $data['Title'] = Title::all();
        $data['customers'] = Customer::leftJoin('titles', 'titles.id', '=', 'customers.titleID')
            ->leftJoin('users', 'users.id', '=', 'customers.marketerID')
            ->select('customers.*', 'titles.title', 'users.name')
            ->get();
        $data['Marketer'] = User::where('userrole', 3)->get();
        $data['banks'] = AccountChart::where('subheadid', 3)->orWhere('subheadid', 1)->get();
        return view('setup.registration', $data);

    }

}
