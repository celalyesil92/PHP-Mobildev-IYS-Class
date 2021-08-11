# PHPMobildevIYS
Mobildev PHP IYS Entegrasyonu

#### Class dosyasını projenize ekledikten sonra class'ımızı başlatıyoruz.

> $mobildev = new Mobildev();

#### __construct fonksiyonumuzda erişim bilgilerimizi tanımlıyoruz

> $this->base64Key 		  = base64_encode("APIKEY:APISECRET");<br>
>	$this->sms_username		= "APIKEY";<br>
>	$this->sms_apikey		  = "APISECRET";<br>
