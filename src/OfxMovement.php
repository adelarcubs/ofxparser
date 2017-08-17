<?php
declare(strict_types = 1);
namespace Adelarcubs\OFXParser;

use SimpleXMLElement;
use DateTime;

/**
 *
 * @author Adelar Tiemann Junior <adelar@adelarcubs.com>
 */
class OfxMovement
{

    private $type;

    private $document;

    private $description;

    private $amount;

    private $dueDate;

    public function __construct(SimpleXMLElement $xml)
    {
        $this->type = (string) $xml->TRNTYPE;
        $this->document = (string) $xml->FITID;
        $this->description = (string) $xml->MEMO;
        $this->amount = (float) str_replace(',', '.', $xml->TRNAMT);
        $this->dueDate = new DateTime(substr($xml->DTPOSTED, 0, 8));
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getDocument(): string
    {
        return $this->document;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getDueDate(): DateTime
    {
        return $this->dueDate;
    }
}
