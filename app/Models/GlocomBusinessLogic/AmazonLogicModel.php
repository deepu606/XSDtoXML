<?php
namespace App\Models\GlocomBusinessLogic;

use App\Http\Controllers\Controller;

/* --- PACKAGE FOR MANAGING ARRAY TO XML ---*/
use Spatie\ArrayToXml\ArrayToXml;
use SimpleXMLElement;
use DOMDocument;

class AmazonLogicModel{

   public function array_to_xml($array, &$xml) {

        echo "<pre>";print_r($array);        
        foreach($array as $key => $value) {               
            if(is_array($value)) {            
                if(!is_numeric($key)){
                    $subnode = $xml->addChild($key);
                    $this->array_to_xml($value, $subnode);
                } else {
                    $this->array_to_xml($value, $subnode);
                }
            } else {
                $xml->addChild($key, $value);
            }
        }        
    }

    public function PrepareXML($ResquestArray){
       if(isset($ResquestArray['@attributes']['targetNamespace'])){
                $TargetNameSpace = $ResquestArray['@attributes']['targetNamespace'];
                unset($ResquestArray['@attributes']['targetNamespace']); 
            }else{
                $TargetNameSpace = "UserAttribute"; 
            }

             $XmlRequest = ArrayToXml::convert($ResquestArray, [
                'rootElementName' => $TargetNameSpace,
                '_attributes' => [
                    'xmlns' => 'urn:amazon:apis:eBLBaseComponents',
                ],
            ], false, 'UTF-8', '1.1', []);

            // print_r($XmlRequest);exit();
            return $XmlRequest;

    }

}