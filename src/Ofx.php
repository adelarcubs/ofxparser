<?php
namespace Adelarcubs\OFXParser;

use SimpleXMLElement;

/**
 *
 * @author Adelar Tiemann Junior <adelar@adelarcubs.com>
 */
class Ofx
{

    /**
     *
     * @param SimpleXMLElement $xml            
     */
    public function __construct(SimpleXMLElement $xml)
    {}

    /**
     *
     * @param unknown $ofxFilePath            
     * @throws \InvalidArgumentException
     * @return \Adelarcubs\OFXParser\Ofx
     */
    public static function loadFromFile($ofxFilePath)
    {
        if (file_exists($ofxFilePath)) {
            return static::loadFromString(file_get_contents($ofxFilePath));
        } else {
            throw new \InvalidArgumentException("File '{$ofxFilePath}' could not be found");
        }
    }

    /**
     *
     * @param unknown $xmlString            
     * @throws \Exception
     * @return \Adelarcubs\OFXParser\Ofx
     */
    public static function loadFromString($ofxContent)
    {
        $xml = static::closeUnclosedXmlTags($ofxContent);
        libxml_clear_errors();
        libxml_use_internal_errors(true);
        $xml = simplexml_load_string($xml);
        $errors = libxml_get_errors();
        if (! empty($errors)) {
            throw new \Exception("Failed to parse OFX: " . var_export($errors, true));
        }
        
        return new Ofx($xml);
    }

    private static function closeUnclosedXmlTags($ofxContent)
    {
        $sgmlStart = stripos($ofxContent, '<OFX>');
        $xml = trim(substr($ofxContent, $sgmlStart));
        
        $xml = str_replace("\r", "", $xml);
        $xml = str_replace("\n", "", $xml);
        $xml = str_replace("<", "\n<", $xml);
        
        $lines = explode("\n", $xml);
        $xml = "";
        
        $lastClosedTag = '';
        foreach ($lines as $line) {
            if ($line != "") {
                $read = $line;
                $pos = strpos($read, ">");
                $tag = substr($read, 1, $pos);
                $value = trim(substr($read, $pos + 1));
                $line = '<' . $tag;
                if ($value != '') {
                    $line .= $value;
                    if (strpos($value, '</' . $tag) === false) {
                        $lastClosedTag = '/' . $tag;
                        $line .= '<' . $lastClosedTag;
                    }
                } else {
                    if ($lastClosedTag == $tag) {
                        $line = '';
                    }
                }
                $xml .= $line . "\n";
            }
        }
        return $xml;
    }
}
