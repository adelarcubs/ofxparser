<?php
declare(strict_types = 1);
namespace Adelarcubs\OFXParser;

use Adelarcubs\OFXParser\Parser\BaseParser;
use Adelarcubs\OFXParser\Exception\OfxParseException;

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
     * @return Ofx
     */
    public static function loadOfx(string $ofx, AbstractParser $parser = null)
    {
        if (file_exists($ofx)) {
            $ofx = file_get_contents($ofx);
        }
        if (! $parser) {
            $parser = new BaseParser();
        }
        return OfxParser::loadFromString($ofx, $parser);
    }

    private static function loadFromString($ofxContent, AbstractParser $parser)
    {
        $xml = OfxParser::closeUnclosedXmlTags($ofxContent);
        $xml = mb_convert_encoding($xml, 'UTF-8');
        libxml_clear_errors();
        libxml_use_internal_errors(true);
        $xml = simplexml_load_string($xml);
        $errors = libxml_get_errors();
        if (! empty($errors)) {
            throw new OfxParseException('Failed to parse OFX: ' . var_export($errors, true));
        }
        return new Ofx($xml, $parser);
    }

    private static function closeUnclosedXmlTags($ofxContent)
    {
        $lines = OfxParser::ofxToPrepareArray($ofxContent);
        $xml = '';

        $lastClosedTag = '';
        foreach ($lines as $line) {
            if ($line != '') {
                $read = $line;
                $pos = strpos($read, '>');
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
        $xml = str_replace('&', '', $xml);

        return explode("\n", $xml);
    }
}
