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
                unset($ResquestArray['@attributes']['targetNamespace']); 
            }else{
                $TargetNameSpace = "UserAttribute"; 
            }
            
            $AttributesArrayMain = array();
            if(!empty($ResquestArray['@attributes'])){
                foreach ($ResquestArray['@attributes'] as $key => $attribute) {
                    
                    $AttributesArrayMain[$key] = $attribute; 

                }

            }
            
            unset($ResquestArray['@attributes']);

            echo "<pre>";
           // print_r($ResquestArray);
            
           $MODArray = $this->PrepareXMLArray($ResquestArray);
             //print_r($MODArray);
            $XmlRequest = ArrayToXml::convert($MODArray, [
                'rootElementName' => $TargetNameSpace,
                '_attributes' => [
                    'xmlns' => 'urn:amazon:apis:eBLBaseComponents',
                ],
            ], true, 'UTF-8', '1.1', []);

            // print_r($XmlRequest);exit();
            return $XmlRequest;
    }

    public function PrepareXMLArray($ResquestArray)
    {
       
        $MODArrayData = array();
        foreach ($ResquestArray as $key => $value) {
            if($key == 'element'){
                if(isset($value['@attributes']['name'])){
                    $name = $value['@attributes']['name'];
                    unset($value['@attributes']['name']);

                    $Attributes = array('@attributes'=>$value['@attributes']);
                    unset($value['@attributes']);
                    $MODArrayData[$name] = array_merge($Attributes,$this->Looper($key,$value));
                }else{
                    foreach ($value as $value1) {                      
                        if(isset($value1['@attributes']['name'])){
                                $name1 = $value1['@attributes']['name'];
                                unset($value1['@attributes']['name']);

                                $MODArrayData[$name1] = $value1;

                            }
                    }
                }
            }else{
                $MODArrayData[$key] = $this->Looper($key,$value);
            }
        }
        return ($MODArrayData);
    }

    public function Looper($ParentKey,$ResquestArray)
    {
       // print_r($ResquestArray);exit();
        $MODArrayDataChild = array();
        foreach ($ResquestArray as $key => $value) {
            if($key == 'element'){

                if(isset($value['@attributes']['name'])){
                    $name = $value['@attributes']['name'];
                    unset($value['@attributes']['name']);

                    $Attributes = array('@attributes'=>$value['@attributes']);
                    unset($value['@attributes']);


                    $MODArrayDataChild[$name] = array_merge($Attributes,$this->Looper($key,$value));
                }else{
                    foreach ($value as $value1) {                      
                        if(isset($value1['@attributes']['name'])){
                                $name1 = $value1['@attributes']['name'];
                                unset($value1['@attributes']['name']);
                                $MODArrayDataChild[$name1] = $value1;

                            }
                    }
                }
            }else{
                $MODArrayDataChild[$key] = $this->Looper($key,$value);
            }
        }

        return $MODArrayDataChild;
    }
}