<?php
namespace Adelarcubs\OFXParser;

use PHPUnit_Framework_TestCase;
use Adelarcubs\OFXParser\OfxMovement;
use DateTime;

/**
 *
 * @author Adelar Tiemann Junior <adelar@adelarcubs.com>
 */
class OfxMovementTest extends PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function construct()
    {
        $ofxMovement = new OfxMovement('DEBIT', '123', 'Alguma Descrição', 123.99, new DateTime());

        $this->assertInstanceOf(OfxMovement::class, $ofxMovement);

        $this->assertEquals('Alguma Descrição', $ofxMovement->getDescription());
        $this->assertEquals(123.99, $ofxMovement->getAmount());
        $this->assertInstanceOf(DateTime::class, $ofxMovement->getDueDate());
        $this->assertEquals('123', $ofxMovement->getDocument());
        $this->assertEquals('DEBIT', $ofxMovement->getType());
    }
}
