<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Storage;

class AdminManageController extends Controller
{
    protected $role = 'admin';
    protected $title = 'Admin Management';
    protected $viewPath = 'admin.admins';

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = User::role($this->role);

            // Total records
            $totalRecords = User::role($this->role)->count();
            // Search
            if ($search = $request->input('search.value')) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            }

            // Filtered records count
            $filteredRecords = $query->count();

            // Order
            if ($request->has('order')) {
                $columnIdx = $request->input('order.0.column');
                $dir = $request->input('order.0.dir');
                $columns = ['name', 'name', 'status', 'name']; // Map DT columns to DB columns
                $query->orderBy($columns[$columnIdx] ?? 'name', $dir);
            }

            // Paginate
            $users = $query->skip($request->input('start'))
                ->take($request->input('length'))
                ->get();

            $data = [];
            foreach ($users as $user) {
                $statusBadge = $user->status
                    ? '<span class="badge badge-light-success">Active</span>'
                    : '<span class="badge badge-light-danger">Inactive</span>';

                $actions = view('admin.users.partials.actions', ['user' => $user, 'role' => $this->role])->render();
                $media = view('admin.users.partials.media', ['user' => $user])->render();

                $data[] = [
                    'name' => $media,
                    'role' => '<p class="mb-0">' . ucfirst($this->role) . '</p><span class="text-success">Management</span>',
                    'status' => '<div class="text-center">' . $statusBadge . '</div>',
                    'action' => '<div class="text-center">' . $actions . '</div>',
                ];
            }

            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $filteredRecords,
                'data' => $data,
            ]);
        }

        return view($this->viewPath . '.index', [
            'catName' => 'users',
            'roleFilter' => $this->role,
            'title' => $this->title,
            "breadcrumbs" => ["Dashboard", "Users", ucfirst($this->role)],
            'simplePage' => 0,
            'scrollspy' => 0,
        ]);
    }

    public function create()
    {
        return view($this->viewPath . '.create', [
            'catName' => 'users',
            'role' => $this->role,
            'title' => 'Create ' . ucfirst($this->role),
            "breadcrumbs" => ["Dashboard", "Users", "Create"],
            'simplePage' => 0,
            'scrollspy' => 0,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::defaults()],
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string|in:male,female,other',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'pincode' => 'required|string|max:20',
            'status' => 'required|in:0,1'
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
            'status' => $request->status,
        ];

        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('users', 'public');
            $userData['profile_image'] = $path;
            $userData['image'] = $path;
        }

        $user = User::create($userData);
        $user->assignRole($this->role);

        return redirect()->route('admins.index')->with('success', ucfirst($this->role) . ' created successfully.');
    }

    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view($this->viewPath . '.edit', [
            'user' => $user,
            'catName' => 'users',
            'role' => $this->role,
            'title' => 'Edit ' . ucfirst($this->role),
            "breadcrumbs" => ["Dashboard", "Users", "Edit"],
            'simplePage' => 0,
            'scrollspy' => 0,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string|in:male,female,other',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'pincode' => 'required|string|max:20',
            'status' => 'required|in:0,1'
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
            'status' => $request->status,
        ];

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('profile_image')) {
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }
            $path = $request->file('profile_image')->store('users', 'public');
            $userData['profile_image'] = $path;
            $userData['image'] = $path;
        }

        $user->update($userData);

        return redirect()->route('admins.index')->with('success', ucfirst($this->role) . ' updated successfully.');
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        if ($user->image) {
            Storage::disk('public')->delete($user->image);
        }
        $user->delete();

        return redirect()->route('admins.index')->with('success', ucfirst($this->role) . ' deleted successfully.');
    }
}
