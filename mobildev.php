<?php
/**
 * MOBILDEV API
 */
class Mobildev{
	
	function __construct()	{
		$this->base64Key 		= "NDI0OTQ3MDk3Njp3M2Z6ZWU2cnJwdmV4Mm5oajQwYWIweTdrOTB2ZjI=";
		$this->sms_username		= "7698653867";
		$this->sms_apikey		= "5fba8c43b2ee40cfa5f9ec9f194f930e";
		$this->mobildev_url		= "";
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

	public function IzinKontrol($gsmnumber){
		$this->gsmnumber = $gsmnumber;

		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://ivtapi.mobildev.in/check',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS =>'{
		    "key": '.$this->gsmnumber.'
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

	public function IzinListesi(){

		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://ivtapi.mobildev.in/form',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'GET',
		  CURLOPT_HTTPHEADER => array(
		    'Content-Type: application/json',
		    'Authorization: Bearer '.$this->AccessTokenGenerate()
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		return $response;
	}

	public function OnayGonder($firstName, $lastName, $gsmnumber, $email, $note){
		$this->firstName 	= $firstName;
		$this->lastName 	= $lastName;
		$this->gsmnumber	= $gsmnumber;
		$this->email 		= $email;
		$this->note 		= $note;

		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'http://api.ivt.testdrive.club/data/h9815bxf',
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
		        "msisdn": 1,
		        "msisdnFrequencyType": 1,
		        "msisdnFrequency": 2,
		        "call":1,
		        "email": 1,
		        "emailFrequencyType": 1,
		        "emailFrequency": 2,
		        "share": 1
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
		return $response;
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

$mobildev = new Mobildev();

//echo $mobildev->OnayGonder("Celal", "Yeşil", "5546037178", "celal@theflatart.com", "");
//echo $mobildev->KayitOnay("CUue41TdhM", "5546037178", "31947948");
echo $mobildev->SmsGonder("05546037178", "Test");