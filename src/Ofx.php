<?php
declare(strict_types = 1);
namespace Adelarcubs\OFXParser;

use JsonSerializable;
use SimpleXMLElement;

/**
 *
 * @author Adelar Tiemann Junior <adelar@adelarcubs.com>
 */
class Ofx implements JsonSerializable
{

    private $ofx;

    private $movements = [];

    public function __construct(SimpleXMLElement $xml)
    {
        $this->ofx = $xml;

        if (isset($this->ofx->BANKMSGSRSV1->STMTTRNRS->STMTRS->BANKTRANLIST->STMTTRN)) {
            $movements = $this->ofx->BANKMSGSRSV1->STMTTRNRS->STMTRS->BANKTRANLIST->STMTTRN;
        }
        if (isset($this->ofx->CREDITCARDMSGSRSV1->CCSTMTTRNRS->CCSTMTRS->BANKTRANLIST)) {
            $movements = $this->ofx->CREDITCARDMSGSRSV1->CCSTMTTRNRS->CCSTMTRS->BANKTRANLIST->STMTTRN;
        }

        $this->exportMovements($movements);
    }

    public function getMovements(): array
    {
        return $this->movements;
    }

    private function exportMovements(SimpleXMLElement $xml)
    {
        foreach ($xml as $value) {
            $this->movements[] = new OfxMovement($value);
        }
    }

    public function jsonSerialize()
    {
        return json_decode(json_encode($this->ofx), true);
    }
}
