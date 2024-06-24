<?php

require_once('./util/main.php');
require_once('./model/Database.php');
require('./model/Employee.php');

$db = Database::getInstance('./faculty.json');
$employees = $db->getDB();

$searchQuery = isset($_GET['search']) ? strtolower(trim($_GET['search'])) : '';

if ($searchQuery) {
    $employees = array_filter($employees, function ($employee) use ($searchQuery) {
        $employeeObj = new Employee($employee);
        $fields = [
            $employeeObj->preferredName,
            $employeeObj->legalName,
            $employeeObj->workPhones,
            $employeeObj->job->jobTitle,
            $employeeObj->job->jobDetails->jobFamily,
            $employeeObj->job->jobDetails->employeeType,
            $employeeObj->job->jobDetails->businessTitle,
            $employeeObj->job->jobDetails->activeStatus,
            $employeeObj->job->jobDetails->timeType,
            $employeeObj->job->jobDetails->academicUnits,
            $employeeObj->job->jobDetails->primaryWorkSpace,
        ];

        foreach ($fields as $field) {
            if (strpos(strtolower($field), $searchQuery) !== false) {
                return true;
            }
        }

        return false;
    });
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NWACC | Faculty & Staff Directory</title>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo $cssPath; ?>/style.css">

    <!-- Core Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="bg-light">

    <!-- Navigation for Searching via Text -->
    <nav class="navbar navbar-expand-lg fixed-top" style="background-color: #2C5334;">
        <div class="container-fluid">
            <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-nav" aria-controls="navbar-nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon text-white"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbar-nav">
                <form class="d-flex ms-auto w-75 justify-content-center align-items-center" method="GET" action="">
                    <input class="form-control me-2" type="search" placeholder="Enter search text here..." aria-label="Search" name="search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                    <button class="btn btn-outline-light" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Fixed Header -->
    <div class="container-fluid bg-light text-center py-2 sticky-top" style="top: 56px;">
        <h3 class="text-center text-uppercase fw-lighter">NWACC Faculty and Staff Directory</h3>
    </div>

    <!-- Faculty and Staff List -->
    <div class="container-fluid content-wrapper mt-5 p-2">
        <div class="row">

            <!-- Display each employee's information -->
            <?php
            foreach ($employees as $employee) {
                $employeeObj = new Employee($employee);
                $employeeObj->displayEmployee();
            }
            ?>

        </div>
    </div>

    <!--  Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>

</html>