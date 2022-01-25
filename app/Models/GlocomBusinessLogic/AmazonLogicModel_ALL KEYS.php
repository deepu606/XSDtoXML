<?php
namespace App\Models\GlocomBusinessLogic;

use App\Http\Controllers\Controller;

/* --- PACKAGE FOR MANAGING ARRAY TO XML ---*/
use Spatie\ArrayToXml\ArrayToXml;

class AmazonLogicModel{
/*
|--------------------------------------------------------------------------
| API CALL FUNTION - CURL REQUEST 
|--------------------------------------------------------------------------
|
| The Curl function handling the API calls and returns back  the API response.
| OAuth Token,URL,Method are mandatory. Request is in Json Format
|
*/
	public function PrepareXML($ResquestArray){

            if(isset($ResquestArray['@attributes']['targetNamespace'])){
                $TargetNameSpace = $ResquestArray['@attributes']['targetNamespace'];
                unset($ResquestArray['@attributes']); 
            }else{
                $TargetNameSpace = "UserAttribute"; 
            }
          
            echo "<pre>";
            print_r($ResquestArray);

            $keys = $this->array_keys_multi($ResquestArray);

            print_r($keys);


            $XmlRequest = ArrayToXml::convert($ResquestArray, [
                'rootElementName' => $TargetNameSpace,
                '_attributes' => [
                    'xmlns' => 'urn:amazon:apis:eBLBaseComponents',
                ],
            ], true, 'UTF-8', '1.1', []);

            // print_r($XmlRequest);exit();
            return $XmlRequest;
    }

    public function array_keys_multi($array)
        {
            $keys = array();

            foreach ($array as $key => $value) {
                $keys[] = $key;

                if (is_array($value)) {
                    $keys = array_merge($keys, $this->array_keys_multi($value));
                }
            }

            return $keys;
        }

}