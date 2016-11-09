<?php

namespace App\Utils;

///Class to parse lead data CSV 2d array
interface ICsvParser {
    ///Method to parse a CSV into an assosiative array data model
    public function parse(/*string*/ $leadCsv);
}
