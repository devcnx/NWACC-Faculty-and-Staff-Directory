<?php

/**
 * Representation of a job's details for an employee. 
 * 
 * The JobDetails class is used to represent the details of a job for an employee. It contains the job family, employee 
 * type, business title, active status, supervisory organization, time type, job classifications, academic units, 
 * primary work space, and primary work email. The properties are set to null by default, and the constructor sets the
 * properties to the values in the data array if they exist. 
 * 
 * @property ?string $jobFamily - The job family.
 * @property ?string $employeeType - The employee type (e.g., Regular, Provisional, etc.).
 * @property ?string $businessTitle - The business title for the job.
 * @property ?string $activeStatus - The active status of the employee in the job.
 * @property ?string $supervisoryOrganization - The supervisory organization for the job.
 * @property ?string $timeType - The time type for the job (e.g., Full-Time, Part-Time, etc.).
 * @property ?string $jobClassifications - The job classifications.
 * @property ?string $academicUnits - The academic units.
 * @property ?string $primaryWorkSpace - The primary work space.
 * @property ?string $primaryWorkEmail - The primary work email.
 * 
 * @method __construct - Constructs a new JobDetails object.
 * @method getSupervisor - Gets the supervisor from the supervisory organization.
 * @method getSupervisoryOrganization - Gets the supervisory organization.
 * @method getJobClassifications - Gets the job classifications.
 * @method getAcademicUnits - Gets the academic units.
 */
class JobDetails
{
    public ?string $jobFamily;
    public ?string $employeeType;
    public ?string $businessTitle;
    public ?string $activeStatus;
    public ?string $supervisoryOrganization;
    public ?string $timeType;
    public ?string $jobClassifications;
    public ?string $academicUnits;
    public ?string $primaryWorkSpace;
    public ?string $primaryWorkEmail;

    /**
     * Constructs a new JobDetails object.
     * 
     * The constructor sets the properties to the values in the data array if they exist. If any of the properties do
     * not exist in the data array, they are set to 'N/A' by default. 
     *
     * @param array $data - The data array containing the job details.
     * 
     * @return void
     */
    public function __construct($data)
    {
        $this->jobFamily = $data['Job_Family'] ?? 'N/A';
        $this->employeeType = $data['Employee_Type'] ?? 'N/A';
        $this->businessTitle = $data['Business_Title'] ?? 'N/A';
        $this->activeStatus = $data['Active_Status'] ?? 'N/A';
        $this->supervisoryOrganization = $data['Supervisory_Organization'] ?? 'N/A';
        $this->timeType = $data['Time_Type'] ?? 'N/A';
        $this->jobClassifications = $data['Job_Classifications'] ?? 'N/A';
        $this->academicUnits = $data['Academic_Units'] ?? 'N/A';
        $this->primaryWorkSpace = $data['Primary_Work_Space'] ?? 'N/A';
        $this->primaryWorkEmail = $data['Primary_Work_Email'] ?? 'N/A';
    }

    /**
     * Gets the supervisor from the supervisory organization. 
     * 
     * The getSupervisor method is used to extract the supervisor from the supervisory organization. It uses a regular
     * expression to match the supervisor's name in parentheses. If the supervisor has '(Private' in their name, it is
     * removed. If the supervisor is not found, 'N/A' is returned. 
     * 
     * @return string - The supervisor's name. 
     */
    public function getSupervisor(): string
    {
        $pattern = '/\((.*?)\)/';
        preg_match($pattern, $this->supervisoryOrganization, $matches);
        if (strpos($matches[1], '(Private') !== false) {
            return str_replace('(Private', '', $matches[1]);
        }
        return $matches[1] ?? 'N/A';
    }

    /**
     * Gets the supervisory organization.
     * 
     * The getSupervisoryOrganization method is used to extract the supervisory organization from the full supervisory
     * organization string. It uses a regular expression to match the organization name before the opening parenthesis.
     * If the organization is not found, 'N/A' is returned.
     *
     * @return string - The supervisory organization.
     */
    public function getSupervisoryOrganization(): string
    {
        try {
            $pattern = '/(.*?)\(/';
            preg_match($pattern, $this->supervisoryOrganization, $matches);
            return $matches[1] ?? 'N/A';
        } catch (Exception $e) {
            return 'N/A';
        }
    }

    /**
     * Gets the job classifications.
     * 
     * The getJobClassifications method is used to extract the job classifications from the full job classifications
     * string. It splits the string by semicolons and then joins the array elements with a comma and space. If the job
     * classifications are not found, 'N/A' is returned. 
     * 
     * @return string - The job classifications.
     */
    public function getJobClassifications(): string
    {
        $jobClassifications = explode(';', $this->jobClassifications);
        return implode(', ', $jobClassifications);
    }

    /**
     * Gets the academic units.
     * 
     * The getAcademicUnits method is used to extract the academic units from the full academic units string. It splits
     * the string by semicolons and then joins the array elements with a comma and space. If the academic units are not
     * found, 'N/A' is returned. 
     *
     * @return string - The academic units.
     */
    public function getAcademicUnits(): string
    {
        $academicUnits = explode(';', $this->academicUnits);
        return implode(', ', $academicUnits);
    }
}
