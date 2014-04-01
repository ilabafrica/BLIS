<?php

use Illuminate\Support\MessageBag;

class UserController extends Controller {
    
    public function loginAction(){

        $errors = new MessageBag();
        if ($old = Input::old("errors")) {
            $errors = $old;
        }

        $data = array( "errors" => $errors );

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
                    return Redirect::route("user/profile");
                }
            }
            
            $data["errors"] = new MessageBag(array(
                "password" => array(
                    "Username and/or password invalid."
                    ) 
                ));

            $data["username"] = Input::get("username");

            return Redirect::route("user/login")->withInput($data);
        }

        return View::make("user/login", $data);
    }
}
