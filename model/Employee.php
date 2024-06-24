<?php

require_once('Job.php');


/**
 * Representation of an employee. 
 * 
 * The Employee class is used to represent an employee. It contains the employee's preferred name, legal name, work phones, and job details. The properties are set to null by default, and the constructor sets the properties to the 
 * values in the data array if they exist. The setPreferredNameID method is used to set the preferred name ID, which is
 * used to create a unique ID for the employee. This is done by replacing any spaces with underscores, converting the
 * string to lowercase, and removing any non-alphanumeric characters. The displayEmployee method is used to display the
 * employee's information in an accordion format. The displayDetail method is used to display a single detail, such as
 * the legal name or work phone, and displayDetails is used is used to display all the details of the employee. 
 * 
 * @property ?string $preferredName - The employee's preferred name. 
 * @property ?string $legalName - The employee's legal name. 
 * @property ?string $workPhones - The employee's work phones.
 * @property ?Job $job - The employee's job details.
 * 
 * @method __construct - Constructs a new Employee object.
 * @method setPreferredNameID - Sets the preferred name ID.
 * @method displayEmployee - Displays the employee's information in an accordion format.
 * @method displayDetail - Displays a single detail.
 * @method displayDetails - Displays all the details of the employee.
 */
class Employee
{
    public ?string $preferredName;
    public ?string $legalName;
    public ?string $workPhones;
    public ?Job $job;

    /**
     * Constructs a new Employee object.
     * 
     * The constructor sets the properties to the values in the data array if they exist. If any of the properties do
     * not exist in the data array, they are set to 'N/A' by default. 
     *
     * @param array $data - The data array containing the employee's information. 
     * 
     * @return void
     */
    public function __construct($data)
    {
        $this->preferredName = $data['Preferred_Name'] ?? 'N/A';
        $this->legalName = $data['Legal_Name'] ?? 'N/A';
        $this->workPhones = $data['Work_Phones'] ?? 'N/A';
        $this->job = new Job($data);
    }

    /**
     * Sets the preferred name ID (used to create a unique ID for the employee). 
     * 
     * The setPreferredNameID method is used to set the preferred name ID, which is used to create a unique ID for the
     * employee. This is done by replacing any spaces with underscores, converting the string to lowercase, and removing
     * any non-alphanumeric characters. This is used in the HTML for the accordion ID. 
     * 
     * @param string $preferredName - The employee's preferred name.
     * 
     * @return string - The preferred name ID. 
     */
    public function setPreferredNameID($preferredName)
    {
        return str_replace(' ', '_', strtolower(preg_replace('/[^A-Za-z0-9\-]/', '', $preferredName)));
    }

    /**
     * Displays the employee's information in an accordion format. 
     * 
     * The displayEmployee method is used to display the employee's information in an accordion format. It uses the
     * preferred name ID to create a unique ID for the accordion. The employee's preferred name, job title, employee 
     *  type, time type, and supervisory organization are displayed in the accordion header. The employee's legal name, 
     * title, work phones, primary work email, job classifications, division, primary work space, and supervisor are 
     * displayed in the accordion body. 
     * 
     * @return void
     */
    public function displayEmployee()
    {
        $id = $this->setPreferredNameID($this->preferredName);
?>
        <div class="accordion accordion-flush" id="accordion-<?php echo $id; ?>">
            <div class="accordion-item border border-bottom">
                <h2 class="accordion-header" id="heading-<?php echo $id; ?>">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo $id; ?>" aria-expanded="false" aria-controls="collapse-<?php echo $id; ?>">
                        <div class="container-fluid p-0">
                            <div class="row w-100 m-0 p-0 text-uppercase">
                                <span class="col-3 text-start"><?php echo $this->preferredName; ?></span>
                                <small class="col-5 text-center text-muted">
                                    <?php echo $this->job->jobTitle ?? 'N/A'; ?>
                                    <?php echo ' (' . $this->job->jobDetails->employeeType . ' - ' . $this->job->jobDetails->timeType . ')'; ?>
                                </small>
                                <small class="col-4 text-end text-muted"><?php echo $this->job->jobDetails->getSupervisoryOrganization() ?? 'N/A'; ?></small>
                            </div>
                        </div>
                    </button>
                </h2>
                <div id="collapse-<?php echo $id; ?>" class="accordion-collapse collapse" aria-labelledby="heading-<?php echo $id; ?>" data-bs-parent="#accordion-<?php echo $id; ?>">
                    <div class="accordion-body p-4 w-100">
                        <small class="m-0 p-0">
                            <?php $this->displayDetails(); ?>
                        </small>
                    </div>
                </div>
            </div>
        </div>
<?php
    }

    /**
     * Displays a single detail. 
     * 
     * The displayDetail method is used to display a single detail, such as the legal name or work phone. If the value
     * is not 'N/A', it is displayed in a paragraph tag with a strong tag for the label. If the value is a link (e.g., 
     * an email address), it is displayed as a link. 
     * 
     * @param string $label - The label for the detail. 
     * @param string $value - The value of the detail. 
     * @param bool $isLink - Whether the value is a link. 
     * 
     * @return void
     */
    private function displayDetail($label, $value, $isLink = false)
    {
        if ($value && $value !== 'N/A') {
            echo '<p class="m-0 p-0"><strong>' . $label . ': </strong>';
            if ($isLink) {
                echo '<a href="mailto:' . $value . '">' . $value . '</a>';
            } else {
                echo $value;
            }
            echo '</p>';
        }
    }

    /**
     * Displays all the details of the employee. 
     * 
     * The displayDetails method is used to display all the details of the employee. It calls the displayDetail method 
     * for each detail, such as the legal name, title, work phones, primary work email, job classifications, division,
     * primary work space, and supervisor. 
     * 
     * @return void
     */
    private function displayDetails()
    {
        $this->displayDetail('Legal Name', $this->legalName);
        $this->displayDetail('Title', $this->job->jobDetails->businessTitle);
        $this->displayDetail('Work Phone(s)', $this->workPhones);
        $this->displayDetail('Primary Work Email', $this->job->jobDetails->primaryWorkEmail, true);
        $this->displayDetail('Job Classifications', $this->job->jobDetails->getJobClassifications());
        $this->displayDetail('Division', $this->job->jobDetails->academicUnits);
        $this->displayDetail('Primary Work Space', $this->job->jobDetails->primaryWorkSpace);
        $this->displayDetail('Supervisor', $this->job->jobDetails->getSupervisor());
    }
}
?>