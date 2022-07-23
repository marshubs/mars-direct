<?php
error_reporting(0);
function get_http_response_code($redirect)
  {
    $headers = get_headers($redirect);
    return substr($headers[0], 9, 3);
  }
function my_simple_crypt($string, $action = 'e')
  {
    $secret_key     = ''; //your key
    $secret_iv      = ''; //your iv
    $output         = true;
    $encrypt_method = "AES-128-CBC";
    $key            = hash('sha1', $secret_key);
    $iv             = substr(hash('sha1', $secret_iv), 0, 5);
    if ($action == 'e')
      {
        $output = base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv));
      }
    else if ($action == 'd')
      {
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
      }
    return $output;
  }
if ($_GET['id'] != "")
  {
    $id                     = $_GET['id'];
    $ori                    = my_simple_crypt($id, 'd');
    $apikey                 = "AIzaSyD3j5e_n24B-JPkAd5AIMK-QyrsgmGIk90"; //your api key
    //$url2 = "https://www.googleapis.com/drive/v2/files/$ori?alt=media&key=$apikey";
    $url                    = "https://www.googleapis.com/drive/v3/files/$ori?key=$apikey";
    $redirect               = "https://www.googleapis.com/drive/v3/files/$ori?alt=media&key=$apikey";
    //$json2 = file_get_contents($url2);
    $json                   = file_get_contents($url);
    $data                   = json_decode($json, true);
    //$data2 = json_decode($json2, true);
    $get_http_response_code = get_http_response_code($redirect);
    //$size = $data2["fileSize"];
    $name                   = $data["name"];
    $mime                   = $data["mimeType"];
    //header("Content-Length: $size");
    if ($get_http_response_code == 403)
      {
        header('Content-Type: application/json');
        header('status: 403');
        $error = array(
                'code' => 403,
                'message' => 'The download quota for this file has been exceeded.'
            );
        echo json_encode($error);
      }
    else
      {
        header("Content-Type: $mime");
        header("Content-Transfer-Encoding: Binary");
        header("Content-disposition: attachment; filename=\"$name\"");
        echo readfile($redirect);
      }
  }
else
  {
    header('Content-Type: application/json');
    $error = array(
        "error" => true
    );
    echo json_encode($error);
  }
?>
