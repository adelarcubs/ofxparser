<?php
namespace Adelarcubs\OFXParser;

use PHPUnit_Framework_TestCase;
use SimpleXMLElement;
use Adelarcubs\OFXParser\Ofx;
use Adelarcubs\OFXParser\OfxParser;

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
        $a = new OfxParser('<OFX><root></rot></OFX>');
        $this->assertNull($a);
    }

    /**
     * @test
     * @dataProvider ofxDataProvider
     */
    public function parseDiferentOFxBankFile($file)
    {
        // $ofx = Ofx::loadFromFile($file);
        // $this->assertInstanceOf(Ofx::class, $ofx);
        $parser = new OfxParser($file);
        $this->assertInstanceOf(Ofx::class, $parser->getOfx());
    }

    public function ofxDataProvider()
    {
        return [
            [
                __DIR__ . '/fixtures/data.ofx'
            ],
            [
                __DIR__ . '/fixtures/data2.ofx'
            ],
            [
                __DIR__ . '/fixtures/caixa_julho.ofx'
            ],
            [
                __DIR__ . '/fixtures/extrato_itau_maio.ofx'
            ]
        ];
    }
}
