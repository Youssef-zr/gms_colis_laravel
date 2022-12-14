<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\users\crudUserRequest;
use App\Http\Requests\users\EditProfileRequest;
use App\Models\Expediteur;
use App\Traits\UploadFiles;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use UploadFiles;

    public function __construct()
    {
        // $this->middleware('permission:liste_utilisateurs', ['only' => 'index']);
        // $this->middleware('permission:nouveau_utilisateur', ['only' => ['create', "store"]]);
        // $this->middleware('permission:editer_utilisateur', ['only' => ['edit', "update"]]);
        // $this->middleware('permission:supprimer_utilisateur', ['only' => ['destroy']]);
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

        // if (auth()->user()->roles[0]->name != "developpeur") {
        if (auth()->user()->id != 1) {
            $users = User::where("email", '!=', 'omag@dev.com')->get();
        } else {
            $users = User::get();
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
        $roles = user_profile();
        $expediteurs = Expediteur::pluck('nom', 'id_Expediteur');

        return view('backend.views.users.create', compact('roles', "expediteurs"));
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

        $input['password_'] = $input['password'];
        $input['password'] = Hash::make($input['password']);
        $input = Arr::except($input, ['confirm-password']);

        $input['roles_name'] = $request->roles_name;
        $input['id_Expediteur'] = (isset($request->id_Expediteur) and $request->roles_name == 4) ? $request->id_Expediteur : null;

        User::create($input);

        return redirect_with_flash("msgSuccess", "Utilisateur ajout?? avec succ??s", "users");
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
        $user = User::find($id);
        if ($user->id == 1) {
            return view('_partial.404');
        }

        $expediteurs = Expediteur::pluck('nom', 'id_Expediteur');

        $roles = user_profile();
        $userRole = $user->roles_name;
        $user->setAttribute('role', $userRole);

        return view('backend.views.users.update', compact('user', 'roles', 'userRole', "expediteurs"));
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
            $input['password_'] = $request->password;
        } else {
            $input = Arr::except($input, array('password'));
        }

        $input['id_Expediteur'] = (isset($request->id_Expediteur) and $request->roles_name == 4) ? $request->id_Expediteur : null;

        $user = User::find($id);
        $user->update($input);

        return redirect_with_flash("msgSuccess", "Utilisateur mis ?? jour avec succ??s", "users");
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

        return redirect_with_flash("msgSuccess", "Utilisateur supprim?? avec succ??s", "users");
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
        $request->session()->flash('msgSuccess', "vos informations mises ?? jour avec succ??s");

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

        return redirect_with_flash("msgSuccess", "Votre mot de passe a ??t?? modifi?? avec succ??s", "user/profile");
    }
}
