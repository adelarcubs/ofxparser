<?php
declare(strict_types = 1);
namespace Adelarcubs\OFXParser;

use SimpleXMLElement;
use DateTime;

/**
 *
 * @author Adelar Tiemann Junior <adelar@adelarcubs.com>
 */
abstract class AbstractParser
{

    protected $type;

    protected $document;

    protected $description;

    protected $amount;

    protected $dueDate;

    public function parseXml(SimpleXMLElement $xml): OfxMovement
    {
        $this->type = (string) $xml->TRNTYPE;
        $this->document = (string) $xml->FITID;
        $this->description = (string) $xml->MEMO;
        $this->amount = (string) $xml->TRNAMT;
        $this->dueDate = (string) $xml->DTPOSTED;

        return new OfxMovement($this->extractType(), $this->extractDocument(), $this->extractDescription(), $this->extractAmount(), $this->extractDueDate());
    }

    abstract protected function extractType(): string;

    abstract protected function extractDocument(): string;

    abstract protected function extractDescription(): string;

    abstract protected function extractAmount(): float;

    abstract protected function extractDueDate(): DateTime;
}
