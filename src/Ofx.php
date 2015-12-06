<?php
namespace Adelarcubs\OFXParser;

use SimpleXMLElement;

/**
 *
 * @author Adelar Tiemann Junior <adelar@adelarcubs.com>
 */
class Ofx
{

    public $ofx;

    public function __construct(SimpleXMLElement $xml)
    {
        $this->ofx = $xml;
    }
}
