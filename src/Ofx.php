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

    private $parser;

    public function __construct(SimpleXMLElement $xml, AbstractParser $parser)
    {
        $this->ofx = $xml;
        $this->parser = $parser;

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
            $this->movements[] = $this->parser->parseXml($value);
        }
    }

    public function jsonSerialize(): string
    {
        return json_decode(json_encode($this->ofx), true);
    }
}
