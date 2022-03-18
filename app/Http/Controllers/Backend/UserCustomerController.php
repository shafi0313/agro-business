<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use App\Models\Account;
use App\Models\UserFile;
use App\Models\CustomerInfo;
use Illuminate\Http\Request;
use App\Models\SalesLedgerBook;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class UserCustomerController extends Controller

{
    public function index()
    {
        $users = User::where('role', 2)->orderby('business_name','ASC')->get();
        return view('admin.user.customer.index', compact('users'));
    }

    public function create()
    {
        if ($error = $this->sendPermissionError('create')) {
            return $error;
        }
        return view('admin.user.customer.create');
    }

    public function store(Request $request)
    {
        // return $request;
        $this->validate($request, [
            'name' => 'required',
            'email' => 'email|unique:users,email',
            'phone' => 'required|numeric',
            'address' => 'required',
            'credit_limit' => 'required',
        ]);

        DB::beginTransaction();

        // Tmm So Id
        $getTmmId = User::where('role', 2)->count() + 1;
        if(strlen($getTmmId) == 1){
            $tmmId = '00'. $getTmmId;
        }elseif(strlen($getTmmId) == 2){
            $tmmId = '0'. $getTmmId;
        }else{
            $tmmId = $getTmmId;
        }

        $image_name = '';
        if($request->hasFile('image')){
            $image = $request->file('image');
            $image_name = "user_photo".rand(0,10000).'.'.$image->getClientOriginalExtension();
            $request->image->move('images/users/',$image_name);
        }else{
            $image_name = "company_logo.png";
        }

        $data = [
            'tmm_so_id' => $request->get('tmm_so_id') .$tmmId,
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'role' =>  2,
            'is_' => 0,
            'phone' => $request->get('phone'),
            'business_name' => $request->get('business_name'),
            // 'password' =>bcrypt($request->get('password')),
            'password' =>bcrypt(4321),
            'address' => $request->get('address'),
            'profile_photo_path' => $image_name,
        ];
        // return $data;
        $user = User::create($data);

        $customerInfo = [
            'user_id' => $user->id,
            'type' => $request->type,
            'credit_limit' => $request->get('credit_limit'),
            'nominee_name' => $request->get('nominee_name'),
            'nominee_phone' => $request->get('nominee_phone'),
            'relation' => $request->get('relation'),
            'shop_address' => $request->get('shop_address'),
            'opening_bl' => $request->get('total'),
            'note' => $request->get('opening_bl_note'),
        ];
        CustomerInfo::create($customerInfo);

        if($request->hasFile('name')) {
            $files = $request->file('name');
            foreach($files as $key => $file){
                $extension = $file->getClientOriginalExtension();
                $fileName = "user_file_".rand(0,100000).".".$extension;
                $destinationPath = 'files/user_file'.'/';
                $file->move($destinationPath, $fileName);
                $userFile = [
                    'user_id' => $user->id,
                    'is_' =>  2,
                    'name' => $fileName,
                    'note' => $request->note[$key],
                ];
                UserFile::create($userFile);
            }
        }

        if ($request->preCal==1) {
            // Ledger Book
            $open = $request->get('total');
            $ledgerBook['user_id'] = $user->id;
            $ledgerBook['customer_id'] = $user->id;
            $ledgerBook['prepared_id'] = auth()->user()->id;
            $ledgerBook['type'] = 0;
            $ledgerBook['invoice_no'] = 0;
            if ($request->preCal==1) {
                if ($open > 0) {
                    // $ledgerBook['sales_amt'] = $open;
                    $ledgerBook['net_amt'] = $open;
                    $ledgerBook['payment'] = 0;
                } else {
                    $ledgerBook['payment'] = $open;
                    $ledgerBook['net_amt'] = 0;
                }
                SalesLedgerBook::create($ledgerBook);
            } else {
                if ($open > 0) {
                    $ledgerBook['net_amt'] = 0;
                    $ledgerBook['payment'] = 0;
                } else {
                    $ledgerBook['payment'] = 0;
                    $ledgerBook['net_amt'] = 0;
                }
                SalesLedgerBook::create($ledgerBook);
            }

            // Accunt
            // $account ['user_id'] = $user->id;
            // $account ['note'] = $request->opening_bl_note;
            // $account ['tmm_so_id'] = auth()->user()->id;
            // $account ['payment_by'] = 'Previous';
            // $account ['date'] = date('Y-m-d');
            // if ($open > 0) {
            //     $account['ac_type'] = 1;
            //     $account['debit'] = $open;
            //     $account['credit'] = 0;
            // } else {
            //     $account['ac_type'] = 2;
            //     $account['credit'] = $open;
            // }
            // Account::create($account);
        }

        try {
            $user == true;
            DB::commit();
            toast('Successfully Inserted','success');
            return redirect()->route('customer.index');
        } catch (\Exception $ex) {
            DB::rollBack();
            toast($ex->getMessage().'Inserted Faild','error');
            return back();
        }
    }

    // User File Store
    public function userFileStore(Request $request)
    {
        $user_id = $request->get('user_id');
        if ($request->hasFile('name')!='') {
            $this->validate($request, [
                'name' => 'required',
                'name.*' => 'required',
                'note' => 'required',
            ]);
            if ($request->hasFile('name')) {
                $files = $request->file('name');
                foreach ($files as $key => $file) {
                    $extension = $file->getClientOriginalExtension();
                    $fileName = "customer_file_".rand(0, 100000).".".$extension;
                    $destinationPath = 'files/user_file'.'/';
                    $file->move($destinationPath, $fileName);
                    $userFile = [
                        'user_id' => $user_id,
                        'is_' => 3,
                        'name' => $fileName,
                        'note' => $request->note[$key],
                    ];
                    UserFile::create($userFile);
                }
                toast('File Successfully Inserted', 'success');
                return redirect()->back();
            }
        }
    }

    public function show($id)
    {
        $customers = User::find($id);
        return view('admin.user.customer.show', compact('customers'));
    }

    // Edit
    public function edit($id)
    {
        if ($error = $this->sendPermissionError('edit')) {
            return $error;
        }
        $user = User::find($id);
        $userFiles = UserFile::where('user_id', $id)->get();
        $opening_bl = SalesLedgerBook::where('customer_id', $id)->where('invoice_no', 0)->first();
        return view('admin.user.customer.edit', compact('user','userFiles','opening_bl'));
    }

    // Update
    public function update(Request $request, $id)
    {
        // return $request;
        if($request->hasFile('image'))
        {
            $image = $request->file('image');
            $image_name = "user_photo".rand(0,10000).'.'.$image->getClientOriginalExtension();
            $request->image->move('images/users/',$image_name);
        }else{
            $image_name = $request->get('old_image');
        }

        $data = [
            'tmm_so_id' => $request->get('tmm_so_id'),
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'business_name' => $request->get('business_name'),
            'password' =>bcrypt($request->get('password')),
            'address' => $request->get('address'),
            'profile_photo_path' => $image_name,
        ];

        $customer = [
            'type' => $request->type,
            'credit_limit' => $request->get('credit_limit'),
            'nominee_name' => $request->get('nominee_name'),
            'nominee_phone' => $request->get('nominee_phone'),
            'relation' => $request->get('relation'),
            'shop_address' => $request->get('shop_address'),
            'opening_bl' => $request->get('total'),
            'note' => $request->get('opening_bl_note'),
        ];
        CustomerInfo::where('user_id', $id)->update($customer);

        // Ledger Book
        $open = $request->get('total');
        if($open > 0){
            // $ledgerBook['sales_amt'] = $open;
            $ledgerBook['net_amt'] = $open;
            $ledgerBook['payment'] = 0;
        }else{
            $ledgerBook['payment'] = abs($open);
            $ledgerBook['net_amt'] = 0;
        }
        $salesLedgerUpdate = SalesLedgerBook::where('invoice_no', 0)->where('customer_id',$id)->update($ledgerBook);

        // Ledger Book
        if ($salesLedgerUpdate==null) {
            $open = $request->get('total');
            $ledgerBook['user_id'] = $id;
            $ledgerBook['customer_id'] = $id;
            $ledgerBook['prepared_id'] = auth()->user()->id;
            $ledgerBook['type'] = 0;
            $ledgerBook['invoice_no'] = 0;
            if ($open > 0) {
                $ledgerBook['net_amt'] = $open;
                $ledgerBook['payment'] = 0;
            } else {
                $ledgerBook['payment'] = $open;
                $ledgerBook['net_amt'] = 0;
            }
            SalesLedgerBook::create($ledgerBook);
        }

        // User File
        if ($request->hasFile('name')) {
            $files = $request->file('name');
            foreach ($files as $key => $file) {
                if ($files != '') {
                    $extension = $file->getClientOriginalExtension();
                    $fileName = "customer_file_".rand(0, 100000).".".$extension;
                    $destinationPath = 'files/user_file'.'/';
                    $file->move($destinationPath, $fileName);
                    $files = UserFile::where('id', $request->id[$key])->first();
                    $path =  public_path('files/user_file/'.$files->name);
                    unlink($path);
                    $fileName = $fileName;
                } else {
                    $fileName = $request->get('old_name');
                }
                $userFile = [
                    'name' => $fileName,
                    'note' => $request->note[$key],
                ];
                $getData = UserFile::where('id', $request->id[$key])->first();
                $getData->update($userFile);
            }
        }

        if($request->note != '' && $request->hasFile('name')==''){
            foreach($request->note as $key => $value){
                $data = [
                    'note' => $request->note[$key],
                ];
                $gdata = UserFile::where('id', $request->id[$key])->first();
                $gdata->update($data);
            }
        }

        try {
            $update  = User::find($id);
            $update->update($data);
            toast('Customer Update Successfully','success');
            return redirect()->back();
        } catch(\Exception $ex) {
            toast($ex->getMessage().'Customer Update Faild','error');
            return redirect()->back();
        }
    }

    // Only User File Delete
    public function userFileDestroy($id)
    {
        if ($error = $this->sendPermissionError('delete')) {
            return $error;
        }
        $userFile = UserFile::find($id);
        $path =  public_path('files/user_file/'.$userFile->name);

        if($userFile->name == 'company_logo.png'){
            $userFile->delete();
            toast('File Successfully Deleted','success');
            return redirect()->back();
        }else{
            if(file_exists($path)){
                unlink($path);
                $userFile->delete();
                toast('File Successfully Deleted','success');
                return redirect()->back();
            }else{
                $userFile->delete();
                toast('File Delete Field','error');
                return redirect()->back();
            }
        }
    }

    // Customer Delete
    public function destroy($id)
    {
        if ($error = $this->sendPermissionError('delete')) {
            return $error;
        }
        $user = User::find($id);
        $path =  public_path('images/users/'.$user->profile_photo_path);

        // User File Delete
        $userFiles = UserFile::where('user_id', $id)->get();
        foreach($userFiles as $userFile){
            $currentFile = $userFile->name;
            $userFilePath = public_path('files/user_file/'.$currentFile);
            if(file_exists($userFilePath)){
                unlink($userFilePath);
            }

        }

        if($user->profile_photo_path == 'company_logo.png'){
            $user->delete();
            toast('File Successfully Deleted','success');
            return redirect()->back();
        }else{
            if(file_exists($path)){
                $user->delete();
                unlink($path);
                toast('File Successfully Deleted','success');
                return redirect()->back();
            }else{
                $user->delete();
                toast('File Successfully Deleted','success');
                return redirect()->back();
            }
        }
    }
}
