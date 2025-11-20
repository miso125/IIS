<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class UserController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [        
            'auth',  // Autentifikácia pre všetky metódy
            new Middleware('permission:view users', only: ['index', 'show']),
            new Middleware('permission:create user', only: ['create', 'store']),
            new Middleware('permission:edit user', only: ['edit', 'update']),
            new Middleware('permission:delete user', only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $this->authorize('viewAny', User::class);
        $users = User::paginate(15);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', User::class);
        
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $this->authorize('create', User::class);
        
        $validated = $request->validated();
        $validated['password_hash'] = bcrypt($validated['password_hash']);
        
        $user = User::create($validated);
        
        // Pridelenie role podľa vytvoreného poľa 'role'
        $user->assignRole($validated['role']);
        
        return redirect()->route('users.show', $user)
            ->with('success', 'User created succesfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $this->authorize('view', $user);
        
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);
        
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize('update', $user);
        
        $validated = $request->validated();
        
        if (!empty($validated['password_hash'])) {
            $validated['password_hash'] = bcrypt($validated['password_hash']);
        } else {
            unset($validated['password_hash']);
        }
        
        $user->update($validated);
        
        // Synchronizácia role
        if (isset($validated['role'])) {
            $user->syncRoles($validated['role']);
        }
        
        return redirect()->route('users.show', $user)
            ->with('success', 'User updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        
        $user->delete();
        
        return redirect()->route('user.index')
            ->with('success', 'User deleted.');
    }
}
