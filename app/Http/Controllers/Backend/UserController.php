<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use App\Models\UserFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\SalesLedgerBook;

class UserController extends Controller

{
    public function userType()
    {
        return view('admin.user.type');
    }

    public function index()
    {
        $users = User::where('role', '!=', 1)->get();
        return view('admin.user.index', compact('users'));
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'email|unique:users,email',
            'phone' => 'required|numeric',
            'address' => 'required',
            'role' => 'required',
            // 'user_id' => 'required',
        ]);

        DB::beginTransaction();

        $image_name = '';
        if($request->hasFile('image')){
            $image = $request->file('image');
            $image_name = "user_photo".rand(0,10000).'.'.$image->getClientOriginalExtension();
            $request->image->move('images/users/',$image_name);
        }else{
            $image_name = "company_logo.png";
        }

        $role = $request->get('role');
        $data = [
            'tmm_so_id' => $request->get('tmm_so_id'),
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'role' =>  $role,
            'phone' => $request->get('phone'),
            'business_name' => $request->get('business_name'),
            // 'password' =>bcrypt($request->get('password')),
            'password' =>bcrypt(4321),
            'address' => $request->get('address'),
            'profile_photo_path' => $image_name,
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
                        'is' =>  $request->get('role'),
                        'name' => $fileName,
                        'note' => $request->note[$key],
                    ];
                    UserFile::create($userFile);
                }
            }
        };

        // Ledger Book
        if($request->preCal==1){
            $open = $request->get('total');
            $ledgerBook['user_id'] = $user->id;
            $ledgerBook['customer_id'] = $user->id;
            $ledgerBook['type'] = 0;
            $ledgerBook['invoice_no'] = 100;
            $ledgerBook['note'] = $request->payment_note;
            if($open > 0){
                $ledgerBook['sales_amt'] = $open;
                $ledgerBook['payment'] = 0;
            }else{
                $ledgerBook['payment'] = $open;
                $ledgerBook['sales_amt'] = 0;
            }
            SalesLedgerBook::create($ledgerBook);
        }

        try {
            $user == true;
            DB::commit();
            toast('Successfully Inserted','success');
            return redirect()->route('user.index');
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

    public function show($id)
    {
        $customers = User::find($id);
        return view('admin.user.show', compact('customers'));
    }

    public function edit($id)
    {
        $user = User::find($id);
        $userFiles = UserFile::where('user_id', $id)->get();
        return view('admin.user.edit', compact('user','userFiles'));
    }

    public function update(Request $request, $id)
    {
        $data = [
            'tmm_so_id' => $request->get('tmm_so_id'),
            'role' => $request->get('role'),
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'business_name' => $request->get('business_name'),
            // 'password' =>bcrypt($request->get('password')),
            // 'password' =>bcrypt(4321),
            'address' => $request->get('address'),
        ];

        // User File
        if ($request->hasFile('name')) {
            $files = $request->file('name');
            foreach ($files as $key => $file) {
                if ($files != '') {
                    $extension = $file->getClientOriginalExtension();
                    $fileName = "user_file_".rand(0, 100000).".".$extension;
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
