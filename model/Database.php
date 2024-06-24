<?php

/** TODO: Modify the database class to work with Workday's API instead of a JSON file. */

/**
 * Representation of the Database. 
 * 
 * The database class is used to represent the database that the application will be using. 
 * This class is a singleton class, meaning that only one instance of this class can be created
 * at a time. This is done to prevent multiple instances of the database from being created,
 * which could lead to inconsistencies in the data. 
 * 
 * The database class is responsible for loading the data from the database (in this case, a JSON file), 
 * and providing access to that data to the rest of the application. 
 * 
 * It's also responsible for handling any errors that may occur while loading the data,
 * such as file not found errors, or errors decoding the JSON data. 
 * 
 * The database class is used by the rest of the application to access the data in the database, 
 * and should be the only way that the application interacts with the database. 
 * 
 * It contains a private static instance variable, which holds the single instance of the database class, 
 * and a private db variable, which holds the data loaded from the database. 
 */
class Database
{
    private static $instance = null;
    private mixed $db;

    /**
     * Constructor for the Database class. 
     * 
     * The constructor is private to prevent multiple instances of the database class from being created. 
     * It takes a single parameter, the path to the JSON file containing the database data. This parameter
     * is required, and an exception is thrown if the file is not found, or if there is an error reading the file. 
     * The constructor loads the data, decodes it, and stores it in the db variable. 
     *      
     * @param string $filePath - The path to the JSON file containing the database data.
     * @throws \Exception - If the file is not found, or if there is an error reading the file.
     */
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

        if ($decodedJson === NULL) {
            throw new Exception("Failed to decode JSON data.");
        }

        if (!isset($decodedJson['Report_Entry'])) {
            throw new Exception("'Report_Entry' key not found in JSON data.");
        }

        $this->db = $decodedJson['Report_Entry'];
    }

    /**
     * Get the instance of the Database class. 
     * 
     * This method is used to get the single instance of the Database class. It takes a single parameter,
     * the path to the JSON file containing the database data, and returns the instance of the Database class. 
     * If an instance of the Database class has already been created, this method returns that instance. 
     * 
     * @param string $filePath - The path to the JSON file containing the database data.
     * @return Database - The instance of the Database class.
     */
    public static function getInstance(string $filePath): Database
    {
        if (self::$instance === NULL) {
            self::$instance = new Database($filePath);
        }
        return self::$instance;
    }

    /**
     * Get the data from the database.
     * 
     * This method is used to get the data from the database. It returns the data loaded from the database
     * as an array. 
     * 
     * @return mixed - The data loaded from the database.
     */
    public function getDB(): mixed
    {
        return $this->db;
    }
}

// The unique key values in the JSON file, faculty.json, are as follows:
//     [0] => Job_Family 
//     [1] => Employee_Type            
//     [2] => Business_Title           
//     [3] => Active_Status            
//     [4] => Preferred_Name           
//     [5] => Primary_Work_Email       
//     [6] => Legal_Name               
//     [7] => Job_Title                
//     [8] => Supervisory_Organization  
//     [9] => Time_Type                
//     [10] => Job_Classifications
//     [11] => Academic_Units
//     [12] => Primary_Work_Space X
//     [13] => Work_Phones X