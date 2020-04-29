<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Config;
use Laravel\Socialite\Facades\Socialite;

use App\{User, Profile, Social};
use Str;
use Auth;

class SocialController extends Controller
{
    public function redirect($provider)
    {   
        // Получение поставщика OAuth из конфигурации services, 
        $providerKey = Config::get('services.'.$provider);

        // dd($providerKey);
        // Если нет конфигурации 
        if (empty($providerKey)) {
            return redirect('/login')
                ->withError('No such provider yet');
        }
        
        // Перенаправление пользователя к поставщику OAuth, 
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        // Функция обратного вызова от поставщика после аутентификации.
        try {
            // $socialUserObject = Socialite::driver($provider)->user();
            // Laravel\Socialite\Two\InvalidStateException No message
    
            // Аутентификация без сохранения состояния 
            // может использоваться для отключения проверки состояния сеанса.
            $socialUserObject = Socialite::driver($provider)->stateless()->user();
            // dd($socialUserObject);

            // All Providers
            // dd($socialUserObject->getId());
            // dd($socialUserObject->getNickname());
            // dd($socialUserObject->getName());
            // dd($socialUserObject->getEmail());
            // dd($socialUserObject->getAvatar());

            $email = $socialUserObject->getEmail();
            $nickname = $socialUserObject->getNickname();
            $name = $socialUserObject->getName();
            $avatar = $socialUserObject->getAvatar();
            
            // dd($email, $nickname, $name, $avatar);
            
            
            // Социальный пользователь
            $socialUser = null;

            // Check if email is already registered
            $userCheck = User::where(['email' => $socialUserObject->getEmail()])->first();
            
            if($userCheck) {
                Auth::login($userCheck);
                // Пользователь уже зарегистрирован
                return redirect('/home');
            }
            // Если нет пользователя
            if (empty($userCheck)) {
                $socialId = Social::where('social_id', '=', $socialUserObject->getId())
                ->where('provider', '=', $provider)
                ->first();
                
                // dd($socialId);
                // Если нет социального пользователя
                if (empty($socialId)) {

                    $socialData = new Social();
                    $profile = new Profile();
                    // Имя и фамилия пользователя
                    $fullname = explode(' ', $socialUserObject->getName());
                    
                    if (count($fullname) == 1) {
                        $fullname[1] = 'Nicname';
                    }
                    $profile->first_name = $fullname[0];
                    $profile->last_name = $fullname[1];
                    
                    // Twitter User Object details: https://developer.twitter.com/en/docs/tweets/data-dictionary/overview/user-object
                    if ($provider == 'twitter') {
                        $username = $socialUserObject->getScreen_name();
                    } else {
                        $username = $socialUserObject->getNickname();
                        
                    }

                    if ($username == null) {
                        foreach ($fullname as $name) {
                            $username .= $name;
                        }
                    }
                    $profile->username = $username;
                    // Получаем аватар
                    $profile->avatar = $socialUserObject->getAvatar();

                    $profile->location = $socialUserObject->user['location'];
                    $profile->bio = $socialUserObject->user['bio'];

                    // Генерация почтового адреса
                    if (!$socialUserObject->getEmail()) {
                        $email = 'missing'.Str::random(10).'@'.Str::random(10).'.example.org';
                    } else {
                        $email = $socialUserObject->getEmail();
                    }
                    // dd($email);
                    // dd($profile);
                    
                    // Check to make sure username does not already exist in DB before recording
                    $username = $this->checkUserName($username, $email);
                    
                    // Создаем нового пользователя
                    $user = User::create(
                        [
                        'name'                 => $username,
                        'email'                => $email,
                        'password'             => bcrypt(Str::random(40)),
                        'email_verified_at' => now(),
                        ]
                    );
                    
                    // dd($user);

                    $socialData->social_id = $socialUserObject->getId();
                    $socialData->provider = $provider;
                    $user->social()->save($socialData);

                    $user->profile()->save($profile);
                    $user->save();

                    $user->profile->save();

                    $socialUser = $user;
                } else {
                    $socialUser = $socialId->user;
                }
            // dd($profile);    
            // dd($socialData);    
                auth()->login($socialUser, true);

                return redirect('home')->with('success', 'You have successfully registered! ');
            }
            $socialUser = $userCheck;

            auth()->login($socialUser, true);

            return redirect('home');

        } catch (\GuzzleHttp\Exception\ClientException $e) {
            dd($e);
        }
        // dd($profile);
    }  
    /**
     * Generate Username.
     *
     * @param string $username
     *
     * @return string
     */
    public function generateUserName($username)
    {
        return $username.'_'.str_random(10);
    }

    /**
     * Check if username against database and return valid username.
     * If username is not in the DB return the username
     * else generate, check, and return the username.
     *
     * @param string $username
     * @param string $email
     *
     * @return string
     */
    public function checkUserName($username, $email)
    {
        $userNameCheck = User::where('name', '=', $username)->first();

        if ($userNameCheck) {
            $i = 1;
            do {
                $username = $this->generateUserName($username);
                $newCheck = User::where('name', '=', $username)->first();

                if ($newCheck == null) {
                    $newCheck = 0;
                } else {
                    $newCheck = count($newCheck);
                }
            } while ($newCheck != 0);
        }

        return $username;
    }
}
