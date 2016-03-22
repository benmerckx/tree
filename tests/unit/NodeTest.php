<?php
/**
 * NodeTest.php
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
use sweelix\tree\Node;
use PHPUnit_Framework_TestCase;

/**
 * Test node basic functions
 *
 * @author Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2016 Philippe Gaultier
 * @license http://www.sweelix.net/license license
 * @version XXX
 * @link http://www.sweelix.net
 * @package tests\unit
 * @since XXX
 */
class NodeTest extends PHPUnit_Framework_TestCase
{

    /**
     * Test node creation from path
     * @since XXX
     */
    public function testCreateFromPath()
    {
        $node = Node::createFromPath('5.6.7');
        $this->assertInstanceOf('sweelix\tree\Node', $node);
        $matrix = $node->getMatrix();
        $this->assertEquals(370, $matrix->a);
        $this->assertEquals(417, $matrix->b);
        $this->assertEquals(63, $matrix->c);
        $this->assertEquals(71, $matrix->d);
        $this->assertGreaterThan($node->getLeft(), $node->getRight());

        $node = new Node();
        $node->setPath('5.6.7');
        $matrix = $node->getMatrix();
        $this->assertEquals(370, $matrix->a);
        $this->assertEquals(417, $matrix->b);
        $this->assertEquals(63, $matrix->c);
        $this->assertEquals(71, $matrix->d);
        $this->assertGreaterThan($node->getLeft(), $node->getRight());
    }

    /**
     * Test node creation from matrix
     * @since XXX
     */
    public function testCreateFromMatrix()
    {
        $node = Node::createFromMatrix([
            370, 417,
            63, 71,
        ]);
        $this->assertInstanceOf('sweelix\tree\Node', $node);
        $this->assertEquals('5.6.7', $node->getPath());
        $this->assertGreaterThan($node->getLeft(), $node->getRight());

        $node = new Node();
        $node->setMatrix([
            370, 417,
            63, 71,
        ]);
        $this->assertInstanceOf('sweelix\tree\Node', $node);
        $this->assertEquals('5.6.7', $node->getPath());
        $this->assertGreaterThan($node->getLeft(), $node->getRight());

        $matrix = new Matrix([
            370, 417,
            63, 71,
        ]);
        $node = new Node();
        $node->setMatrix($matrix);
        $this->assertInstanceOf('sweelix\tree\Node', $node);
        $this->assertEquals('5.6.7', $node->getPath());
        $this->assertGreaterThan($node->getLeft(), $node->getRight());
    }

    /**
     * Test if we can move a node
     * @since XXX
     */
    public function testMoveNode()
    {
        $node = Node::createFromPath('1.3.1');
        $node->move('1.3', '1.2');
        $this->assertEquals('1.2.1', $node->getPath());

        // move node from 5.6.7.1 to 3.6.7.1
        $node = Node::createFromPath('5.6.7.1');
        $node->move('5.6', '3.6');
        $this->assertEquals('3.6.7.1', $node->getPath());

        $node = Node::createFromPath('5.6.7.1');
        $node->move('5.6', '3.6', 1);
        $this->assertEquals('3.6.8.1', $node->getPath());

        $node = Node::createFromPath('5.6.7.1');
        $node->move('5.6', '3.6', -1);
        $this->assertEquals('3.6.6.1', $node->getPath());

        $node = Node::createFromPath('1.1.2');
        $this->assertFalse($node->canMove('1.1', '1.1.1'));
        $this->assertFalse($node->move('1.1', '1.1.1', 0));
        $this->assertTrue($node->canMove('1.1', '1.3'));
        $this->assertTrue($node->move('1.1', '1.3', 0));

    }
}
