<?php
/**
 * Helper.php
 *
 * PHP version 5.4+
 *
 * @author pgaultier
 * @copyright 2010-2016 Ibitux
 * @license http://www.ibitux.com/license license
 * @version XXX
 * @link http://www.ibitux.com
 */

namespace sweelix\tree;

/**
 * Helper class to ease node creation / management
 *
 * @author Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2016 Philippe Gaultier
 * @license http://www.sweelix.net/license license
 * @version XXX
 * @link http://www.sweelix.net
 * @package sweelix\tree
 * @since XXX
 */
class Helper
{
    // MatrixNode helpers

    public static function buildMoveMatrix(Matrix $fromMatrix, Matrix $toMatrix, $bump = 0)
    {
        $from = clone $fromMatrix;
        $to = clone $toMatrix;
        $from->adjugate();
        $from->multiply(-1);
        $bumpMatrix = self::buildBumpMatrix($bump);
        $to->multiply($bumpMatrix);
        $to->multiply($from);
        return $to;
    }

    /**
     * @param string $path path in dot notation
     * @return array matrix notation
     * @since XXX
     */
    public static function convertPathToMatrix($path)
    {
        $matrix = new Matrix([
            0, 1,
            1, 0,
        ]);
        $nodePath = explode('.', $path);
        foreach ($nodePath as $segment) {
            $matrix->multiply(self::buildSegmentMatrix($segment));
        }
        return $matrix;
    }

    /**
     * @param array $matrix path in matrix notation
     * @return string dot notation
     * @since XXX
     */
    public static function convertMatrixToPath(Matrix $matrix)
    {
        $nodePath = [];
        $currentMatrix = clone $matrix;
        do {
            $nodePath[] = self::getLastSegment($currentMatrix);
            $currentMatrix = self::extractParentMatrixFromMatrix($currentMatrix);
        } while ($currentMatrix !== null);
        $nodePath = array_reverse($nodePath);
        return implode('.', $nodePath);
    }

    /**
     * Extract parent matrix from matrix. null if current matrix is root
     * @param array $matrix
     * @return array|null
     * @since XXX
     */
    public static function extractParentMatrixFromMatrix(Matrix $matrix)
    {
        $parentMatrix = null;
        if (($matrix->c > 0) && ($matrix->d > 0)) {
            $leafMatrix = self::buildSegmentMatrix(self::getLastSegment($matrix));
            $leafMatrix->inverse();
            $matrix->multiply($leafMatrix);
            if ($matrix->a > 0) {
                $parentMatrix = $matrix;
            }
        }
        return $parentMatrix;
    }

    public static function getLastSegment($element)
    {
        if ($element instanceof Matrix) {
            $lastSegment = (int) ($element->a / ($element->b - $element->a));
        } else {
            $path = explode('.', $element);
            $lastSegment = end($path);
        }
        return $lastSegment;
    }

    public static function buildSegmentMatrix($segment)
    {
        if ($segment <= 0) {
            throw new InvalidSegmentException();
        }
        return new Matrix([
            1, 1,
            $segment, $segment + 1,
        ]);
    }

    public static function buildBumpMatrix($offset = 0)
    {
        return new Matrix([
            1, 0,
            $offset, 1,
        ]);
    }
}