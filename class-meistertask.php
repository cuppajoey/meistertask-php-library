<?php

class taskMeister {

    /*
     *	Meistertask API key
     */
    protected $secretKey;

    /*
     *	Meistertask Tasks Endpoint
     */
    protected $endpointTasks;

    /*
     *	Meistertask Projects Endpoint
     */
    protected $endpointProjects;

    /*
     *	Meistertask Sections Endpoint
     */
    protected $endpointSections;

    /*
     *	Meistertask Project ID
     *	ID of a project board
     */
    protected $projectID;

    /*
     *	Meistertask Section ID
     *	ID of a section on a project board
     */
    protected $sectionID;


    public function __contruct () {
        $this->endpointTasks = 'https://www.meistertask.com/api/tasks';
        $this->endpointProjects = 'https://www.meistertask.com/api/projects';
        $this->endpointSections = 'https://www.meistertask.com/api/sections';
    }

    /*
     *	Set the meistertask api key
     *
     *	@access public
     *	@param	string	private api key
     */
    private function setSecretKey($key) {
        $this->secretKey = $key;
    }

    /*
     *	Set the id of the Meistertask project
     *
     *	@access public
     *	@param	string	id of the project board
     */
    public function setProjectID($id) {
        $this->projectID = $id;
    }

    /*
     *	Set the id of the project section
     *
     *	@access public
     *	@param	string	id of the section
     */
    public function setSectionID($id) {
        $this->projectID = $id;
    }

    /*
     *	Creates a task in selected board & section
     *
     *	@access public
     *	@param string $name the task title
     *	@param string $notes task notes/description
     *	@param int $assignedMemberID the id of the team member to assign this task
     *	@param array $labels task labels ids you want to apply to the task
     *	@param int $status the status of the task (1=open, 2=completed, 8=trashed, 18=completed_archived)
     */
    public function createTask($name, $notes, $assignedMemberID, $labels, $status = 1) {
        $data = array(
            'name' => $name,
            'notes' => $notes,
            'assigned_to_id' => $assignedMemberID,
            'label_ids' => $labels,
            'status' => $status
        );

        $payload = json_encode($data);
        $postURL = $this->endpointSections . '/' . $this->sectionID . '/tasks';

        // Prepare new cURL resource
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $postURL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

        // Set HTTP Header for POST request
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($payload),
            'Authorization: Bearer ' . $this->secretKey
        ));

        // $output contains the output string
        $result = curl_exec($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $output = '';

        if ($statusCode != 200) {
            $output = array(
                'status' => 'error',
                'message' => $result->error->message
            );
        } else {
            $output = array(
                'status' => 'success',
                'message' => 'Task was successfully created'
            );
        }

        // Close cURL session handle
        curl_close($ch);

        return $output;
    }

}
?>
