<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use App\Models\UserFile;
use Illuminate\Http\Request;
use App\Models\SalesLedgerBook;
use App\Models\PurchaseLedgerBook;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SupplierController extends Controller

{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suppliers = User::where('role',3)->get();
        return view('admin.supplier.index', compact('suppliers'));
    }

    public function create()
    {
        if ($error = $this->sendPermissionError('create')) {
            return $error;
        }
        return view('admin.supplier.create');
    }

    public function store(Request $request)
    {
        // return $request;
        $this->validate($request, [
            'supplier_name' => 'required',
            'email' => 'email|unique:users,email',
            'phone' => 'required|numeric',
            'address' => 'required',
            'business_name' => 'required',
        ]);

        DB::beginTransaction();
        // return $request->get('supplier_name');

        $image_name = '';
        if($request->hasFile('image')){
            $image = $request->file('image');
            $image_name = "supplier_".rand(0,100000).'.'.$image->getClientOriginalExtension();
            $request->image->move('images/users/',$image_name);
        }else{
            $image_name = "company_logo.png";
        }

        $data = [
            'tmm_so_id' => $request->get('tmm_so_id'),
            'name' => $request->get('supplier_name'),
            'email' => $request->get('email'),
            'role' => 3,
            'phone' => $request->get('phone'),
            'business_name' => $request->get('business_name'),
            // 'password' =>bcrypt($request->get('password')),
            'password' =>bcrypt(4321),
            'address' => $request->get('address'),
            'profile_photo_path' => $image_name,
        ];
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
                    $fileName = "supplier_file_".rand(0,100000).".".$extension;
                    $destinationPath = 'files/user_file'.'/';
                    $file->move($destinationPath, $fileName);
                    $userFile = [
                        'user_id' => $user->id,
                        'is' => 3,
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
        $ledgerBook['supplier_id'] = $user->id;
        $ledgerBook['type'] = 0;
        $ledgerBook['invoice_no'] = 100;
        $ledgerBook['note'] = $request->payment_note;
        if($open > 0){
            $ledgerBook['purchase_amt'] = $open;
            $ledgerBook['payment'] = 0;
        }else{
            $ledgerBook['payment'] = $open;
            $ledgerBook['purchase_amt'] = 0;
        }
        PurchaseLedgerBook::create($ledgerBook);

        try {
            $user == true;
            DB::commit();
            toast('Supplier Successfully Inserted','success');
            return redirect()->route('supplier.index');
        } catch (\Exception $ex) {
            DB::rollBack();
            toast($ex->getMessage().'Supplier Inserted Faild','error');
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
                    $fileName = "supplier_file_".rand(0, 100000).".".$extension;
                    $destinationPath = 'files/user_file'.'/';
                    $file->move($destinationPath, $fileName);
                    $userFile = [
                        'user_id' => $user_id,
                        'is' => 3,
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

    public function edit($id)
    {
        if ($error = $this->sendPermissionError('edit')) {
            return $error;
        }
        $supplier = User::find($id);
        $userFiles = UserFile::where('user_id', $id)->get();
        return view('admin.supplier.edit', compact('supplier','userFiles'));
    }

    public function update(Request $request, $id)
    {
        $data = [
            'tmm_so_id' => $request->get('tmm_so_id'),
            'name' => $request->get('supplier_name'),
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'business_name' => $request->get('business_name'),
            // 'password' =>bcrypt($request->get('password')),
            // 'password' =>bcrypt(4321),
            'address' => $request->get('address'),
        ];
        User::find($id)->update($data);
        // $update;

        // User File
        if ($request->hasFile('name')) {
            $files = $request->file('name');
            foreach ($files as $key => $file) {
                if ($files != '') {
                    $extension = $file->getClientOriginalExtension();
                    $fileName = "supplier_file_".rand(0, 100000).".".$extension;
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
            toast('Supplier Update Successfully','success');
            return redirect()->route('supplier.index');
        } catch(\Exception $ex) {
            toast($ex->getMessage().'Supplier Update Faild','error');
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

    // Supplier Delete
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
