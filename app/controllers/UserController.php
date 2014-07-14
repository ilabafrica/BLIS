<?php

use Illuminate\Support\MessageBag;

/**
 *Contains functions for managing users 
 *
 */
class UserController extends Controller {
    
    public function loginAction(){

        $errors = new MessageBag();
        if ($old = Input::old("errors")) {
            $errors = $old;
        }

        $data = array( "errors" => $errors );

        Log::info(Input::server("REQUEST_METHOD"));
        if (Input::server("REQUEST_METHOD") == "POST") 
        {
            $validator = Validator::make(Input::all(), array(
                "username" => "required",
                "password" => "required"
            ));

            if ($validator->passes())
            {
                $credentials = array(
                    "username" => Input::get("username"),
                    "password" => Input::get("password")
                    );

                if(Auth::attempt($credentials)){
                    return Redirect::route("user.home");
                }
            }
            
            $data["errors"] = new MessageBag(array(
                "password" => array(
                    "Username and/or password invalid."
                    ) 
                ));

            $data["username"] = Input::get("username");
            Log::info($data["errors"]);
            return Redirect::route("user.login")->withInput($data);
        }

        return View::make("user.login", $data);
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
            'username' => 'required',
            'name'       => 'required',
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
                Session::flash('message', 'Successfully created the user!');
                return Redirect::to('user');
            }catch(QueryException $e){
                $errors = new MessageBag(array(
                    "Please select another username."
                ));
                return Redirect::to('user/create')
                    ->withErrors($errors)
                    ->withInput(Input::except('password'));
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

            $user->save();

            // redirect
            Session::flash('message', 'The user details were successfully updated!');
            return Redirect::to('user');
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
        Session::flash('message', 'The user was successfully deleted!');
        return Redirect::to('user');
    }
}
