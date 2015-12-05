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
        // $this->ofx = new Ofx(new SimpleXMLElement('fixtures/data.ofx'));
        $this->ofx = Ofx::loadFromFile(__DIR__ . '/fixtures/data.ofx');
    }

    /**
     * @test
     */
    public function constructorShouldConfigureAttributes()
    {
        $this->assertInstanceOf(Ofx::class, $this->ofx);
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    public function invalidFile()
    {
        Ofx::loadFromFile('Anywhere');
    }
}
