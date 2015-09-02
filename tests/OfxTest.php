<?php
namespace Adelarcubs\OFXParser;

use PHPUnit_Framework_TestCase;
use SimpleXMLElement;

/**
 *
 * @author Adelar Tiemann Junior <adelar@adelarcubs.com>
 */
class OfxTest extends PHPUnit_Framework_TestCase
{
    private $ofx;

    protected function setUp()
    {
        $this->ofx = new Ofx(new SimpleXMLElement('<xml></xml>'));
    }

    /**
     * @test
     */
    public function constructorShouldConfigureAttributes()
    {
        $this->assertInstanceOf(Ofx::class, $this->ofx);
    }
}
