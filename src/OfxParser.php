<?php
namespace Adelarcubs\OFXParser;

/**
 *
 * @author Adelar Tiemann Junior <adelar@adelarcubs.com>
 */
class OfxParser
{

    /**
     *
     * @param mixed $ofx
     *            File or File Path
     * @return  Ofx
     */
    public static function loadOfx($ofx)
    {
        if (file_exists($ofx)) {
            $ofx = file_get_contents($ofx);
        }
        return OfxParser::loadFromString($ofx);
    }

    private static function loadFromString($ofxContent)
    {
        $xml = OfxParser::closeUnclosedXmlTags($ofxContent);
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
        $lines = OfxParser::ofxToPrepareArray($ofxContent);
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

    private static function getOfxPart($ofxFileContent)
    {
        $sgmlStart = stripos($ofxFileContent, '<OFX>');
        return trim(substr($ofxFileContent, $sgmlStart));
    }

    private static function ofxToPrepareArray($ofx)
    {
        $ofxContent = OfxParser::getOfxPart($ofx);

        $xml = str_replace("\r", "", $ofxContent);
        $xml = str_replace("\n", "", $xml);
        $xml = str_replace("<", "\n<", $xml);

        return explode("\n", $xml);
    }
}
