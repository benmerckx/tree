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
class MatrixTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test matrix creation
     * @since XXX
     */
    public function testMatrixCreate()
    {
        $matrix = new Matrix([0, 1, 1, 0]);
        $this->assertEquals(0, $matrix->a);
        $this->assertEquals(1, $matrix->b);
        $this->assertEquals(1, $matrix->c);
        $this->assertEquals(0, $matrix->d);
    }

    /**
     * Test determinant computation
     * @since XXX
     */
    public function testDeterminant()
    {
        $matrix = new Matrix([1, 2, 3, 4]);
        $this->assertEquals(-2, $matrix->getDeterminant());
        $matrix = new Matrix([1, 1, 1, 1]);
        $this->assertEquals(0, $matrix->getDeterminant());
    }

    /**
     * Test matrix multiplications (matrix * matrix) and (scalar * matrix)
     * @since XXX
     */
    public function testMatrixMultiply()
    {
        $matrix = new Matrix([0, 1, 1, 0]);
        $matrix->multiply(2);
        $this->assertEquals(0, $matrix->a);
        $this->assertEquals(2, $matrix->b);
        $this->assertEquals(2, $matrix->c);
        $this->assertEquals(0, $matrix->d);

        $matrix = new Matrix([1, 2, 3, 4]);
        $matrix->multiply(2);
        $this->assertEquals(2, $matrix->a);
        $this->assertEquals(4, $matrix->b);
        $this->assertEquals(6, $matrix->c);
        $this->assertEquals(8, $matrix->d);

        $identity = new Matrix([1, 0, 0, 1]);
        $identity->multiply($matrix);
        $this->assertEquals($identity->a, $matrix->a);
        $this->assertEquals($identity->b, $matrix->b);
        $this->assertEquals($identity->c, $matrix->c);
        $this->assertEquals($identity->d, $matrix->d);
        
        $matrix = new Matrix([1, 2, 3, 4]);
        $matrix2 = new Matrix([4, 3, 2, 1]);
        $matrix->multiply($matrix2);
        $this->assertEquals(8, $matrix->a);
        $this->assertEquals(5, $matrix->b);
        $this->assertEquals(20, $matrix->c);
        $this->assertEquals(13, $matrix->d);

    }

    /**
     * Test adjugate computation
     * @since XXX
     */
    public function testAdjugate()
    {
        $matrix = new Matrix([0, 1, 1, 0]);
        $matrix->adjugate();
        $this->assertEquals(0, $matrix->a);
        $this->assertEquals(-1, $matrix->b);
        $this->assertEquals(-1, $matrix->c);
        $this->assertEquals(0, $matrix->d);

        $matrix = new Matrix([1, 2, 3, 4]);
        $matrix->adjugate();
        $this->assertEquals(4, $matrix->a);
        $this->assertEquals(-2, $matrix->b);
        $this->assertEquals(-3, $matrix->c);
        $this->assertEquals(1, $matrix->d);

    }

    /**
     * Test inverse computation
     * @since XXX
     */
    public function testInverse()
    {
        $matrix = new Matrix([0, 1, 1, 0]);
        $matrix->inverse();
        $this->assertEquals(0, $matrix->a);
        $this->assertEquals(1, $matrix->b);
        $this->assertEquals(1, $matrix->c);
        $this->assertEquals(0, $matrix->d);

        $matrix = new Matrix([2, 3, 4, 5]);
        $matrix->inverse();
        $this->assertEquals(-5/2, $matrix->a);
        $this->assertEquals(3/2, $matrix->b);
        $this->assertEquals(2, $matrix->c);
        $this->assertEquals(-1, $matrix->d);

    }

    /**
     * Test transpose computation
     * @since XXX
     */
    public function testTranspose()
    {
        $matrix = new Matrix([0, 1, 1, 0]);
        $matrix->transpose();
        $this->assertEquals(0, $matrix->a);
        $this->assertEquals(1, $matrix->b);
        $this->assertEquals(1, $matrix->c);
        $this->assertEquals(0, $matrix->d);

        $matrix = new Matrix([1, 2, 3, 4]);
        $matrix->transpose();
        $this->assertEquals(1, $matrix->a);
        $this->assertEquals(3, $matrix->b);
        $this->assertEquals(2, $matrix->c);
        $this->assertEquals(4, $matrix->d);
    }

    /**
     * Test toArray serialization
     * @since XXX
     */
    public function testToArray()
    {
        $matrix = new Matrix([1, 2, 3, 4]);
        $matrix->transpose();
        $arrayMatrix = $matrix->toArray();
        $this->assertEquals(1, $arrayMatrix[0]);
        $this->assertEquals(3, $arrayMatrix[1]);
        $this->assertEquals(2, $arrayMatrix[2]);
        $this->assertEquals(4, $arrayMatrix[3]);

    }

}
