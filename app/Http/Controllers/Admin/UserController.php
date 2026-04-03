<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $roleFilter = $request->query('role');
        $query = User::with('roles');

        if (auth()->user()->hasRole('admin')) {
            $query->whereHas('roles', function ($q) {
                $q->whereIn('name', ['hr', 'employee']);
            });
        } elseif (auth()->user()->hasRole('hr')) {
            $query->whereHas('roles', function ($q) {
                $q->where('name', 'employee');
            });
        }

        if ($roleFilter) {
            $query->whereHas('roles', function ($q) use ($roleFilter) {
                $q->where('name', $roleFilter);
            });
        }

        $users = $query->get();

        return view('admin.users.index', [
            'users' => $users,
            'catName' => 'users',
            'roleFilter' => $roleFilter,
            'title' => $roleFilter ? ucfirst($roleFilter) . ' Management' : 'User Management',
            "breadcrumbs" => ["Dashboard", "Users", $roleFilter ? ucfirst($roleFilter) : 'All'],
            'simplePage' => 0,
            'scrollspy' => 0,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roleQuery = Role::query();
        if (auth()->user()->hasRole('admin')) {
            $roleQuery->whereIn('name', ['hr', 'employee']);
        } elseif (auth()->user()->hasRole('hr')) {
            $roleQuery->where('name', 'employee');
        }
        $roles = $roleQuery->get();
        return view('admin.users.create', [
            'roles' => $roles,
            'catName' => 'users',
            'title' => 'Create User',
            "breadcrumbs" => ["Dashboard", "Users", "Create"],
            'simplePage' => 0,
            'scrollspy' => 0,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::defaults()],
            'roles' => 'required|array',
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string|in:male,female,other',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'pincode' => 'required|string|max:20',
        ]);

        $userData = [
            'name' => $request->first_name . ' ' . $request->last_name,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'pincode' => $request->pincode,
        ];

        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('users', 'public');
            $userData['profile_image'] = $path;
            $userData['image'] = $path;
        }

        $user = User::create($userData);
        $user->assignRole($request->roles);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        
        $roleQuery = Role::query();
        if (auth()->user()->hasRole('admin')) {
            $roleQuery->whereIn('name', ['hr', 'employee']);
        } elseif (auth()->user()->hasRole('hr')) {
            $roleQuery->where('name', 'employee');
        }
        $roles = $roleQuery->get();
        return view('admin.users.edit', [
            'user' => $user,
            'roles' => $roles,
            'catName' => 'users',
            'title' => 'Edit User',
            "breadcrumbs" => ["Dashboard", "Users", "Edit"],
            'simplePage' => 0,
            'scrollspy' => 0,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'roles' => 'required|array',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string|in:male,female,other',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'pincode' => 'required|string|max:20',
        ]);

        $userData = [
            'name' => $request->first_name . ' ' . $request->last_name,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'pincode' => $request->pincode,
        ];

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('profile_image')) {
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }
            $path = $request->file('profile_image')->store('users', 'public');
            $userData['profile_image'] = $path;
            $userData['image'] = $path;
        }

        $user->update($userData);
        $user->syncRoles($request->roles);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        if ($user->image) {
            Storage::disk('public')->delete($user->image);
        }
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    public function toggleStatus(User $user)
    {
        $user->update(['status' => !$user->status]);
        return back()->with('success', 'Status updated successfully.');
    }
}
