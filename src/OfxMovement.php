<?php
namespace Adelarcubs\OFXParser;

use SimpleXMLElement;
/**
 *
 * @author Adelar Tiemann Junior <adelar@adelarcubs.com>
 */
class OfxMovement
{

    private $description;

    public function __construct(SimpleXMLElement $xml)
    {
        $this->description = $xml->MEMO;
    }

    public function getDescription(){
    	return $this->description;
    }
}
