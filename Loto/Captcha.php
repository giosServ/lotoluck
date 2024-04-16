<?php
class Captcha 
{
	protected $secretKey = '0x260b5f607329069E244Fc4F754B7f7D9fd4b7B07';
	protected $captchaVerificationEndpoint = 'https://hcaptcha.com/siteverify';
	
	public function checkCaptcha($response)
	{
	
		$responseDate = json_decode($this->verifyCaptcha([
		
				'secret'=> $this->secretKey,
				'response'=> $response
			]));

		return $responseDate->success;
	}

	 protected function verifyCaptcha($data)
		{
			$verify = curl_init();
			curl_setopt($verify, CURLOPT_URL, $this->captchaVerificationEndpoint);
			curl_setopt($verify, CURLOPT_POST, true);
			curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
			curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);

			return curl_exec($verify);
		}
}


?>