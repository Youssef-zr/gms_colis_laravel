<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\users\crudUserRequest;
use App\Http\Requests\users\EditProfileRequest;
use App\Traits\UploadFiles;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    use UploadFiles;

    public function __construct()
    {
        $this->middleware('permission:liste_utilisateurs', ['only' => 'index']);
        $this->middleware('permission:nouveau_utilisateur', ['only' => ['create', "store"]]);
        $this->middleware('permission:editer_utilisateur', ['only' => ['edit', "update"]]);
        $this->middleware('permission:supprimer_utilisateur', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "utilisateurs";
        $users = [];
        
        if (auth()->user()->roles[0]->name != "developpeur") {
            $users = User::orderBy('id', 'DESC')
                ->where("email", '!=', 'omag@dev.com')
                ->get();
        } else {
            $users = User::orderBy('id', 'DESC')->get();
        }

        return view('backend.views.users.index', compact('users', "title"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name', "name")->toArray();

        if (auth()->user()->roles[0]->name != "developpeur") {
            $roles = Arr::except($roles, "developpeur");
        }

        return view('backend.views.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(crudUserRequest $request)
    {
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $input = Arr::except($input, ['confirm-password']);

        $input['roles_name'] = $request->roles_name;
        $input['IDClient'] = $request->IDClient and $request->roles_name[0] != "developpeur" ? $request->IDClient : null;

        $user = User::create($input);
        $user->assignRole($request->input('roles_name'));

        return redirect_with_flash("msgSuccess", "Utilisateur ajouté avec succès", "users");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function userInformation($id)
    {
        return response()->json(['phone' => User::find($id)->phone]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $roleDev = auth()->user()->roles[0];
        $user = User::find($id);

        if ($id == 1 and $roleDev->name != "developpeur") {
            return view('_partial.404');
        }

        $roles = Role::pluck('name', 'id')->all();
        $userRole = $user->roles[0]->id;

        $user->setAttribute('role', $userRole);

        if (auth()->user()->roles[0]->name != "developpeur") {
            $roles = Arr::except($roles, "developpeur");
        }

        return view('backend.views.users.update', compact('user', 'roles', 'userRole'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(crudUserRequest $request, $id)
    {
        $input = $request->all();
        $input = Arr::except($input, array('confirm-password', "role"));

        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }

        $user = User::find($id);
        $user->update($input);

        DB::table('model_has_roles')->where('model_id', $id)->delete();
        $user->assignRole($request->input('role'));

        return redirect_with_flash("msgSuccess", "Utilisateur mis à jour avec succès", "users");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = user::find($id);
        if ($id == 1 || $user == null) {

            return view('_partial.404');
        }

        $user->delete();

        return redirect_with_flash("msgSuccess", "Utilisateur supprimé avec succès", "users");
    }

    //get user notification from ajax request
    public function getUserNotification($user_id)
    {
        $user = User::find($user_id);
        if ($user) {
            $notifications = $user->notifications->where('read_at', '=', '');
            $count = $notifications->count();

            $output = "";
            if ($count > 0) {

                $output .= '<a class="nav-link" data-toggle="dropdown" href="#">
                                     <i class="far fa-comments"></i>
                                     <span class="badge badge-danger navbar-badge">' . $count . '</span>
                                 </a>';

                $output .= '<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">';
                foreach ($notifications as $notification) {
                    $output .= '<a href="' . $notification->data['linkTo'] . '" class="dropdown-item">';

                    $output .= '<div class="media"><img src="' . url('images/purchase-icon.png') . '" alt="User Avatar" class="img-size-50 mr-3 img-circle">';
                    $output .= '<div class="media-body">
                             <h3 class="dropdown-item-title text-primary">
                               <span class="badge badge-pill bg-primary">' . $notification->data['title'] . '</span>
                               <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                             </h3>
                             <p class="text-sm">' . $notification->data['msg'] . '</p>';
                    $output .= '<p class="text-sm text-muted"><i class="far fa-clock mr-1 text-primary"></i>' . $notification->created_at . ' </p>
                           </div>
                         </div>';
                    $output .= '</a><div class="dropdown-divider"></div>';
                }
                $output .= '<a href="' . adminUrl('readAllNotifications') . '" class="dropdown-item dropdown-footer bg-primary"><i class="fa fa-reply-all"></i> Select all as read</a>';
            } else {

                $output .= '<span class="dropdown-item dropdown-footer bg-primary"><i class="fa fa-exclamation-circle"></i> No Orders</span>';
            }
            $output .= '</div>';

            return response()->json(['data' => $output, "count" => $count, "status" => "ok"]);
        }

        return response()->json(['error' => 'user not found']);
    }

    // edit profile user show page
    public function editProfile()
    {
        $user = User::find(auth()->user()->id);
        $title = "profile - " . $user->name;

        return view('backend.views.users.profile.show-profile', compact('user', 'title'));
    }

    // update profile user
    public function updateProfile(EditProfileRequest $request, $user)
    {
        $user = User::find($user);
        $data = Arr::except($request->all(), ['photo']);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $storagePath = "assets/dist/storage/users";
            $fileInformation = UploadFiles::updateFile($file, $storagePath, $user->path, $user->file_name);

            $data['file_name'] = $fileInformation['file_name'];
            $data['path'] = $fileInformation['file_path'];
        }

        $title = "profile - " . $user->name;
        $user->fill($data)->save();
        $request->session()->flash('msgSuccess', "vos informations mises à jour avec succès");

        return redirect()->route("user.edit_profile")->with('user', "title");
    }

    // update user profle password
    public function updatePassword(Request $request, $user)
    {
        $user = User::findOrFail($user);

        $rules = ['password' => 'required|same:confirm-password'];
        $niceNames = ['password' => 'mot de passe', 'confirm-password' => 'confirmation'];
        $this->validate($request, $rules, [], $niceNames);

        if ($request->password != "") {
            $user->fill(["password" => bcrypt($request->password)])->save();
            Auth::logout();
        }

        return redirect_with_flash("msgSuccess", "Votre mot de passe a été modifié avec succès", "user/profile");
    }
}
