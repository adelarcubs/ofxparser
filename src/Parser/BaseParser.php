<?php
declare(strict_types = 1);
namespace Adelarcubs\OFXParser\Parser;

use Adelarcubs\OFXParser\AbstractParser;
use DateTime;

/**
 *
 * @author Adelar Tiemann Junior <adelar@adelarcubs.com>
 */
class BaseParser extends AbstractParser
{

    protected function extractType(): string
    {
        return (string) $this->type;
    }

    protected function extractDocument(): string
    {
        return (string) $this->document;
    }

    protected function extractDescription(): string
    {
        return (string) $this->description;
    }

    protected function extractAmount(): float
    {
        return (float) str_replace(',', '.', $this->amount);
    }

    protected function extractDueDate(): DateTime
    {
        return new DateTime(substr((string) $this->dueDate, 0, 8));
    }
}
