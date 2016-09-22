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

    private $movements = [];

    public function __construct(SimpleXMLElement $xml)
    {
        $this->ofx = $xml;
        $this->exportMovements($xml->BANKMSGSRSV1->STMTTRNRS->STMTRS->BANKTRANLIST->STMTTRN);
    }

    public function getMovements(){
    	return $this->movements;
    }

    private function exportMovements(SimpleXMLElement $xml){
    	foreach ($xml as $value) {
    		$this->movements[] = new OfxMovement($value);
    	}
    }
}
