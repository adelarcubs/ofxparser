<?php
namespace Adelarcubs\OFXParser;

class OfxParser
{

    private $ofx;

    /**
     *
     * @param mixed $ofx
     *            File or File Path
     */
    public function __construct($ofx)
    {
        if (file_exists($ofx)) {
            $ofx = file_get_contents($ofx);
        }
        return $this->loadFromString($ofx);
    }

    public function getOfx()
    {
        return $this->ofx;
    }

    private function loadFromString($ofxContent)
    {
        $xml = $this->closeUnclosedXmlTags($ofxContent);
        libxml_clear_errors();
        libxml_use_internal_errors(true);
        $xml = simplexml_load_string($xml);
        $errors = libxml_get_errors();
        if (! empty($errors)) {
            throw new \Exception("Failed to parse OFX: " . var_export($errors, true));
        }
        $this->ofx = new Ofx($xml);
        return $this->ofx;
    }

    private function closeUnclosedXmlTags($ofxContent)
    {
        $lines = $this->ofxToPrepareArray($ofxContent);
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

    private function getOfxPart($ofxFileContent)
    {
        $sgmlStart = stripos($ofxFileContent, '<OFX>');
        return trim(substr($ofxFileContent, $sgmlStart));
    }

    private function ofxToPrepareArray($ofx)
    {
        $ofxContent = $this->getOfxPart($ofx);
        
        $xml = str_replace("\r", "", $ofxContent);
        $xml = str_replace("\n", "", $xml);
        $xml = str_replace("<", "\n<", $xml);
        
        return explode("\n", $xml);
    }
}
