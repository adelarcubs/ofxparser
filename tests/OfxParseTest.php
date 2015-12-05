<?php
namespace Adelarcubs\OFXParser;

use PHPUnit_Framework_TestCase;
use SimpleXMLElement;
use Adelarcubs\OFXParser\Ofx;

/**
 *
 * @author Adelar Tiemann Junior <adelar@adelarcubs.com>
 */
class OfxParseTest extends PHPUnit_Framework_TestCase
{

    /**
     * @test
     * @dataProvider ofxDataProvider
     */
    public function parseDiferentOFxBankFile($file)
    {
        $ofx = Ofx::loadFromFile($file);
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
            ]
        ];
    }
}
