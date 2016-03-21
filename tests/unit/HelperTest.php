<?php
/**
 * MatrixTest.php
 *
 * PHP version 5.6+
 *
 * @author Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2016 Philippe Gaultier
 * @license http://www.sweelix.net/license license
 * @version XXX
 * @link http://www.sweelix.net
 * @package tests\unit
 */

namespace tests\unit;

use sweelix\tree\Matrix;
use sweelix\tree\Helper;
use sweelix\tree\InvalidSegmentException;
use PHPUnit_Framework_TestCase;

/**
 * Test matrix basic functions
 *
 * @author Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2016 Philippe Gaultier
 * @license http://www.sweelix.net/license license
 * @version XXX
 * @link http://www.sweelix.net
 * @package tests\unit
 * @since XXX
 */
class HelperTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test last path segment computation
     * @since XXX
     */
    public function testLastSegment()
    {
        $lastSegment = Helper::getLastSegment('3.2.2');
        $this->assertEquals(2, $lastSegment);

        $pathMatrix = new Matrix([
            370, 417,
            63, 71,]
        );
        $this->assertEquals(7, Helper::getLastSegment($pathMatrix));
    }

    /**
     * Test building segment tools
     * @since XXX
     * @throws InvalidSegmentException
     */
    public function testBuildSegment()
    {
        $segmentMatrix = Helper::buildSegmentMatrix(2);
        $this->assertEquals(1, $segmentMatrix->a);
        $this->assertEquals(1, $segmentMatrix->b);
        $this->assertEquals(2, $segmentMatrix->c);
        $this->assertEquals(3, $segmentMatrix->d);

        $this->expectException(InvalidSegmentException::class);
        $segmentMatrix = Helper::buildSegmentMatrix(-1);
    }

    /**
     * Test bump matrix build
     * @since XXX
     */
    public function testBumpMatrix()
    {
        $bumpMatrix = Helper::buildBumpMatrix(2);
        $this->assertEquals(1, $bumpMatrix->a);
        $this->assertEquals(0, $bumpMatrix->b);
        $this->assertEquals(2, $bumpMatrix->c);
        $this->assertEquals(1, $bumpMatrix->d);

    }

    /**
     * Test parent matrix extraction
     * @since XXX
     */
    public function testParentMatrix()
    {
        $pathMatrix = new Matrix([
                370, 417,
                63, 71,]
        );
        $parentMatrix = Helper::extractParentMatrixFromMatrix($pathMatrix);

        $this->assertEquals(41, $parentMatrix->a);
        $this->assertEquals(47, $parentMatrix->b);
        $this->assertEquals(7, $parentMatrix->c);
        $this->assertEquals(8, $parentMatrix->d);

    }

    /**
     * test converting path to matrix
     * @since XXX
     */
    public function testConvertPathToMatrix()
    {
        $matrix = Helper::convertPathToMatrix('5.6.7');
        $this->assertEquals(370, $matrix->a);
        $this->assertEquals(417, $matrix->b);
        $this->assertEquals(63, $matrix->c);
        $this->assertEquals(71, $matrix->d);
    }

    /**
     * test converting matrix to path
     * @since XXX
     */
    public function testConvertMatrixToPath()
    {
        $matrix = new Matrix([370, 417, 63, 71]);
        $path = Helper::convertMatrixToPath($matrix);
        $this->assertEquals('5.6.7', $path);
    }

    /**
     * test move matrix creation
     * @since XXX
     */
    public function testBuildMoveMatrix()
    {
        // 1.3
        $fromMatrix = new Matrix([7, 9, 4, 5]);
        // 1.2
        $toMatrix = new Matrix([5, 7, 3, 4]);
        $bump = 1;
        $moveMatrix = Helper::buildMoveMatrix($fromMatrix, $toMatrix, $bump);
        $this->assertEquals(-32, $moveMatrix->a);
        $this->assertEquals(59, $moveMatrix->b);
        $this->assertEquals(-19, $moveMatrix->c);
        $this->assertEquals(35, $moveMatrix->d);
    }

}
