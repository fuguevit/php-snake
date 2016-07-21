<?php

declare (strict_types = 1);

namespace PhpSnake\Game;

use PhpSnake\Game\Board\Point;
use PhpSnake\Terminal\Char;

class Board
{
    /**
     * @var int
     */
    private $width;

    /**
     * @var int
     */
    private $height;

    /**
     * @var array
     */
    private $map;

    /**
     * @var Snake
     */
    private $snake;

    /**
     * @param int $width
     * @param int $height
     */
    public function __construct(int $width, int $height)
    {
        $this->width = $width;
        $this->height = $height;
        $this->snake = new Snake(intval($height/2), intval($width/2));

        $this->generateMap();
        $this->generateOutline();
        $this->applySnake();
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @return array
     */
    public function getMap()
    {
        return $this->map;
    }

    private function applySnake()
    {
        $this->applyPoint($this->snake->getHead());
        foreach ($this->snake->getTail() as $point) {
            $this->applyPoint($point);
        }
    }

    /**
     * @param Point $point
     */
    private function applyPoint(Point $point)
    {
        $this->map[$point->getRow()][$point->getCol()] = $point->getChar();
    }

    private function generateMap()
    {
        for ($i = 0; $i < $this->height; ++$i) {
            $this->map[$i] = array_fill(0, $this->width, ' ');
        }
    }

    private function generateOutline()
    {
        $this->map[0][0] = Char::boxTopLeft();
        $this->map[0][$this->width - 1] = Char::boxTopRight();

        $this->generateHLine(0, 1, $this->width-2, Char::boxHorizontal());
        $this->generateHLine($this->height - 1, 1, $this->width-2, Char::boxHorizontal());

        $this->generateVLine(0, 1, $this->height-2, Char::boxVertical());
        $this->generateVLine($this->width-1, 1, $this->height-2, Char::boxVertical());

        $this->map[$this->height - 1][0] = Char::boxBottomLeft();
        $this->map[$this->height - 1][$this->width - 1] = Char::boxBottomRight();
    }

    /**
     * @param int $row
     * @param int $start
     * @param int $cols
     * @param string $char
     */
    private function generateHLine(int $row, int $start, int $cols, string $char)
    {
        for ($i=0;$i<$cols;$i++) {
            $this->map[$row][$start+$i] = $char;
        }
    }

    /**
     * @param int $col
     * @param int $start
     * @param int $rows
     * @param string $char
     */
    private function generateVLine(int $col, int $start, int $rows, string $char)
    {
        for ($i=0;$i<$rows;$i++) {
            $this->map[$start+$i][$col] = $char;
        }
    }

}
