<?php
namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Session\Session;
use Illuminate\Http\Request;
use App\Models\Client;
use Auth;

Class AuthController extends Controller
{
	public function getSignup(Session $session)
	{

		 return view('auth.signup',['session'=>$session]);
	}
	

	public function getSignin(Session $session)
	{
		return	view ('auth.signin',['session'=>$session]);
	}

	
	public function postSignin(Request $request, Session $session)
	{
		$this->validate($request, [
			'email' => 'required',
			'password' => 'required',
		]);


		if (!Auth::attempt([
				'email'=>$request->input('email'),
				'password'=>$request->input('password'),
				'confirmed'=>1
			])) 
			{
				$session->set('info' , 'Could not sign in Invalid Details'); 
				return redirect()->route('auth.signin');
			}

		//Setting Sessions
		$session->set('email',$request->input('email'));
		//$session->set('id',$request->input('id'));

		$session->set('info' , 'You are Signed in');
		return redirect()->route('newdashBoard');
	}


	public function postSignup(Request $request,Session $session)
	{
		$this->validate($request, [
			'email' => 'required|unique:clients|email',
			'username' => 'required|max:30',
			'password' => 'required|min:6',
		]);
		
		$confirmation_code = str_random(30);
		$api_key = md5($request->input('email').(new \DateTime())->getTimestamp());

		$user = $request->input('email');
		Client::create([
			'email'=> $request->input('email'),
			'username'=>$request->input('username'),
			'password'=>bcrypt($request->input('password')),
			'api_key'=>$api_key,
			'confirmation_code'=>$confirmation_code,
		]);


		\Mail::raw("For confirmation of your account kindly run the given url in your web browser:

			http://111.68.98.142:149/wifiShield/confirmation/".$confirmation_code."

			Best Regards
			Happy Coding!!", function ($message) use ($user){
            $message->to($user, 'Beloved User')
        		    ->subject('APPLICATION!');
        });

		$session->set('info' , 'Your Account has been created, check you inbox for confirmation First and then signin !!');
		return view('auth.signin',['session'=>$session]);
	}

	public function confirm($confirmation_code, Session $session)
	{
		if (! $confirmation_code) {
			throw new InvalidConfirmationCodeException;
		}

		$user = Client::whereConfirmationCode($confirmation_code)->first();
		if ( ! $user)
        {
            //throw new InvalidConfirmationCodeException;
            $session->set('info' , 'Link Expired!!');
			return view('home',['session'=>$session]);
        }

        $user->confirmed = 1;
        $user->confirmation_code = null;
        $user->save();

        $session->set('info' , 'Now you may log in');
		return view('auth.signin',['session'=>$session]);
	}


	public function postSignout(Session $session)
	{
		$session->clear();
		Auth::logout();
		return redirect()->route('home');
	}

	public function getForgot( Session $session)
	{
		//var_dump('Forgot my password');
		return view('auth.forgot',['session'=>$session]);
	}

	public function postForgot(Request $request, Session $session)
	{
		$this->validate($request, [
			'email' => 'required|email',
		]);

		$email = Client::where('email',$request->input('email'))->first();
		if(!$email)
		{
			$session->set('info' , 'Invalid email !!');
			return view('auth.forgot',['session'=>$session]);
		}
		
		$confirmation_code = str_random(30);
		$user = $request->input('email'); //for email

		Client::where('email',$request->input('email'))
				->update(['confirmation_code'=>$confirmation_code,'confirmed'=>0]);

		\Mail::raw("For reset Password of your account kindly run the given url in your web browser:

			http://111.68.98.142:149/wifiShield/reset/".$confirmation_code."

			Best Regards
			Happy Coding!!", function ($message) use ($user){
            $message->to($user, 'Beloved User')
        		    ->subject('APPLICATION!');
        });

        $session->set('info' , 'An email to reset your password is send to you!!');
		return view('home',['session'=>$session]);
		
	}

	public function resetPassword($confirmation_code, Session $session)
	{

		if (! $confirmation_code) {
			//throw new InvalidConfirmationCodeException;
			$session->set('info' , 'Link Expired!!');
			return view('home',['session'=>$session]);
		}
		//dd($confirmation_code);
		$user = Client::whereConfirmationCode($confirmation_code)->first();
		
		if ( ! $user)
        {
            //throw new InvalidConfirmationCodeException;
            $session->set('info' , 'Link Expired!!');
			return view('home',['session'=>$session]);
        }
        /*$user->confirmed = 1;
        $user->confirmation_code = null;
        $user->save();*/
        $session->set('confirmation_code' , $confirmation_code);
        $session->set('info' , 'Reset password');
		return view('auth.passwordreset',['session'=>$session]);
	}
	
	public function postResetPassword(Request $request,Session $session)
	{
		$this->validate($request, [
			'password1' => 'required|min:6',
			'password2' => 'required|min:6',
		]);
		if ($request->input('password1') !== $request->input('password2')) {
			$session->set('info' , 'Passwords doesnot match.');
			return view('auth.passwordreset',['session'=>$session]);
		}

		$confirmation_code = $session->get('confirmation_code');
		$user = Client::whereConfirmationCode($confirmation_code)->first();
		if ( ! $user)
        {
            //throw new InvalidConfirmationCodeException;
            $session->set('info' , 'Link Expired!!');
			return view('home',['session'=>$session]);
        }
        $user->password = bcrypt($request->input('password1'));
        $user->confirmed = 1;
        $user->confirmation_code = null;
        $user->save();
        $session->set('info' , 'Now you may log in');
		return view('auth.signin',['session'=>$session]);
	}
}