<?php

namespace App\Http\Controllers;

use App\Models\User;
use Intervention\Image\Facades\Image;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Users\{StoreUserRequest, UpdateUserRequest};
use App\Models\Jenjang;

class UserController extends Controller
{
    /**
     * Path for user avatar file.
     *
     * @var string
     */
    protected $avatarPath = '/uploads/images/avatars/';

    public function __construct()
    {
        $this->middleware('permission:user view')->only('index', 'show');
        $this->middleware('permission:user create')->only('create', 'store');
        $this->middleware('permission:user edit')->only('edit', 'update');
        $this->middleware('permission:user delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
    {
        if (request()->ajax()) {
            $users = User::with('roles:id,name', 'jenjang:id,nama_jenjang');

            return Datatables::of($users)
                ->addColumn('action', 'users.include.action')
                ->addColumn('role', function ($row) {
                    return $row->getRoleNames()->toArray() !== [] ? $row->getRoleNames()[0] : '-';
                })
                ->addColumn('nama_jenjang', function ($row) {
                    return $row->jenjang ? $row->jenjang->nama_jenjang : 'Tidak ada jenjang';
                })
                ->addColumn('avatar', function ($row) {
                    if ($row->avatar == null) {
                        return 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($row->email))) . '&s=500';
                    }
                    return asset($this->avatarPath . $row->avatar);
                })
                ->addIndexColumn()
                ->toJson();
        }

        return view('users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Illuminate\Contracts\View\View
    {
        $jenjangs = Jenjang::all();

        // dd($)
        return view('users.create', compact('jenjangs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): \Illuminate\Http\RedirectResponse
    {
        $attr = $request->validated();

        if ($request->file('avatar') && $request->file('avatar')->isValid()) {
            $path = storage_path('app/public/uploads/avatars');
            $originalFilename = $request->file('avatar')->getClientOriginalName();

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $mimeType = $request->file('avatar')->getMimeType();

            if (strpos($mimeType, 'image') !== false) {
                // Handle image file
                Image::make($request->file('avatar')->getRealPath())->resize(500, 500, function ($constraint) {
                    $constraint->upsize();
                    $constraint->aspectRatio();
                })->save($path . '/' . $originalFilename);
            } else {
                // Handle non-image file
                $request->file('avatar')->move($path, $originalFilename);
            }

            $attr['avatar'] = $originalFilename;
        }

        $attr['password'] = bcrypt($request->password);

        $user = User::create($attr);

        $user->assignRole($request->role);

        return to_route('users.index')->with('success', __('The user was created successfully.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): \Illuminate\Contracts\View\View
    {
        $user->load('roles:id,name', 'jenjang:id,nama_jenjang');

        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): \Illuminate\Contracts\View\View
    {
        $user->load('roles:id,name', 'jenjang:id,nama_jenjang');

        $jenjangs = Jenjang::all();

        return view('users.edit', compact('user', 'jenjangs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user): \Illuminate\Http\RedirectResponse
    {
        $attr = $request->validated();

        if ($request->file('avatar') && $request->file('avatar')->isValid()) {

            $filename = $request->file('avatar')->hashName();

            if (!file_exists($folder = public_path($this->avatarPath))) {
                mkdir($folder, 0777, true);
            }

            Image::make($request->file('avatar')->getRealPath())->resize(500, 500, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save(public_path($this->avatarPath) . $filename);

            if ($user->avatar != null && file_exists($oldAvatar = public_path($this->avatarPath .
                $user->avatar))) {
                unlink($oldAvatar);
            }

            $attr['avatar'] = $filename;
        } else {
            $attr['avatar'] = $user->avatar;
        }

        switch (is_null($request->password)) {
            case true:
                unset($attr['password']);
                break;
            default:
                $attr['password'] = bcrypt($request->password);
                break;
        }

        $user->update($attr);

        $user->syncRoles($request->role);

        return to_route('users.index')->with('success', __('The user was updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): \Illuminate\Http\RedirectResponse
    {
        if ($user->avatar != null && file_exists($oldAvatar = public_path($this->avatarPath . $user->avatar))) {
            unlink($oldAvatar);
        }

        $user->delete();

        return to_route('users.index')->with('success', __('The user was deleted successfully.'));
    }
}
