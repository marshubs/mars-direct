<?php
// Google Drive Direct Component by st4zz

$clean = fopen('error_log', 'w');
fwrite($clean,'');
fclose($clean);

$id = $_GET['gd'];
 
 function udud($id){
		$ch = curl_init("https://www.googleapis.com/drive/v3/files/$id?alt=media&key=AIzaSyD3j5e_n24B-JPkAd5AIMK-QyrsgmGIk90");
	 /*https://www.googleapis.com/drive/v3/files/10we1Fn13Zzm1L0HkCkW8-Dow8yWOFtX7?alt=media&key=AIzaSyD3j5e_n24B-JPkAd5AIMK-QyrsgmGIk90*/
		curl_setopt_array($ch, array(
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_POSTFIELDS => [],
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => 'gzip,deflate',
			CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
			CURLOPT_HTTPHEADER => [
				'accept-encoding: gzip, deflate, br',
				'content-length: 0',
				'content-type: application/x-www-form-urlencoded;charset=UTF-8',
				'origin: https://drive.google.com',
				'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.181 Safari/537.36',
				'x-client-data: CKG1yQEIkbbJAQiitskBCMS2yQEIqZ3KAQioo8oBGLeYygE=',
				'x-drive-first-party: DriveWebUi',
				'x-json-requested: true'
			]
		));
		$response = curl_exec($ch);
		$response_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		if($response_code == '200') { // Jika response status OK
			$object = json_decode(str_replace(')]}\'', '', $response));
			if(isset($object->downloadUrl)) {
				return $object->downloadUrl;
			} 
		} else {
			return $response_code;
		}
}
$docsurl = udud($id);
header("location: $docsurl");
?>
