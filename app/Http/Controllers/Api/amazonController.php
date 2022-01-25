<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GlocomBusinessLogic\AmazonLogicModel;
use DOMDocument;
use DOMXPath;
class amazonController extends Controller
{

    public function __construct() {
		$this->AmazonLogicModel = new AmazonLogicModel();
	}
	
####################################### GET API CALLS - TRADITIONAL API ################################################
    public function XMLProcessor(){
        $doc = new DOMDocument();
        $doc->preserveWhiteSpace = true;
        $doc->load('sample/test.xsd');
        $doc->save('sample/xmldata.xml');
        $xmlfile = file_get_contents('sample/xmldata.xml');

        $parseObj = str_replace($doc->lastChild->prefix.':',"",$xmlfile);
        $ob= simplexml_load_string($parseObj);
        $json  = json_encode($ob);
        $data = json_decode($json, true);
        $XMLOut = $this->AmazonLogicModel->PrepareXML($data); 

        echo "<textarea style='width:100%;height:500px;'>".($XMLOut)."</textarea>";

    }

    public function SampleXML(){
        $xsdstring = <<<XML
            <?xml version="1.0" encoding="ISO-8859-1" ?>
            <xs:schema xmlns:xs="http://www.w3.org/2001/XMLSchema">
                <xs:element name="ClassificationData">
                    <xs:complexType>
                        <xs:sequence>
                            <xs:element name="Department" type="StringNotNull" />
                            <xs:element name="ColorMap" minOccurs="0" type="String" />
                            <xs:element name="SpecialSizeType" minOccurs="0" type="String" />
                            <xs:element name="SpecialFeature" minOccurs="0" type="LongString" maxOccurs="2" />
                            <xs:element name="MaterialAndFabric" minOccurs="0" type="HundredString" maxOccurs="4" />
                            <xs:element name="ImportDesignation" minOccurs="0" type="String" />
                            <xs:element name="CountryAsLabeled" minOccurs="0" type="CountryOfOriginType" />
                            <xs:element name="FurDescription" minOccurs="0" type="LongString" />
                            <xs:element name="MaterialOpacity" minOccurs="0" type="HundredString" />
                            <xs:element name="FabricWash" minOccurs="0" type="String" />
                            <xs:element name="PatternStyle" minOccurs="0" type="String" />
                            <xs:element name="FitType" minOccurs="0" type="String" />
                            <xs:element name="WaterResistanceLevel" minOccurs="0" type="WaterResistantType" />
                            <xs:element name="ApparelClosureType" minOccurs="0" type="LongString" />
                            <xs:element name="ButtonQuantity" minOccurs="0" type="xs:nonNegativeInteger" />
                            <xs:element name="ControlType" minOccurs="0" type="String" />
                            <xs:element name="OccasionAndLifestyle" minOccurs="0" type="LongString" />
                            <xs:element name="StyleName" minOccurs="0" type="StringNotNull" />
                            <xs:element name="StyleNumber" minOccurs="0" type="StringNotNull" />
                            <xs:element name="CollarType" minOccurs="0" type="String" />
                            <xs:element name="SleeveType" minOccurs="0" type="String" />
                            <xs:element name="CuffType" minOccurs="0" type="String" />
                            <xs:element name="PocketDescription" minOccurs="0" type="String" />
                            <xs:element name="FrontPleatType" minOccurs="0" type="String" />
                            <xs:element name="TopStyle" minOccurs="0" type="String" />
                            <xs:element name="BottomStyle" minOccurs="0" type="String" />
                            <xs:element name="SizeMap" minOccurs="0" type="StringNotNull" />
                            <xs:element name="WaistSize" minOccurs="0" type="ClothingSizeDimension" />
                            <xs:element name="InseamLength" minOccurs="0" type="ClothingSizeDimension" />
                            <xs:element name="SleeveLength" minOccurs="0" type="ClothingSizeDimension" />
                            <xs:element name="NeckSize" minOccurs="0" type="ClothingSizeDimension" />
                            <xs:element name="NeckStyle" minOccurs="0" type="String" />
                            <xs:element name="ChestSize" minOccurs="0" type="ClothingSizeDimension" />
                            <xs:element name="CupSize" minOccurs="0">
                                <xs:simpleType>
                                    <xs:restriction base="xs:string">
                                        <xs:enumeration value="A" />
                                        <xs:enumeration value="AA" />
                                        <xs:enumeration value="B" />
                                        <xs:enumeration value="C" />
                                        <xs:enumeration value="D" />
                                        <xs:enumeration value="DD" />
                                        <xs:enumeration value="DDD" />
                                        <xs:enumeration value="E" />
                                        <xs:enumeration value="EE" />
                                        <xs:enumeration value="F" />
                                        <xs:enumeration value="FF" />
                                        <xs:enumeration value="G" />
                                        <xs:enumeration value="GG" />
                                        <xs:enumeration value="H" />
                                        <xs:enumeration value="HH" />
                                        <xs:enumeration value="I" />
                                        <xs:enumeration value="J" />
                                        <xs:enumeration value="Free" />
                                    </xs:restriction>
                                </xs:simpleType>
                            </xs:element>
                            <xs:element name="UnderwireType" minOccurs="0" type="String" />
                            <xs:element name="ShoeWidth" minOccurs="0" type="String" />
                            <xs:element name="ItemRise" minOccurs="0" type="LengthDimension" />
                            <xs:element name="RiseStyle" minOccurs="0" type="String" />
                            <xs:element name="LegDiameter" minOccurs="0" type="LengthDimension" />
                            <xs:element name="LegStyle" minOccurs="0" type="String" />
                            <xs:element name="BeltStyle" minOccurs="0" type="String" />
                            <xs:element name="StrapType" minOccurs="0" type="StringNotNull" />
                            <xs:element name="ToeStyle" minOccurs="0" type="String" />
                            <xs:element name="Theme" minOccurs="0" type="LongString" />
                            <xs:element name="Character" minOccurs="0" type="HundredString" />
                            <xs:element name="LaptopCapacity" minOccurs="0" type="String" />
                            <xs:element name="IsStainResistant" minOccurs="0" type="xs:boolean" />
                            <xs:element name="NumberOfPieces" minOccurs="0" type="PositiveInteger" />
                            <xs:element name="WheelType" minOccurs="0" type="String" />
                            <xs:element name="MaterialType" minOccurs="0" type="StringNotNull" />
                            <xs:element name="SupplierDeclaredMaterialRegulation" minOccurs="0" maxOccurs="3">
                                <xs:simpleType>
                                    <xs:restriction base="xs:string">
                                        <xs:enumeration value="bamboo" />
                                        <xs:enumeration value="fur" />
                                        <xs:enumeration value="wool" />
                                        <xs:enumeration value="not_applicable" />
                                    </xs:restriction>
                                </xs:simpleType>
                            </xs:element>
                            <xs:element name="ModelName" minOccurs="0" type="StringNotNull" />
                            <xs:element name="ItemTypeName" minOccurs="0" type="StringNotNull" />
                            <xs:element name="LiningDescription" minOccurs="0" type="StringNotNull" />
                            <xs:element name="TargetGender" minOccurs="0" type="TargetGenderType" />
                            <xs:element name="GHSClassificationSubcategory" minOccurs="0" type="StringNotNull" maxOccurs="3" />
                            <xs:element name="WarrantyDescription" minOccurs="0" type="StringNotNull" />
                        </xs:sequence>
                    </xs:complexType>
                </xs:element>
            </xs:schema>
            XML;

            $doc = new DOMDocument();
            $doc->loadXML(mb_convert_encoding($xsdstring, 'utf-8', mb_detect_encoding($xsdstring)));
            $xpath = new DOMXPath($doc);
            $xpath->registerNamespace('xs', 'http://www.w3.org/2001/XMLSchema');

            $elementDefs = $xpath->evaluate("/xs:schema/xs:element");
            foreach($elementDefs as $elementDef) {
              $this->echoElements("", $elementDef,$doc,$xpath);
            }
    }

     public function echoElements($indent, $elementDef,$doc,$xpath) {
              echo "<div>" . $indent . $elementDef->getAttribute('name') . "</div>\n";
              $elementDefs = $xpath->evaluate("xs:complexType/xs:sequence/xs:element", $elementDef);
              foreach($elementDefs as $elementDef) {
                $this->echoElements($indent . "&nbsp;&nbsp;&nbsp;&nbsp;", $elementDef,$doc,$xpath);
              }
            }
}
