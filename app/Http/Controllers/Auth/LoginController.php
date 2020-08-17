<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\ThrottlesLogins;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    
	
	 use AuthenticatesUsers;
	 
	 protected $maxAttempts = 3; // Default is 5
    protected $decayMinutes = 2; // Default is 1

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
	protected $username;
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
		$this->username = $this->findUsername();
		$this->middleware('throttle:3,1')->only('login');
    }
	
	
	
	public function validate_password($password, $correct_hash){
	$params = explode(":", $correct_hash);
	if(count($params) < 4)
	   return false; 
	$pbkdf2 = base64_decode($params[3]);
   return $this->slow_equals(
		$pbkdf2,
		$this->pbkdf2($params[0], $password, $params[2], (int)$params[1], strlen($pbkdf2), true)
	);
	}
   public function pbkdf2($algorithm, $password, $salt, $count, $key_length, $raw_output = false){
	$algorithm = strtolower($algorithm);
	if(!in_array($algorithm, hash_algos(), true))
		trigger_error('PBKDF2 ERROR: Invalid hash algorithm.', E_USER_ERROR);
	if($count <= 0 || $key_length <= 0)
		trigger_error('PBKDF2 ERROR: Invalid parameters.', E_USER_ERROR);

	if (function_exists("hash_pbkdf2")){
		// The output length is in NIBBLES (4-bits) if $raw_output is false!
		if (!$raw_output) {
			$key_length = $key_length * 2;
		}
		return hash_pbkdf2($algorithm, $password, $salt, $count, $key_length, $raw_output);
	}

	$hash_length = strlen(hash($algorithm, "", true));
	$block_count = ceil($key_length / $hash_length);

	$output = "";
	for($i = 1; $i <= $block_count; $i++) {
		// $i encoded as 4 bytes, big endian.
		$last = $salt . pack("N", $i);
		// first iteration
		$last = $xorsum = hash_hmac($algorithm, $last, $password, true);
		// perform the other $count - 1 iterations
		for ($j = 1; $j < $count; $j++) {
			$xorsum ^= ($last = hash_hmac($algorithm, $last, $password, true));
		}
		$output .= $xorsum;
	}

	if($raw_output){
		return substr($output, 0, $key_length);
	}else{
		return bin2hex(substr($output, 0, $key_length));
	}
	}
    public function slow_equals($a, $b){
	$diff = strlen($a) ^ strlen($b);
	for($i = 0; $i < strlen($a) && $i < strlen($b); $i++){
		$diff |= ord($a[$i]) ^ ord($b[$i]);
	}
	return $diff === 0; 
}
	
	 public function findUsername()
    {
        $login = request()->input('email');
 
        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
 
        request()->merge([$fieldType => $login]);
 
        return $fieldType;
    }
	
	
	
	
	public function login(Request $request)
{
  $pass='';
  $valid='';
  $pass= bcrypt($request->password);
  $user =[];
  
  if ($this->hasTooManyLoginAttempts($request)) {
	  echo 'test'; exit;
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }
  
 #echo $request->password; 
  $credentials = [ $this->username => $request->email , 'password' => $request->password ];
   /*#print_r($credentials); exit; 
  
  $user = User::where('username', $request->username)
                  ->where('password',$this->create_hash($request->password))
                  ->first();
				  
  if(Auth::login($user)) return redirect('/home');*/
  
  if(Auth::attempt($credentials)){ // login attempt
   if(Auth::user()->bcrypt=='0'){
    $valid=$this->validate_password($request->password, Auth::user()->password);
	
		if($valid=='1'){
			#echo Auth::user()->id;
			#echo $pass; exit;
			$vv=User::where('id',Auth::user()->id)->update(['password'=>$pass,'bcrypt'=>1]);
			//dd($vv);
		}
		else{	
			return redirect('/login')->withErrors('Error logging in!');	
			}
			 return redirect('/home');
   }
    
    return redirect('/home');
  }
  else{
	  return redirect('/login')->withErrors('Error logging in!');
  }
  
  
  }
  
  protected function hasTooManyLoginAttempts(Request $request)
{
   $maxLoginAttempts = 3;

   $lockoutTime = 1; // In minutes

   return $this->limiter()->tooManyAttempts(
       $this->throttleKey($request), $maxLoginAttempts, $lockoutTime
   );
}

protected function sendLockoutResponse(Request $request)
{
    $seconds = $this->limiter()->availableIn(
        $this->throttleKey($request)
    );

    throw ValidationException::withMessages([
        'throttle' => [Lang::get('auth.throttle', ['seconds' => $seconds])],
    ])->status(Response::HTTP_TOO_MANY_REQUESTS);
}

 
    /**
     * Get username property.
     *
     * @return string
     */
    public function username()
    {
        return $this->username;
    }
}
