<?php
declare(strict_types = 1);
namespace Adelarcubs\OFXParser;

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

    public function __construct(string $type, string $document, string $description, float $amount, DateTime $dueDate)
    {
        $this->type = $type;
        $this->document = $document;
        $this->description = $description;
        $this->amount = $amount;
        $this->dueDate = $dueDate;
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
