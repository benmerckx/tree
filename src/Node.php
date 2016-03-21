<?php
/**
 * Node.php
 *
 * PHP version 5.6+
 *
 * @author Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2016 Philippe Gaultier
 * @license http://www.sweelix.net/license license
 * @version XXX
 * @link http://www.sweelix.net
 * @package sweelix\tree
 */

namespace sweelix\tree;

/**
 * Node minimalist class to use the trait
 *
 * @author Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2016 Philippe Gaultier
 * @license http://www.sweelix.net/license license
 * @version XXX
 * @link http://www.sweelix.net
 * @package sweelix\tree
 * @since XXX
 */
class Node
{
    use NodeTrait;

    /**
     * @param string $path node path in dot notation (1.1.2)
     * @return static
     * @since XXX
     */
    public static function createFromPath($path)
    {
        $node = new static();
        $node->nodePath = $path;
        $node->nodeMatrix = Helper::convertPathToMatrix($path);
        return $node;
    }

    /**
     * Create a node object from a matrix
     * @param array $matrix node path in matrix notation [a, b, c, d]
     * @return static
     * @since XXX
     */
    public static function createFromMatrix($matrix)
    {
        $node = new static();
        if (is_array($matrix) === true) {
            $matrix = new Matrix($matrix);
        }
        $node->nodeMatrix = $matrix;
        $node->nodePath = Helper::convertMatrixToPath($matrix);
        return $node;
    }
}
