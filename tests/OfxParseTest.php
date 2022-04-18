<?php
namespace Adelarcubs\OFXParser;

use PHPUnit\Framework\TestCase;
use SimpleXMLElement;
use Adelarcubs\OFXParser\Ofx;
use Adelarcubs\OFXParser\OfxParser;
use Adelarcubs\OFXParser\OfxMovement;
use Adelarcubs\OFXParser\Exception\OfxParseException;

/**
 *
 * @author Adelar Tiemann Junior <adelar@adelarcubs.com>
 */
class OfxParseTest extends TestCase
{

    /**
     *
     * @test
     * @expectedException OfxParseException
     */
    public function wrongXmlFormat()
    {
        $this->expectException(OfxParseException::class);
        $ofx = OfxParser::loadOfx('<OFX><root></root></OFX>');
    }

    /**
     *
     * @test
     */
    public function itau()
    {
        $ofx = OfxParser::loadOfx(__DIR__ . '/fixtures/extrato_itau.ofx');
        $this->assertInstanceOf(Ofx::class, $ofx);
        // $this->assertIsString($ofx->jsonSerialize());

        $this->assertContainsOnlyInstancesOf(OfxMovement::class, $ofx->getMovements());
    }

    /**
     *
     * @test
     */
    public function santander()
    {
        $ofx = OfxParser::loadOfx(__DIR__ . '/fixtures/extrato_santander.ofx');
        $this->assertInstanceOf(Ofx::class, $ofx);
        // $this->assertInternalType('array', $ofx->jsonSerialize());

        $this->assertContainsOnlyInstancesOf(OfxMovement::class, $ofx->getMovements());
    }

    /**
     *
     * @test
     */
    public function caixa()
    {
        $ofx = OfxParser::loadOfx(__DIR__ . '/fixtures/extrato_caixa.ofx');
        $this->assertInstanceOf(Ofx::class, $ofx);
        // $this->assertInternalType('array', $ofx->jsonSerialize());

        $this->assertContainsOnlyInstancesOf(OfxMovement::class, $ofx->getMovements());
    }

    /**
     *
     * @test
     */
    public function faturaCC()
    {
        $ofx = OfxParser::loadOfx(__DIR__ . '/fixtures/fatura_cc_1.ofx');
        $this->assertInstanceOf(Ofx::class, $ofx);
        // $this->assertInternalType('array', $ofx->jsonSerialize());

        $this->assertContainsOnlyInstancesOf(OfxMovement::class, $ofx->getMovements());
    }

    /**
     *
     * @test
     */
    public function itauIso()
    {
        $ofx = OfxParser::loadOfx(__DIR__ . '/fixtures/extrato_itau_iso.ofx');
        $this->assertInstanceOf(Ofx::class, $ofx);
        // $this->assertInternalType('array', $ofx->jsonSerialize());

        $this->assertContainsOnlyInstancesOf(OfxMovement::class, $ofx->getMovements());
    }
}
