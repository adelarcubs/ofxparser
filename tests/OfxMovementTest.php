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
        $xml = simplexml_load_string('<OFX><TRNTYPE>DEBIT</TRNTYPE><FITID>123</FITID><MEMO>Alguma Descrição</MEMO><TRNAMT>123,99</TRNAMT><DTPOSTED>20160102</DTPOSTED></OFX>');
        $ofxMovement = new OfxMovement($xml);

        $this->assertInstanceOf(OfxMovement::class, $ofxMovement);

        $this->assertEquals('Alguma Descrição', $ofxMovement->getDescription());
        $this->assertEquals(123.99, $ofxMovement->getAmount());
        $this->assertInstanceOf(DateTime::class, $ofxMovement->getDueDate());
        $this->assertEquals('123', $ofxMovement->getDocument());
        $this->assertEquals('DEBIT', $ofxMovement->getType());
    }
}
