<?php

namespace App\Http\Controllers\Dashboard;


use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read_users'])->only('index');
        $this->middleware(['permission:create_users'])->only('create');
        $this->middleware(['permission:update_users'])->only('edit');
        $this->middleware(['permission:delete_users'])->only('destroy');
    }

    public function index(Request $request)
    {
        $users = User::whereRoleIs('admin')->where(function ($q) use ($request) {
            return $q->when($request->search, function ($query) use ($request) {
                return $query->where('first_name', 'like', '%' . $request->search . '%')
                    ->orWhere('last_name', 'like', '%' . $request->search . '%');
            });
        })->latest()->paginate(5);
        return view('dashboard.users.index')->with('users', $users);
    }


    public function create()
    {
        return view('dashboard.users.create');
    }


    public function store(Request $request)
    {

        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users',
            'image' => 'image',
            'password' => 'required|confirmed',
            'permissions' => 'required|min:1'
        ]);

        $request_data = $request->except(['password', 'password_confirmation', 'permissions', 'image']);
        $request_data['password'] = bcrypt($request->password);
        if ($request->image) {
            Image::make($request->image)
                ->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save(public_path('uploads/user_images/' . $request->image->hashname()));
            $request_data['image'] = $request->image->hashname();
        }
        $user = User::create($request_data);

        if ($request->permissions != null) {

            $user->attachRole('admin');
            $user->syncPermissions($request->permissions);
        }
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.users.index');

    }


    public function edit($id)
    {
        $user = User::find($id);
        return view('dashboard.users.edit')->with('user', $user);
    }


    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'image' => 'image',
            'email' => ['required', Rule::unique('users')->ignore($user->id),
            ],
            'permissions' => 'required|min:1'
        ]);

        $request_data = $request->except(['permissions', 'image']);


        if ($request->image) {
            if ($user->image != 'default.png') {
                Storage::disk('public_uploads')->delete('/user_images/' . $user->image);

            }
            Image::make($request->image)
                ->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save(public_path('uploads/user_images/' . $request->image->hashname()));
            $request_data['image'] = $request->image->hashname();
        }

        $user->update($request_data);
        $user->syncPermissions($request->permissions);
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.users.index');

    }


    public function destroy($id)
    {

        $user = User::findOrFail($id);
        if ($user->image != 'default.png') {
            Storage::disk('public_uploads')->delete('/user_images/' . $user->image);

        }
        $user->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.users.index');
    }
}
