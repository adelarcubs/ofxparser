<?php
namespace Adelarcubs\OFXParser;

use SimpleXMLElement;
use DateTime;

/**
 *
 * @author Adelar Tiemann Junior <adelar@adelarcubs.com>
 */
class OfxMovement
{

    private $document;

    private $description;

    private $amount;

    private $dueDate;

    public function __construct(SimpleXMLElement $xml)
    {
        $this->document = $xml->FITID;
        $this->description = $xml->MEMO;
        $this->amount = (float) str_replace(',', '.', $xml->TRNAMT);
        $this->dueDate = new DateTime(substr($xml->DTPOSTED, 0, 8));
    }

    public function getDocument()
    {
        return $this->document;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function getDueDate()
    {
        return $this->dueDate;
    }
}
