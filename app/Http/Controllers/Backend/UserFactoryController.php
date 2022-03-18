<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use App\Models\UserFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\SalesLedgerBook;

class UserFactoryController extends Controller

{
    public function index()
    {
        $users = User::where('role', 4)->get();
        return view('admin.user.factory.index', compact('users'));
    }

    public function create()
    {
        if ($error = $this->sendPermissionError('create')) {
            return $error;
        }
        return view('admin.user.factory.create');
    }

    public function store(Request $request)
    {
        if ($error = $this->sendPermissionError('create')) {
            return $error;
        }
        // return $request;
        $this->validate($request, [
            'name' => 'required',
            'email' => 'email|unique:users,email',
            'phone' => 'required|numeric',
            'address' => 'required',
        ]);

        // Tmm So Id
        $getTmmId = User::where('role', 4)->count() + 1;
        if(strlen($getTmmId) == 1){
            $tmmId = '00'. $getTmmId;
        }elseif(strlen($getTmmId) == 2){
            $tmmId = '0'. $getTmmId;
        }else{
            $tmmId = $getTmmId;
        }

        DB::beginTransaction();

        $data = [
            'tmm_so_id' => $request->get('tmm_so_id') .$tmmId,
            'name' => $request->get('name'),
            'email' => "store".rand(0,10000)."@mondolag.com",
            'role' =>  4,
            'is_' => 0,
            'phone' => $request->get('phone'),
            // 'password' =>bcrypt($request->get('password')),
            'password' =>bcrypt(4321),
            'address' => $request->get('address'),
            'shop_address' => $request->get('shop_address'),
            'profile_photo_path' => "company_logo.png",
        ];
        // return $data;
        $user = User::create($data);

        if($request->hasFile('name')!=''){
            $this->validate($request, [
                'name' => 'required',
                'name.*' => 'required',
                'note' => 'required',
            ]);
            if($request->hasFile('name')) {
                $files = $request->file('name');
                foreach($files as $key => $file){
                    $extension = $file->getClientOriginalExtension();
                    $fileName = "user_file_".rand(0,100000).".".$extension;
                    $destinationPath = 'files/user_file'.'/';
                    $file->move($destinationPath, $fileName);
                    $userFile = [
                        'user_id' => $user->id,
                        'is_' =>  $request->get('role'),
                        'name' => $fileName,
                        'note' => $request->note[$key],
                    ];
                    UserFile::create($userFile);
                }
            }
        };

        // Ledger Book
        $open = $request->get('total');
        $ledgerBook['user_id'] = $user->id;
        $ledgerBook['customer_id'] = $user->id;
        $ledgerBook['prepared_id'] = auth()->user()->id;
        $ledgerBook['type'] = 0;
        $ledgerBook['invoice_no'] = 0;
        if($request->preCal==1){
            if($open > 0){
                $ledgerBook['sales_amt'] = $open;
                $ledgerBook['payment'] = 0;
            }else{
                $ledgerBook['payment'] = $open;
                $ledgerBook['sales_amt'] = 0;
            }
            SalesLedgerBook::create($ledgerBook);
        }else{
            if($open > 0){
                $ledgerBook['sales_amt'] = 0;
                $ledgerBook['payment'] = 0;
            }else{
                $ledgerBook['payment'] = 0;
                $ledgerBook['sales_amt'] = 0;
            }
            SalesLedgerBook::create($ledgerBook);
        }

        try {
            $user == true;
            DB::commit();
            toast('Successfully Inserted','success');
            return redirect()->route('company-factory.index');
        } catch (\Exception $ex) {
            DB::rollBack();
            toast($ex->getMessage().'Inserted Faild','error');
            return back();
        }
    }

    // User File Store
    public function userFileStore(Request $request)
    {
        if ($error = $this->sendPermissionError('create')) {
            return $error;
        }
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
                        'is_' => 4,
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
        return view('admin.user.factory.show', compact('customers'));
    }

    // Edit
    public function edit($id)
    {
        if ($error = $this->sendPermissionError('edit')) {
            return $error;
        }
        $user = User::find($id);
        $userFiles = UserFile::where('user_id', $id)->get();
        return view('admin.user.factory.edit', compact('user','userFiles'));
    }

    // Update
    public function update(Request $request, $id)
    {
        if ($error = $this->sendPermissionError('edit')) {
            return $error;
        }
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
            'credit_limit' => $request->get('credit_limit'),
            'nominee_name' => $request->get('nominee_name'),
            'nominee_phone' => $request->get('nominee_phone'),
            'relation' => $request->get('relation'),
            // 'password' =>bcrypt($request->get('password')),
            'password' =>bcrypt(4321),
            'address' => $request->get('address'),
            'shop_address' => $request->get('shop_address'),
            'profile_photo_path' => $image_name,
        ];

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
