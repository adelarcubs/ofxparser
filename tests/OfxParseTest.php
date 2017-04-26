<?php
namespace Adelarcubs\OFXParser;

use PHPUnit_Framework_TestCase;
use SimpleXMLElement;
use Adelarcubs\OFXParser\Ofx;
use Adelarcubs\OFXParser\OfxParser;
use Adelarcubs\OFXParser\OfxMovement;

/**
 *
 * @author Adelar Tiemann Junior <adelar@adelarcubs.com>
 */
class OfxParseTest extends PHPUnit_Framework_TestCase
{

    /**
     * @test
     * @expectedException Exception
     */
    public function wrongXmlFormat()
    {
        $ofx = OfxParser::loadOfx('<OFX><root></rot></OFX>');
        $this->assertNull($ofx);
    }

    /**
     * @test
     */
    public function itau()
    {
        $ofx = OfxParser::loadOfx(__DIR__ . '/fixtures/extrato_itau.ofx');
        $this->assertInstanceOf(Ofx::class, $ofx);
        $this->assertInternalType('array', $ofx->jsonSerialize());

        $this->assertContainsOnlyInstancesOf(OfxMovement::class, $ofx->getMovements());
    }

    /**
     * @test
     */
    public function santander()
    {
        $ofx = OfxParser::loadOfx(__DIR__ . '/fixtures/extrato_santander.ofx');
        $this->assertInstanceOf(Ofx::class, $ofx);
        $this->assertInternalType('array', $ofx->jsonSerialize());

        $this->assertContainsOnlyInstancesOf(OfxMovement::class, $ofx->getMovements());
    }

    /**
     * @test
     */
    public function caixa()
    {
        $ofx = OfxParser::loadOfx(__DIR__ . '/fixtures/extrato_caixa.ofx');
        $this->assertInstanceOf(Ofx::class, $ofx);
        $this->assertInternalType('array', $ofx->jsonSerialize());

        $this->assertContainsOnlyInstancesOf(OfxMovement::class, $ofx->getMovements());
    }

    /**
     * @test
     */
    public function faturaCC()
    {
        $ofx = OfxParser::loadOfx(__DIR__ . '/fixtures/fatura_cc_1.ofx');
        $this->assertInstanceOf(Ofx::class, $ofx);
        $this->assertInternalType('array', $ofx->jsonSerialize());

        $this->assertContainsOnlyInstancesOf(OfxMovement::class, $ofx->getMovements());
    }
}
