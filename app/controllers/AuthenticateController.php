<?php
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthenticateController extends \BaseController{

  public function authenticate() {

    // Get credentials from the request
    $credentials = Input::only('email', 'password');

    try {
      // Attempt to verify the credentials and create a token for the user.
      if (! $token = JWTAuth::attempt($credentials)) {
        return API::response()->array(['error' => 'invalid_credentials'])->statusCode(401);
      }
    } catch (JWTException $e) {
      // Something went wrong - let the app know.
      return API::response()->array(['error' => 'could_not_create_token'])->statusCode(500);
    }
    // Return success.
    return API::response()->array(['access_token' => $token])->statusCode(200);
  }

  public function validateToken(){
    return API::response()->array(['status' => 'success'])->statusCode(200);
  }

}
?>