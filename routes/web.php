<?php

use App\Models\Colis;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

// Auth routes list
Auth::routes(
    [
        'register' => false, // Registration Routes...
        'reset' => false, // Password Reset Routes...
        'verify' => false, // Email Verification Routes...
    ]
);

Route::post('/login', ['uses' => 'Auth\LoginController@login', 'middleware' => 'CheckUserStatus']);

// site Routes frontEnd
// Route::group(["middleware" => ['web'], 'namespace' => 'frontEnd'], function () {
//     Route::get('/', 'FrontController@home');
//     Route::get('/contact', 'FrontController@contact');
//     Route::post('/contact', 'FrontController@sendMail')->name('frontend.sendMail');
// });

// Dashboard Routes BackEnd
Route::group(['prefix' => "admin", "middleware" => ['auth'], 'namespace' => 'backend'], function () {

    // dashboard routes
    Route::get('/', 'DashboardController@welcome');
    route::get('/logout', "DashboardController@logout");

    // villes rotes
    Route::resource('/villes', "VilleController");

    // statuts rotes
    Route::resource('/statuts', "StatutController");

    // expediteurs rotes
    Route::resource('/expediteurs', "ExpediteurController");

    // remarques rotes
    Route::resource('/remarques', "RemarqueController");

    // colis rotes
    Route::resource('/colis', "ColisController");
    Route::get("/search/colis", "ColisController@search")->name('colis.search');
    Route::patch('/colisUpdateDelivery', "ColisController@updateColisDelivery")->name('staff.updateDelivery');

    // paiemenst routes
    Route::resource('/paiements', "PaiementController");
    Route::get('/paiement/rechercher', "PaiementController@search")->name('paiements.search');

    // get bundels not payed for selected (expediteur and livreur)
    Route::get('/colis-statut/paiement', "PaiementController@getColisNotPaid")->name('payments.colis_not_paid');

    // users resource
    Route::resource('/users', "UserController");
    Route::get('user/profile', "UserController@editProfile")->name('user.edit_profile');
    Route::patch('user/updateProfile/{user}', "UserController@updateProfile")->name('user.update_profile');
    Route::patch('user/changePassword/{user}', "UserController@updatePassword")->name('user.change_password');

    // roles resource
    Route::resource('/roles', "RoleController");
    Route::get('/permission/create', "RoleController@newPermission");
    Route::post('/permission/store', 'RoleController@createPermission')->name('permission.store');

});

// -----------------------------
// just to testing some features
// -----------------------------

// Route::get('/test/{id}', function () {
//     // $file = Facture::findOrFail(3);

//     // return response()->make(file_get_contents(public_path($file->chemin)), 200, [
//     //     'Content-Type' => 'application/pdf',
//     //     'Content-Disposition' => 'inline; filename="' . $file->nom_fichier . '"',
//     // ]);
//     $calendar = Planning::where('IDClient', request()->id)->first();
//     $title = "calendar";
//     return view('backend.views.plannings.index', compact("calendar", "title"));

// });

// Route::get('/test', function () {

//     Schema::create('users', function (Blueprint $table) {
//         $table->id();
//         $table->string('name');
//         $table->string('email');
//         $table->timestamp('email_verified_at')->nullable();
//         $table->string('password');
//         $table->string('adress')->nullable();
//         $table->string('phone')->nullable();
//         $table->text('notes')->nullable()->default('---');
//         $table->string('status')->nullable()->default('activé');
//         $table->string('file_name', 50)->nullable()->default('default.png');
//         $table->string('path', 100)->nullable()->default('assets/dist/storage/users/default.png');
//         $table->dateTime('last_login_at')->nullable();
//         $table->string('last_login_ip_address')->nullable();

//         $table->integer('roles_name');

//         $table->integer('id_Expediteur');
//         // $table->unsignedBigInteger('id_expediteur')->nullable();
//         // $table->foreign('id_expediteur')->references('id')->on('expediteurs')->onDelete('set null');

//         $table->rememberToken();
//         $table->timestamps();
//     });

//     Schema::create('password_resets', function (Blueprint $table) {
//         $table->string('email')->index();
//         $table->string('token');
//         $table->timestamp('created_at')->nullable();
//     });

//     Schema::create('failed_jobs', function (Blueprint $table) {
//         $table->id();
//         $table->text('connection');
//         $table->text('queue');
//         $table->longText('payload');
//         $table->longText('exception');
//         $table->timestamp('failed_at')->useCurrent();
//     });
// });

Route::get('/password', function () {
    $users = User::all();

    $arr = [];
    foreach ($users as $user) {
        $password = bcrypt($user->password_);
        array_push($arr, [$user->password_ => $password]);

        $user->fill(['password' => $password])->save();
    }

    dd($arr);
});

Route::get('/test/{id}', function () {
    $colis = Colis::with(['expediteur', 'livreur', 'ville', 'statut', "remarque"])->find(1);

    $signature = "";
    $signature_path = "assets/dist/storage/colis/signature/" . $colis->id_colis . ".png";
    if (File::isFile(public_path($signature_path))) {
        $signature = $signature_path;
    }
    dd($signature, $signature_path);
});
