<?php
/**
 * class for the problem game of life
 */
class GameOfLife {

    //matrix variable
    private $dimension;
    private $currentGeneration = 0;
    private $matrix = array();
    private $nextGenerationMatrix = array();

    /**
     * params - dimension for the matrix 10*10 as default
     */
    public function __construct(int $dimension = 10) {
        $this->dimension = $dimension;
    }

    /**
     * true - current matrix
     * false - next generation matrix
     */
    public function createMatrix($current=true) {
        
        for ($i = 0; $i < $this->dimension; $i++) {
            for ($j = 0; $j < $this->dimension; $j++) {
                if ($current) {
                    $this->matrix[$i][$j] = 0;
                } else {
                    $this->nextGenerationMatrix[$i][$j] = 0;
                }
            }
        }
    }

    /**
     * seeds the initial data for the matrix 
     */
    public function seedData() {
        /*
        * This is one way adding the random values to the matrix. But, it will not ensure that the live cell present
         
        for($i = 0; $i<10; $i++) {
            $row = rand(1, $this->dimension - 1);
            $col = rand(1, $this->dimension - 1);
            $this->matrix[$row][$col] = 1;
        }
        */

        $c = (int)($this->dimension/2);
        $this->matrix[$c][$c + 1] = 1;
        $this->matrix[$c+1][$c + 2] = 1;
        $this->matrix[$c+2][$c] = 1;
        $this->matrix[$c+2][$c + 1] = 1;
        $this->matrix[$c+2][$c + 2] = 1;
    }

    /**
     * calculate the live cell for the passed position (row, col) in the matrix and return the count.
     */
    private function getLiveCount($row, $col) {
        $liveCount = 0;
        for ($i = $row - 1; $i <= $row + 1; $i++) {
            for ($j = $col - 1; $j <= $col+1; $j++) {
                if ($i == $row && $j == $col) {
                    continue;
                }
                if (isset($this->matrix[$i][$j]) && $this->matrix[$i][$j] == 1) {
                    ++$liveCount;
                }
            }
        }
        return $liveCount;
    }

    /**
     * creates the next generation matrix data by getting the live count of each position
     */
    public function createNextGeneration() {
        $this->createMatrix(false); //create matrix for next generation
        for ($x=0; $x < $this->dimension; $x++) {
            for ($y=0; $y < $this->dimension; $y++) {
                $liveCell = $this->matrix[$x][$y];
                $neighbour = $this->getLiveCount($x, $y);


                if($liveCell == 1 && ($neighbour == 2 || $neighbour == 3)) {
                    $this->nextGenerationMatrix[$x][$y] = 1;
                } else if ($liveCell == 0 and $neighbour == 3) {
                    $this->nextGenerationMatrix[$x][$y] = 1;
                }
            }
        }
        $this->matrix = $this->nextGenerationMatrix;

    }

    /**
     * display the matrix in the commandline
     */
    public function displayMatrix() {
        for ($i = 0; $i < $this->dimension; $i++) {
            for ($j = 0; $j < $this->dimension; $j++) {
                if ($this->matrix[$i][$j]) {
                    print '1';
                }
                else {
                    print '*';
                }
            } 
            echo "\n";
        }
    }
}

/**
 * Code execution starts here
 */
$gameOfLife = new GameOfLife();
$gameOfLife->createMatrix();
$gameOfLife->seedData();

$totalGeneration = 5; //total no of generation which needs to be created
for($i=1; $i <= $totalGeneration; $i++) {
    echo "Generation ".$i.":";
    echo "\n---------------------------------------\n";
    $gameOfLife->displayMatrix();
    echo "\n\n";
    $gameOfLife->createNextGeneration();   
}


