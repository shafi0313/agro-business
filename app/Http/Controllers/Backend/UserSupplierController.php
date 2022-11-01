<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use App\Models\UserFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\PurchaseLedgerBook;
use RealRashid\SweetAlert\Facades\Alert;

class UserSupplierController extends Controller
{
    public function index()
    {
        if ($error = $this->authorize('supplier-manage')) {
            return $error;
        }
        $users = User::where('role', 3)->orderby('business_name', 'ASC')->get();
        return view('admin.user.supplier.index', compact('users'));
    }

    public function create()
    {
        if ($error = $this->authorize('supplier-add')) {
            return $error;
        }
        return view('admin.user.supplier.create');
    }

    public function store(Request $request)
    {
        if ($error = $this->authorize('supplier-add')) {
            return $error;
        }
        $this->validate($request, [
            'name' => 'required',
            'email' => 'email|unique:users,email',
            'phone' => 'required|numeric',
            'address' => 'required',
        ]);

        // Tmm So Id
        $getTmmId = User::where('role', 3)->count() + 1;
        if (strlen($getTmmId) == 1) {
            $tmmId = '00'. $getTmmId;
        } elseif (strlen($getTmmId) == 2) {
            $tmmId = '0'. $getTmmId;
        } else {
            $tmmId = $getTmmId;
        }

        // Image
        $image_name = '';
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = "user_photo".rand(0, 10000).'.'.$image->getClientOriginalExtension();
            $request->image->move('uploads/images/product/', $image_name);
        } else {
            $image_name = "company_logo.png";
        }

        DB::beginTransaction();

        $data = [
            'tmm_so_id' => $request->get('tmm_so_id') .$tmmId,
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'role' =>  3,
            'is_' => 0,
            'phone' => $request->get('phone'),
            'business_name' => $request->get('business_name'),
            // 'password' =>bcrypt($request->get('password')),
            'password' =>bcrypt(4321),
            'address' => $request->get('address'),
            'profile_photo_path' => $image_name,
        ];

        $user = User::create($data);

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
                    $fileName = "user_file_".rand(0, 100000).".".$extension;
                    $destinationPath = 'files/user_file'.'/';
                    $file->move($destinationPath, $fileName);
                    $userFile = [
                        'user_id' => $user->id,
                        'is_' =>  3,
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
        $ledgerBook['prepared_id'] = auth()->user()->id;
        $ledgerBook['type'] = 0;
        $ledgerBook['invoice_no'] = 0;
        if ($request->preCal==1) {
            if ($open > 0) {
                $ledgerBook['purchase_amt'] = $open;
                $ledgerBook['payment'] = 0;
            } else {
                $ledgerBook['payment'] = $open;
                $ledgerBook['purchase_amt'] = 0;
            }
            PurchaseLedgerBook::create($ledgerBook);
        } else {
            if ($open > 0) {
                $ledgerBook['purchase_amt'] = 0;
                $ledgerBook['payment'] = 0;
            } else {
                $ledgerBook['payment'] = 0;
                $ledgerBook['purchase_amt'] = 0;
            }
            PurchaseLedgerBook::create($ledgerBook);
        }

        try {
            $user == true;
            DB::commit();
            toast('Successfully Inserted', 'success');
            return redirect()->route('supplier.index');
        } catch (\Exception $ex) {
            DB::rollBack();
            toast($ex->getMessage().'Inserted Failed', 'error');
            return back();
        }
    }

    // User File Store
    public function userFileStore(Request $request)
    {
        if ($error = $this->authorize('supplier-add')) {
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
        return view('admin.user.supplier.show', compact('customers'));
    }

    // Edit
    public function edit($id)
    {
        if ($error = $this->authorize('supplier-edit')) {
            return $error;
        }
        $user = User::find($id);
        $opening_bl = PurchaseLedgerBook::where('type', 0)->where('supplier_id', $id)->first();
        $userFiles = UserFile::where('user_id', $id)->get();
        return view('admin.user.supplier.edit', compact('user', 'userFiles', 'opening_bl'));
    }

    // Update
    public function update(Request $request, $id)
    {
        if ($error = $this->authorize('supplier-edit')) {
            return $error;
        }
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = "user_photo".rand(0, 10000).'.'.$image->getClientOriginalExtension();
            $request->image->move('uploads/images/product/', $image_name);
        } else {
            $image_name = $request->get('old_image');
        }

        $data = [
            // 'tmm_so_id' => $request->get('tmm_so_id') .$tmmId,
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'role' =>  3,
            'is_' => 0,
            'phone' => $request->get('phone'),
            'business_name' => $request->get('business_name'),
            // 'password' =>bcrypt($request->get('password')),
            // 'password' =>bcrypt(4321),
            'address' => $request->get('address'),
            'profile_photo_path' => $image_name,
        ];

        // Ledger Book
        $open = $request->get('total');
        if ($open > 0) {
            // $ledgerBook['sales_amt'] = $open;
            $ledgerBook['purchase_amt'] = $open;
            $ledgerBook['payment'] = 0;
        } else {
            $ledgerBook['payment'] = abs($open);
            $ledgerBook['purchase_amt'] = 0;
        }
        $salesLedgerUpdate = PurchaseLedgerBook::where('invoice_no', 0)->where('supplier_id', $id)->update($ledgerBook);

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

        if ($request->note != '' && $request->hasFile('name')=='') {
            foreach ($request->note as $key => $value) {
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
            toast('Supplier Update Successfully', 'success');
            return redirect()->back();
        } catch (\Exception $ex) {
            toast($ex->getMessage().'Supplier Update Failed', 'error');
            return redirect()->back();
        }
    }

    // Only User File Delete
    public function userFileDestroy($id)
    {
        if ($error = $this->authorize('supplier-delete')) {
            return $error;
        }
        $userFile = UserFile::find($id);
        $path =  public_path('files/user_file/'.$userFile->name);
        try {
            if ($userFile->name == 'company_logo.png') {
                $userFile->delete();
            } else {
                if (file_exists($path)) {
                    unlink($path);
                    $userFile->delete();
                } else {
                    $userFile->delete();
                }
            }
            Alert::success(__('app.success'), __('app.delete-success-message'));
            return redirect()->back();
        } catch (\Exception $ex) {
            Alert::error(__('app.oops'), __('app.delete-error-message'));
            return back();
        }
    }

    // Supplier Delete
    public function destroy($id)
    {
        if ($error = $this->authorize('supplier-delete')) {
            return $error;
        }
        $user = User::find($id);
        $path =  public_path('uploads/images/product/'.$user->profile_photo_path);
        // User File Delete
        $userFiles = UserFile::where('user_id', $id)->get();
        foreach ($userFiles as $userFile) {
            $currentFile = $userFile->name;
            $userFilePath = public_path('files/user_file/'.$currentFile);
            if (file_exists($userFilePath)) {
                unlink($userFilePath);
            }
        }
        try {
            if ($user->profile_photo_path == 'company_logo.png') {
                $user->delete();
            } else {
                if (file_exists($path)) {
                    $user->delete();
                    unlink($path);
                } else {
                    $user->delete();
                }
            }
            Alert::success(__('app.success'), __('app.delete-success-message'));
            return redirect()->back();
        } catch (\Exception $ex) {
            Alert::error(__('app.oops'), __('app.delete-error-message'));
            return back();
        }
    }
}
