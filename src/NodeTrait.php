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
     * Move current node from one path to another
     * @param $fromPath
     * @param $toPath
     * @param int $bump
     * @since XXX
     */
    public function move($fromPath, $toPath, $bump = 0)
    {
        $fromMatrix = Helper::convertPathToMatrix($fromPath);
        $toMatrix = Helper::convertPathToMatrix($toPath);
        $moveMatrix = Helper::buildMoveMatrix($fromMatrix, $toMatrix, $bump);
        $moveMatrix->multiply($this->nodeMatrix);
        $this->nodeMatrix = $moveMatrix;
        // $this->nodeMatrix = Matrix::multiplyMatrices($moveMatrix, $this->nodeMatrix);
        $this->nodePath = Helper::convertMatrixToPath($this->nodeMatrix);
    }
    
}
