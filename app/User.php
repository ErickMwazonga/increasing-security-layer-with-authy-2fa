<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Authy\AuthyApi as AuthyApi;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['name', 'email', 'password', 'phone_number', 'country_code'];
    protected $hidden = ['password', 'remember_token', 'authy_status', 'authy_id'];

    public function registerAuthy() //Checked
    {
        $user = $this->authyApiKey()->registerUser($this->email, $this->phone_number, $this->country_code);

        if( $user->ok() ) {
            $this->authy_id = $user->id();
            $this->save();

            return true;
        }

        return false;
    }

    public function sendToken() {//Checked
        $sms = $this->authyApiKey()->requestSms($this->authy_id);

        return $sms->ok();
    }

    public function verifyToken($token) {//Checked
        $verification = $this->authyApiKey()->verifyToken($this->authy_id, $token);

        if($verification->ok()) {
            return true;
        } else {
            return false;
        }
    }

    private function authyApiKey()//Checked
    {
        return new AuthyApi(getenv('AUTHY_API_KEY'));
    }

    public function sendOneTouch($message) {//Checked
        // reset oneTouch status
        if($this->authy_status != 'unverified') {
            $this->authy_status = 'unverified';
            $this->save();
        }

        $params = array(
            'api_key'=>getenv('AUTHY_API_KEY'),
            'message'=>$message,
            'details[Email]'=>$this->email,
            );

        $defaults = array(
            CURLOPT_URL => "https://api.authy.com/onetouch/json/users/$this->authy_id/approval_requests",
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $params,
            );

        $ch = curl_init();
        curl_setopt_array($ch, $defaults);
        $output = curl_exec($ch);
        curl_close($ch);
        $json = json_decode($output);

        return $json;
    }
}
