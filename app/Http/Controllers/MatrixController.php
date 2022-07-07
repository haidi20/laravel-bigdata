<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MatrixController extends Controller
{
    public $arrayOne = [];
    public $arrayTwo = [];

    public function index(){
        $M = request('M');
        $N = request("N");


        if(($M <= 3 || $M >= 100) || ( $N <= 3 || $N >= 100) ) return "M must range from more than 3 and less than 100";

        $this->generateMatrix($M, $N, "arrayOne");
        $this->generateMatrix($N, $M, "arrayTwo");

        $arrayOne = $this->arrayOne;
        $arrayTwo = $this->arrayTwo;

        return response()->json(compact("arrayOne", "arrayTwo"));
    }

    private function generateMatrix($row, $col, $array){
        $result = [];

        for ($genRow=0; $genRow < $row; $genRow++) {
            for ($genCol=0; $genCol < $col; $genCol++) {
                $result[$genRow][$genCol] = rand(4, 99);
            }
        }

        if($array == "arrayOne") $this->arrayOne = $result;
        if($array == "arrayTwo") $this->arrayTwo = $result;
    }
}
