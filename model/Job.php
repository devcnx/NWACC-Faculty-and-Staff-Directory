<?php

require_once('JobDetails.php');

/**
 * Representation of a job for an employee. 
 * 
 * The Job class is used to represent a job for an employee. It contains the job title and job details. The properties
 * are set to null by default, and the constructor sets the properties to the values in the data array if they exist. 
 * 
 * @property ?string $jobTitle - The job title.
 * @property ?JobDetails $jobDetails - The job details.
 * 
 * @method __construct - Constructs a new Job object.
 */
class Job
{
    public ?string $jobTitle;
    public ?JobDetails $jobDetails;

    /**
     * Constructs a new Job object. 
     * 
     * The constructor sets the properties to the values in the data array if they exist. If the job title does not 
     * exist in the data array, it is set to 'N/A' by default. The job details are set to a new JobDetails object. 
     * 
     * @param array $data - The data array containing the job information. 
     * 
     * @return void
     */
    public function __construct($data)
    {
        $this->jobTitle = $data['Job_Title'] ?? 'N/A';
        $this->jobDetails = new JobDetails($data);
    }
}
