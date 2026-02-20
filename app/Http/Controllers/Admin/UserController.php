<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', User::class);
        $users = User::paginate(10);
        $usersCount = User::count();
        $recycleCount = User::onlyTrashed()->count();
        return view('users.index', compact('users', 'usersCount', 'recycleCount'));
    }

    public function search(Request $request)
    {
        if ($request->ajax()) {
            $this->authorize('viewAny', User::class);
            $searchTerm = $request->input('search');
            $searchBy = $request->input('search_by');

            $query = User::query();

            if ($searchTerm) {
                if ($searchBy === 'name') {
                    $query->where('name', 'LIKE', "%{$searchTerm}%");
                } elseif ($searchBy === 'id') {
                    $query->where('id', 'LIKE', "%{$searchTerm}%");
                } elseif ($searchBy === 'email') {
                    $query->where('email', 'LIKE', "%{$searchTerm}%");
                } elseif ($searchBy === 'role') {
                    $query->where('role', 'LIKE', "%{$searchTerm}%");
                } else {
                    $query->where(function ($q) use ($searchTerm) {
                        $q->where('name', 'LIKE', "%{$searchTerm}%")
                            ->orWhere('email', 'LIKE', "%{$searchTerm}%")
                            ->orWhere('role', 'LIKE', "%{$searchTerm}%")
                            ->orWhere('id', 'LIKE', "%{$searchTerm}%");
                    });
                }
            }

            $users = $query->paginate(10);

            return response()->json([
                'html' => view('users.partials.user_table', compact('users', 'searchTerm'))->render(),
                'pagination' => (string) $users->links(),
                'count' => $users->total(),
            ]);
        }

        return response()->json(['error' => __('messages.invalid_request')], 400);
    }

    public function create()
    {
        $this->authorize('create', User::class);
        return view('users.create');
    }

    public function store(StoreUserRequest $request)
    {
        $this->authorize('create', User::class);
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        return redirect()->route('admin.users.show', $user->id)
            ->with('success', __('messages.user_created_successfully'));
    }

    public function show($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $this->authorize('view', $user);
        $studentsCount = $user->students()->count();
        $coursesCount = $user->courses()->count();
        $bookingsCount = $user->bookings()->count();
        return view('users.view', compact('user', 'studentsCount', 'coursesCount', 'bookingsCount'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    public function update(EditUserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $this->authorize('update', $user);
        $data = $request->validated();

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('admin.users.show', $user->id)
            ->with('success', __('messages.user_updated_successfully'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $this->authorize('delete', $user);

        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', __('messages.cannot_delete_self'));
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', __('messages.user_deleted_successfully'));
    }

    public function recycle()
    {
        $this->authorize('viewAny', User::class);
        $users = User::onlyTrashed()->paginate(10);
        $usersCount = User::onlyTrashed()->count();
        return view('users.recycle', compact('users', 'usersCount'));
    }

    public function recycleSearch(Request $request)
    {
        if ($request->ajax()) {
            $this->authorize('viewAny', User::class);
            $searchTerm = $request->input('search');
            $searchBy = $request->input('search_by');

            $query = User::onlyTrashed();

            if ($searchTerm) {
                if ($searchBy === 'name') {
                    $query->where('name', 'LIKE', "%{$searchTerm}%");
                } elseif ($searchBy === 'id') {
                    $query->where('id', 'LIKE', "%{$searchTerm}%");
                } elseif ($searchBy === 'email') {
                    $query->where('email', 'LIKE', "%{$searchTerm}%");
                } elseif ($searchBy === 'role') {
                    $query->where('role', 'LIKE', "%{$searchTerm}%");
                } else {
                    $query->where(function ($q) use ($searchTerm) {
                        $q->where('name', 'LIKE', "%{$searchTerm}%")
                            ->orWhere('email', 'LIKE', "%{$searchTerm}%")
                            ->orWhere('role', 'LIKE', "%{$searchTerm}%")
                            ->orWhere('id', 'LIKE', "%{$searchTerm}%");
                    });
                }
            }

            $users = $query->paginate(10);

            return response()->json([
                'html' => view('users.partials.recycle_table', compact('users', 'searchTerm'))->render(),
                'pagination' => (string) $users->links(),
                'count' => $users->total(),
            ]);
        }

        return response()->json(['error' => __('messages.invalid_request')], 400);
    }

    public function restore($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $this->authorize('restore', $user);
        $user->restore();

        return redirect()->route('admin.users.show', $user->id)
            ->with('success', __('messages.user_restored_successfully'));
    }

    public function deletePermanently($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $this->authorize('forceDelete', $user);

        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.recycle')
                ->with('error', __('messages.cannot_delete_self'));
        }

        $user->forceDelete();

        return redirect()->route('admin.users.recycle')
            ->with('success', __('messages.user_permanently_deleted'));
    }
}
