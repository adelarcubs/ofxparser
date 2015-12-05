<?php
namespace Adelarcubs\OFXParser\Unit;

use PHPUnit_Framework_TestCase;
use SimpleXMLElement;
use Adelarcubs\OFXParser\Ofx;

/**
 *
 * @author Adelar Tiemann Junior <adelar@adelarcubs.com>
 */
class OfxTest extends PHPUnit_Framework_TestCase
{

    private $ofx;

    protected function setUp()
    {
        $this->ofx = Ofx::loadFromFile(__DIR__ . '/../fixtures/data.ofx');
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
