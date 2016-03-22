<?php
/**
 * NodeTrait.php
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
 * Trait used to handle tree node management
 *
 * All matrices used are 2x2. The array notation is done like this :
 *
 *  Matrix | a, b | is written in array [a, b, c, d]
 *         | c, d |
 *
 * @author Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2016 Philippe Gaultier
 * @license http://www.sweelix.net/license license
 * @version XXX
 * @link http://www.sweelix.net
 * @package sweelix\tree
 * @since XXX
 */
trait NodeTrait
{

    /**
     * @var string node path in dot notation
     */
    protected $nodePath;

    /**
     * @var array node path in matrix notation
     */
    protected $nodeMatrix;

    /**
     * @return string node path in dot notation
     * @since XXX
     */
    public function getPath()
    {
        return $this->nodePath;
    }

    /**
     * @param string $path node path in dot notation (1.1.2)
     * @return static
     * @since XXX
     */
    public function setPath($path)
    {
        $this->nodePath = $path;
        $this->nodeMatrix = Helper::convertPathToMatrix($path);
    }

    /**
     * @return array node path in matrix notation
     * @since XXX
     */
    public function getMatrix()
    {
        return $this->nodeMatrix;
    }

    /**
     * Create a node object from a matrix
     * @param array $matrix node path in matrix notation [a, b, c, d]
     * @return static
     * @since XXX
     */
    public function setMatrix($matrix)
    {
        if (is_array($matrix) === true) {
            $matrix = new Matrix($matrix);
        }
        $this->nodeMatrix = $matrix;
        $this->nodePath = Helper::convertMatrixToPath($matrix);

    }

    /**
     * @return float left border
     * @since XXX
     */
    public function getLeft()
    {
        return $this->nodeMatrix->a / $this->nodeMatrix->c;
    }

    /**
     * @return float right border
     * @since XXX
     */
    public function getRight()
    {
        return $this->nodeMatrix->b / $this->nodeMatrix->d;
    }

    /**
     * Check if we can perform selected move
     * @param string $fromPath original Path
     * @param string $toPath new Path
     * @return bool
     * @since XXX
     */
    public function canMove($fromPath, $toPath)
    {
        return (strncmp($fromPath, $toPath, strlen($fromPath)) !== 0);
    }

    /**
     * Move current node from one path to another
     * @param string $fromPath original Path
     * @param string $toPath new Path
     * @param int $bump offset if we need to re-key the path
     * @return boolean
     * @since XXX
     */
    public function move($fromPath, $toPath, $bump = 0)
    {
        // cannot move into self tree
        $status = $this->canMove($fromPath, $toPath);
        if($status === true) {
            $fromMatrix = Helper::convertPathToMatrix($fromPath);
            $toMatrix = Helper::convertPathToMatrix($toPath);
            $moveMatrix = Helper::buildMoveMatrix($fromMatrix, $toMatrix, $bump);
            $moveMatrix->multiply($this->nodeMatrix);
            $this->nodeMatrix = $moveMatrix;
            $this->nodePath = Helper::convertMatrixToPath($this->nodeMatrix);
        }
        return $status;
    }
    
}
