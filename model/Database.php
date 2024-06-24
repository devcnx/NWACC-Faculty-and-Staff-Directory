<?php

/** TODO: Modify the database class to work with Workday's API instead of a JSON file. */

class Database
{
    private static $instance = null;
    private mixed $db;

    private function __construct(string $filePath)
    {
        if (!file_exists($filePath)) {
            throw new Exception("File not found: " . $filePath);
        }

        $fileContents = file_get_contents($filePath);

        if ($fileContents === false) {
            throw new Exception("Failed to open file: " . $filePath);
        }

        $decodedJson = json_decode($fileContents, true);

        if ($decodedJson === null) {
            throw new Exception("Failed to decode JSON from file: " . $filePath);
        }

        if (!isset($decodedJson['Report_Entry'])) {
            throw new Exception("'Report_Entry' key not found in JSON data.");
        }

        $this->db = $decodedJson['Report_Entry'];
    }

    public static function getInstance(string $filePath): Database
    {
        if (self::$instance === NULL) {
            self::$instance = new Database($filePath);
        }
        return self::$instance;
    }

    public function getDB(): mixed
    {
        return $this->db;
    }
}

// Array
// (
//     [0] => Job_Family                -> Employee Details X
//     [1] => Employee_Type             -> Employee X
//     [2] => Business_Title            -> Employee Details X
//     [3] => Active_Status             -> Employee X
//     [4] => Preferred_Name            -> Employee X
//     [5] => Primary_Work_Email        -> Employee Details X
//     [6] => Legal_Name                -> Employee X
//     [7] => Job_Title                 -> Employee Details X
//     [8] => Supervisory_Organization  -> Employee Details X
//     [9] => Time_Type                 -> Employee Details X
//     [10] => Job_Classifications      -> Employee Details - Left out
//     [11] => Academic_Units
//     [12] => Primary_Work_Space X
//     [13] => Work_Phones X
// )