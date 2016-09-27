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
        $ofx = OfxParser::loadOfx('<OFX><root></rot></OFX>');
        $this->assertNull($ofx);
    }

    /**
     * @test
     * @dataProvider ofxDataProvider
     */
    public function parseDiferentOFxBankFile($file)
    {
        // $ofx = Ofx::loadFromFile($file);
        // $this->assertInstanceOf(Ofx::class, $ofx);
        $ofx = OfxParser::loadOfx($file);
        $this->assertInstanceOf(Ofx::class, $ofx);
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
