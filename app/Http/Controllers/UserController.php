<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Chair;
use App\Mail\LoginUser;
use App\Mail\CreateUser;
use App\Jobs\UserLoginJob;
use App\Jobs\UserCreateJob;
use App\Jobs\UserUpdateJob;
use App\Jobs\UserVerifyJob;
use Illuminate\Http\Request;
use App\Jobs\UserUpdateAdminJob;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\updateUserRequest;
use App\Http\Requests\UserCreateRequest;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\updateUserAdminRequest;
use App\Http\Requests\updateUserPasswordRequest;
use App\Http\Requests\updateUserVerificationRequest;

class UserController extends Controller
{
    protected $chairs;
    protected $users;

    public function __construct(){
        $this->chairs = new Chair();
        $this->users = new User();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        return view('pages.users.login');
    }

    /**
     * check if user can login.
     *
     * @param  \Illuminate\Http\UserLoginRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(UserLoginRequest $request) {
        $user_data = $request->validated();

        $user = User::where('username', $user_data['username'])->first();
        
        if ($user) {
            $user_data["email_to"] = $user->email;
            if(password_verify($user_data["password"], $user->password)) {
                
                UserLoginJob::dispatch($user["email"], $user_data);
                
                if(auth()->login($user)) {
                    $request->session()->regenerate();
                    return redirect("/")->with('message', 'You are now logged in');
                }
                else {
                    return redirect()->back()->with('message', 'Email or password incorrect');
                }
            }
            else {
                return redirect()->back()->with('message', 'Password incorrect');
            }
        }
        else {
            return redirect()->back()->with('message', "User doesn't exist");
        }
        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function register() {
        return view('pages.users.register');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\UserCreateRequest   $request
     * @return \Illuminate\Http\Response
     */    
    public function createUser(UserCreateRequest $request) {
        $user_data = $request->validated();
        $user_data["password"] = password_hash($user_data["password"], PASSWORD_DEFAULT);

        if($user_data){
            UserCreateJob::dispatch($user_data["email"], $user_data);

            if(auth()->login(User::create($user_data))) {
                $request->session()->regenerate();
                return redirect('/')->with('message', 'You are now logged in');
            }
            else {
                return redirect()->back()->with('message', "User couldn't be created");
            }
        }
        else {
            return redirect()->back()->with('message', "User couldn't be created");
        }
    }

    public function settings() {
        return view('pages.users.settings', [ 
            'user' => $this->users->getCurrentUser() 
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\updateUserRequest   $request
     * @return \Illuminate\Http\Response
     */    
    public function updateUser(updateUserRequest $request) {
        $user_data = $request->validated();
        UserUpdateJob::dispatch($user_data["email"], $user_data);
        $this->users->updateUser($user_data["id"], $user_data["username"], $user_data["email"]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\updateUserPasswordRequest   $request
     * @return \Illuminate\Http\Response
     */    
    public function updateUserPassword(updateUserPasswordRequest $request) {
        $user_data = $request->validated();
        UserUpdateJob::dispatch($user_data["email"], $user_data);
        $this->users->updateUserPassword($user_data["id"], password_hash($user_data["password"], PASSWORD_DEFAULT));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\updateUserAdminRequest   $request
     * @return \Illuminate\Http\Response
     */    
    public function updateUserAdmin(updateUserAdminRequest $request) {
        $user_data = $request->validated();
        UserUpdateAdminJob::dispatch($user_data["email"], $user_data);
        $this->users->updateUserAdmin($user_data["id"], $user_data["admin"]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\updateUserVerificationRequest   $request
     * @return \Illuminate\Http\Response
     */    
    public function updateUserVerification(updateUserVerificationRequest $request) {
        $user_data = $request->validated();
        UserVerifyJob::dispatch($user_data["email"], $user_data);
        $this->users->updateUserVerification($user_data["id"], $user_data["verify"]);
    }

    public function logout(Request $request) {
        auth()->logout();
        $request->session()->regenerate();
        return redirect('/login');
    }
}
