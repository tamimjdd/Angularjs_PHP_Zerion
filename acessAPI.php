<?php

Class Token{
	  // private constructor function
	  // to prevent external instantiation
	public function Token() {
	}
	
	function base64url_encode($data) { 
		return rtrim(strtr(base64_encode($data), '+/', '-_'), '='); 
	} 
	function base64url_decode($data) { 
		return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT)); 
	} 
	//to generate a token and get an access token
	private function generateToken(){
		$post_Header = base64_encode(json_encode(array("alg" => "HS256","typ" => "JWT")));
		$header = [
                  'typ' => 'JWT',
                  'alg' => 'HS256'
        ];
		// Returns the JSON representation of the header
		$header = json_encode($header);
		//encodes the $header with base64.	
		$header = base64_encode($header);
		
		$CLIENT_KEY = CLIENT_KEY;
		$AUD_VALUE = AUD_VALUE;
		$CLIENT_SECRET = CLIENT_SECRET;
		$nowtime = time();
		$exptime = $nowtime + 599;
		
		$payload = "{
			\"iss\": \"$CLIENT_KEY\",
		   \"aud\": \"$AUD_VALUE\",
		  \"exp\": $exptime,
		  \"iat\": $nowtime}";	
		$payload = $this->base64url_encode($payload);
		
		
		$signature = $this->base64url_encode(hash_hmac('sha256',"$header.$payload",$CLIENT_SECRET, true));
		$assertionValue = "$header.$payload.$signature";
		
		$grant_type = "urn:ietf:params:oauth:grant-type:jwt-bearer";
		$grant_type = urlencode($grant_type);
		$postField= "grant_type=".$grant_type."&assertion=".$assertionValue;	
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_URL, AUD_VALUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);

		curl_setopt($ch, CURLOPT_POSTFIELDS,"$postField");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		  "Content-Type: application/x-www-form-urlencoded",
		  "cache-control: no-cache"
		));
		$response = curl_exec($ch);
		$headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		curl_close($ch);
		
		$tokenArray = json_decode($response,true);
		return $token = $tokenArray['access_token'];

	}
	
	public function AddFormDetails($FirstName,$LastName,$Email,$Telephone,$ZipCode,$Preference,$Gender,$Skills,$Date,$Comment,$Subscribe){
		//Initiate curl and send the data through API by using generateToken function
			$FirstName =	$this->clean($FirstName);
			$LastName = $this->clean($LastName);
			$Email = $this->cleanSpace($Email);
			$Preference = trim(strtolower($Preference));
			$Telephone = trim($Telephone);
			$ZipCode = 	trim($ZipCode);
			$Gender = trim($Gender);
			$Date = date("Y-m-d", strtotime(trim($Date)));
			$Subscribe = trim($Subscribe);
			$Skills = number_format(trim($Skills),4);
			$Comment = trim($Comment);
			
			//generating a Token for access
			$JWToken = $this->generateToken();	

			$jsonPostFields = "[{
				\"fields\":[
				  {
					\"element_name\": \"first_name\",
					\"value\": \"$FirstName\"
				  },
				  {
					\"element_name\": \"last_name\",
					\"value\": \"$LastName\"
				  },
				  {
					\"element_name\": \"email\",
					\"value\": \"$Email\"
				  },
				  {
					\"element_name\": \"dob\",
					\"value\": \"$Date\"
				  },
				  {
					\"element_name\": \"colors\",
					\"value\": \"$Preference\"
				  },
				  {
					\"element_name\": \"phone\",
					\"value\": \"$Telephone\"
				  },
				  {
					\"element_name\": \"gender\",
					\"value\": \"$Gender\"
				  },
				  {
					\"element_name\": \"subscribe\",
					\"value\": \"$Subscribe\"
				  },
				  {
					\"element_name\": \"rating\",
					\"value\": \"$Skills\"
				  },
				  {
					\"element_name\": \"comments\",
					\"value\": \"$Comment\"
				  },
				  {
					\"element_name\": \"zip_code\",
					\"value\": \"$ZipCode\"
				  }
				]
			  }]";
			
			$ch1 = curl_init();

			// curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, FALSE);
			// curl_setopt($ch1, CURLOPT_SSL_VERIFYHOST, FALSE);
			curl_setopt($ch1, CURLOPT_URL, RECORDURL);
			curl_setopt($ch1, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch1, CURLOPT_HEADER, FALSE);

			curl_setopt($ch1, CURLOPT_POST, TRUE);

			curl_setopt($ch1, CURLOPT_POSTFIELDS, $jsonPostFields);

			curl_setopt($ch1, CURLOPT_HTTPHEADER, array(
			  "Content-Type: application/json",
			  "Authorization: Bearer {$JWToken}"
			));

			$response = curl_exec($ch1);
			curl_close($ch1);
			var_dump($response);
				
	}
	
	function clean($string) {
		$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
		return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
	}
	function cleanSpace($string) {
		$string = str_replace(' ', '', $string); // Replaces all spaces with hyphens.
		return $string = trim(preg_replace('/\s\s+/', ' ', $string));
	}
	
}
?>