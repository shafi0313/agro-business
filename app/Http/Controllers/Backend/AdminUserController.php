<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use App\Models\UserFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AdminUserController extends Controller
{
    public function index()
    {
        if ($error = $this->authorize('user-manage')) {
            return $error;
        }
        $adminUsers = User::where('role', 1)->get();
        return view('admin.user_management.admin.index', compact('adminUsers'));
    }

    public function create()
    {
        if ($error = $this->authorize('user-add')) {
            return $error;
        }
        return view('admin.user_management.admin.create');
    }

    public function store(Request $request)
    {
        if ($error = $this->authorize('user-manage')) {
            return $error;
        }
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|numeric',
            'address' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);

        $image_name = '';
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = "user_".rand(0, 1000).'.'.$image->getClientOriginalExtension();
            $request->image->move('images/users/', $image_name);
        } else {
            $image_name = "company_logo.png";
        }
        DB::beginTransaction();

        // Tmm So Id
        $getTmmId = User::where('role', 5)->count() + 1;
        if (strlen($getTmmId) == 1) {
            $tmmId = '00'. $getTmmId;
        } elseif (strlen($getTmmId) == 2) {
            $tmmId = '0'. $getTmmId;
        } else {
            $tmmId = $getTmmId;
        }

        $data = [
            'name' => $request->input('name'),
            'tmm_so_id' => $request->get('tmm_so_id').$tmmId,
            'email' => strtolower($request->input('email')),
            'phone' => $request->input('phone'),
            'age' => $request->input('age'),
            'gender' => $request->input('gender'),
            'role' => 1,
            'is_' => 1,
            'address' => $request->input('address'),
            'profile_photo_path' => $image_name,
            'password' => bcrypt($request->input('password')),
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
                    $fileName = "admin_file_".rand(0, 100000).".".$extension;
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

        try {
            // $user = User::create($data);
            $permission = [
                'role_id' => $request->input('is_'),
                'model_type' => "App\Models\User",
                'model_id' =>  $user->id,
            ];
            DB::table('model_has_roles')->insert($permission);
            DB::commit();
            toast('User Successfully Inserted', 'success');
            return redirect()->route('admin-user.index');
        } catch (\Exception $ex) {
            DB::rollBack();
            toast($ex->getMessage().'User Inserted Faild', 'error');
            return back();
        }
    }

    // User File Store
    public function userFileStore(Request $request)
    {
        if ($error = $this->authorize('user-add')) {
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
                    $fileName = "admin_file_".rand(0, 100000).".".$extension;
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
        if ($error = $this->authorize('user-edit')) {
            return $error;
        }
        $adminUsers = User::find($id);
        $userFiles = UserFile::where('user_id', $id)->get();
        return view('admin.user_management.admin.edit', compact('adminUsers', 'userFiles'));
    }

    public function update(Request $request, $id)
    {
        if ($error = $this->authorize('user-edit')) {
            return $error;
        }
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required|numeric',
            'address' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);

        $image_name = '';
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = "user_".rand(0, 10000).'.'.$image->getClientOriginalExtension();
            $request->image->move('images/users/', $image_name);
        } else {
            $image_name = $request->oldImage;
        }
        DB::beginTransaction();
        $data = [
            'name' => $request->input('name'),
            'tmm_so_id' => $request->input('tmm_so_id'),
            'email' => strtolower($request->input('email')),
            'phone' => $request->input('phone'),
            'age' => $request->input('age'),
            'gender' => $request->input('gender'),
            'address' => $request->input('address'),
            'profile_photo_path' => $image_name,
            'password' => bcrypt($request->input('password')),
        ];

        // User File
        if ($request->hasFile('name')) {
            $files = $request->file('name');
            foreach ($files as $key => $file) {
                if ($files != '') {
                    $extension = $file->getClientOriginalExtension();
                    $fileName = "admin_file_".rand(0, 100000).".".$extension;
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

        $permission = [
            'role_id' => $request->input('is_')
        ];
        try {
            User::find($id)->update($data);
            DB::table('model_has_roles')->where('model_id', $id)->update($permission);
            DB::commit();
            toast('User Successfully Updated', 'success');
            return redirect()->route('admin-user.index');
        } catch (\Exception $ex) {
            DB::rollBack();
            toast($ex->getMessage().'User Updated Failed', 'error');
            return back();
        }
    }

    // Only User File Delete
    public function userFileDestroy($id)
    {
        if ($error = $this->authorize('user-delete')) {
            return $error;
        }
        $userFile = UserFile::find($id);
        $path =  public_path('files/user_file/'.$userFile->name);

        if ($userFile->name == 'company_logo.png') {
            $userFile->delete();
            toast('File Successfully Deleted', 'success');
            return redirect()->back();
        } else {
            if (file_exists($path)) {
                unlink($path);
                $userFile->delete();
                toast('File Successfully Deleted', 'success');
                return redirect()->back();
            } else {
                $userFile->delete();
                toast('File Delete Field', 'error');
                return redirect()->back();
            }
        }
    }
}
