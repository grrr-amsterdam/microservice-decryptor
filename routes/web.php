<?php
use Illuminate\Http\Request;
use App\Actions\{VerifyPassword, DecryptContent};

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->post('/decrypt', function (Request $request) {
    $this->validate(
        $request,
        ['password_hashed' => 'required', 'password' => 'required', 'content' => 'required']
    );

    $verifyPassword = new VerifyPassword();
    if (!$verifyPassword->execute(
        $request->input('password'),
        $request->input('password_hashed'),
        getenv('PASSWORD_PROTECTION_PASSWORD_SALT')
    )) {
        return response()->json(['error' => 'Not authorized.'], 403);
    }
    $decryptContent = new DecryptContent();
    return response()->json([
        'result' => $decryptContent->execute(
            getenv('PASSWORD_PROTECTION_CONTENT_KEY'),
            $request->input('content')
        )
    ]);
});
