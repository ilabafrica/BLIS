<?php

use Illuminate\Support\MessageBag;

/**
 *Contains functions for managing users 
 *
 */
class UserController extends Controller {
    
    //Function for user authentication logic
    public function loginAction(){

        if (Input::server("REQUEST_METHOD") == "POST") 
        {
            $validator = Validator::make(Input::all(), array(
                "username" => "required|min:6",
                "password" => "required|min:6"
            ));

            if ($validator->passes())
            {
                $credentials = array(
                    "username" => Input::get("username"),
                    "password" => Input::get("password")
                    );

                if(Auth::attempt($credentials)){
                    //To do: redirect to the URL they came from
                    return Redirect::route("user.home");
                }

            }
            return Redirect::route('user.login')->withInput(Input::except('password'))
                ->withErrors($validator)
                ->with('message', 'Username and/or password invalid.');
        }

        return View::make("user.login");
    }

    public function requestAction(){
        $data = array("requested" => Input::old("requested"));

        if(Input::get("back", false) ){
            return Redirect::route("user.login");
        }
        else if(Input::get("reset", false) && Input::server("REQUEST_METHOD") == "POST")
        {
            $validator = Validator::make(Input::all(), array("email" => "required"));
            if($validator->passes()){
                $credentials = array("email" => Input::get("email"));
                Password::remind($credentials,
                    function($message, $user){
                        $message->from("jsiku@example.com");
                    }
                );
                $data["requested"] = true;

                return Redirect::route("user.request")->withInput($data);
            }
        }

        return View::make("user.request", $data);
    }

    public function resetAction(){
        $token = "?token=" . Input::get("token");
        $errors = new MessageBag();

        if($old = Input::old("errors")){
            $errors = $old;
        }

        $data = array(
            "token" => $token,
            "errors" => $errors
        );

        if(Input::server("REQUEST_METHOD") == "POST"){
            $validator = Validator::make(Input::all(), array(
                "email"                 => "required|email",
                "password"              => "required|min:6",
                "password_confirmation" => "same:password",
                "token"                 => "exists:token,token"
            ));

            if($validator->passes()){
                $credentials = array("email" => Input::get("email"));
                Password::reset($credentials, function($user, $password){
                    $user->password = Hash::make($password);
                    $user->save();

                    Auth::login($user);

                    return Redirect::route("user.index");
                });
            }

            $data["email"] = Input::get("email");
            $data["errors"] = $validator->errors();

            return Redirect::to(URL::route("user.reset") . $token)->withInput($data);
        }

        return View::make("user.reset", $data);
    }

    public function logoutAction(){
        Auth::logout();
        return Redirect::route("user.login");
    }

    public function homeAction(){
        return View::make("user.home");
    }


    /**
     * Display a listing of the users.
     *
     * @return Response
     */
    public function index()
    {
        // List all the active users
            $users = User::paginate(Config::get('kblis.page-items'));

        // Load the view and pass the users
        return View::make('user.index')->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //Create User
        return View::make('user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
        $rules = array(
            'username' => 'required|unique:users,username',
            'name' => 'required',
            'email' => 'required|email'
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('user/create')
                ->withErrors($validator)
                ->withInput(Input::except('password'));
        } else {
            // store
            $user = new User;
            $user->username = Input::get('username');
            $user->name = Input::get('name');
            $user->gender = Input::get('gender');
            $user->designation = Input::get('designation');
            $user->email = Input::get('email');
            $user->password = Input::get('password');

            $user->save();
            $id = $user->id;
            /* Set default password*/

            if (Input::hasFile('image')) {
                try {
                    $extension = Input::file('image')->getClientOriginalExtension();
                    $destination = public_path().'/i/users/';
                    $filename = "user-$id.$extension";

                    $file = Input::file('image')->move($destination, $filename);
                    $user->image = "/i/users/$filename";

                } catch (Exception $e) {
                }
            }

            try{
                $user->save();
                return Redirect::to('user')->with('message', 'Successfully created the user!');
            }catch(QueryException $e){
                Log::error($e);
                return Redirect::to('user/create')
                    ->withErrors($errors)
                    ->withInput(Input::except('password'))
                    ->with('message', "Please select another username.");
            }
            
            // redirect
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //Show a user
        $user = User::find($id);

        //Show the view and pass the $user to it
        return View::make('user.show')->with('user', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //Get the user
        $user = User::find($id);

        //Open the Edit View and pass to it the $user
        return View::make('user.edit')->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
        $rules = array(
            'username' => 'required',
            'name'       => 'required',
            'email' => 'required|email',
            'image' => 'image|max:500'
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('user/' . $id . '/edit')
                ->withErrors($validator)
                ->withInput(Input::except('password'));
        } else {
            // Update
            $user = User::find($id);
            $user->username = Input::get('username');
            $user->name = Input::get('name');
            $user->gender = Input::get('gender');
            $user->designation = Input::get('designation');
            $user->email = Input::get('email');

            if (Input::hasFile('image')) {
                try {
                    $extension = Input::file('image')->getClientOriginalExtension();
                    $destination = public_path().'/i/users/';
                    $filename = "user-$id.$extension";

                    $file = Input::file('image')->move($destination, $filename);
                    $user->image = "/i/users/$filename";

                } catch (Exception $e) {
                    Log::info($e);
                }
            }
            // change password if parameters were entered (changing ones own password)
            if(Input::get('passwordedit')) {
                if (Hash::check(Input::get('current-password'), $user->password))
                {
                    $user->password = Hash::make(Input::get('new-password'));
                }else{
                    return Redirect::to('user/' . $id . '/edit')
                            ->withErrors(trans('messages.incorrect-current-passord'));
                }
            }
            
            //Resetting passwords - by the administrator
            if (Input::get('reset-password')) {
                $user->password = Hash::make(Input::get('reset-password'));
            }

            $user->save();

            // redirect
            return Redirect::to('user')->with('message', trans('messages.user-profile-edit-success'));

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage (soft delete).
     *
     * @param  int  $id
     * @return Response
     */
    public function delete($id)
    {
        //Soft delete the user
        $user = User::find($id);

        $user->delete();

        // redirect
        return Redirect::to('user')->with('message', 'The user was successfully deleted!');
    }
}
