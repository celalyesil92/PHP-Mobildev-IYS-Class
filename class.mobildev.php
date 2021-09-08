<?php
/**
 * MOBILDEV API
 */
class Mobildev{
	
	function __construct()	{
		$this->base64Key 		= base64_encode("APIKEY:APISECRET");
		$this->sms_username		= "APIKEY";
		$this->sms_apikey		= "APISECRET";
	}

	//Access Token Oluşturma
	public function AccessTokenGenerate(){
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://ivt.mobildev.com/auth',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_HTTPHEADER => array(
		    'Authorization: Basic '.$this->base64Key
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);

		$reponse_array = json_decode($response, true);
		return $reponse_array['access_token'];
	}

	public function OnayGonder($firstName, $lastName, $gsmnumber, $email, $note, $etk){
		$this->firstName 	= $firstName;
		$this->lastName 	= $lastName;
		$this->gsmnumber	= $gsmnumber;
		$this->email 		= $email;
		$this->note 		= $note;
		if($etk == 'on' || $etk == 'true') {
            $this->etk = 1;
        }else{
            $this->etk = 0;
        }

		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'http://api.ivt.testdrive.club/data/ID',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS =>'{
		    "firstName": "'.$this->firstName.'",
		    "lastName": "'.$this->lastName.'",
		    "msisdn": "'.$this->gsmnumber.'",
		    "email": "'.$this->email.'",
		    "language" : "tr",
		    "permSource" : 1, 
		    "accountType": 1,
		    "note": "'.$this->note.'",
		    "etk": {
		        "msisdn": '.$this->etk.',
		        "msisdnFrequencyType": 1,
		        "msisdnFrequency": 2,
		        "call":'.$this->etk.',
		        "email": '.$this->etk.',
		        "emailFrequencyType": 1,
		        "emailFrequency": 2,
		        "share": '.$this->etk.'
		    },
		    "kvkk": {
		        "process": 1,
		        "share": 1,
		        "international": 1
		    }
		}',
		  CURLOPT_HTTPHEADER => array(
		    'Content-Type: application/json',
		    'Authorization: Bearer '.$this->AccessTokenGenerate()
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);
        $reponse_array = json_decode($response, true);
//print_r($reponse_array);
        if($reponse_array['dataId']){
            return $reponse_array['dataId'];
        }else{
            return "false";
        }

	}

	public function KayitOnay($dataid, $gsmnumber, $code){
		$this->dataid 		= $dataid;
		$this->gsmnumber 	= $gsmnumber;
		$this->code 		= $code;

		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'http://api.ivt.testdrive.club/data/verify/'.$this->dataid,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS =>'{
		"item" : "'.$this->gsmnumber.'",
		"code" : "'.$this->code.'"
		}',
		CURLOPT_HTTPHEADER => array(
		    'Content-Type: application/json',
		    'Authorization: Bearer '.$this->AccessTokenGenerate()
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		return $response;
	}

	public function SmsGonder($gsmnumber, $message){
        $gsmnumber = str_replace("(", "", $gsmnumber);
        $gsmnumber = str_replace(")", "", $gsmnumber);
        $gsmnumber = str_replace(" ", "", $gsmnumber);

		$this->gsmnumber = $gsmnumber;
		$this->message = $message;

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://xmlapi.mobildev.com',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'<MainmsgBody>
                <UserName>'.$this->sms_username.'</UserName>
                <PassWord>'.$this->sms_apikey.'</PassWord>
                <Action>0</Action>
                <Mesgbody>'.$this->message.'</Mesgbody>
                <Numbers>'.$this->gsmnumber.'</Numbers>
                <AccountId></AccountId>
                <Originator></Originator>
                <Blacklist></Blacklist>
                <SDate></SDate>
                <EDate></EDate>
                <Encoding>0</Encoding>
                <MessageType>N</MessageType>
                <RecipientType></RecipientType>
            </MainmsgBody>
        ',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/xml'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
	}
}

// $mobildev = new Mobildev();

//echo $mobildev->OnayGonder("test", "test", "5551234567", "test@test.com", "");
//echo $mobildev->KayitOnay("CUue41TdhM", "5551234567", "31947948");
//echo $mobildev->SmsGonder("5551234567", "Test sms");
