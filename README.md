# An unnofficial PHP client library for the Meistertask API
When I started this project, I worked on a team that used MeisterTask for project management. Our team also had a couple side projects with their own websites and HTML forms to contact us. The traffic from these forms was irregular and the notifications were occasionally overlooked. 

To improve awareness and response to these notifications, I developed this library to automatically create a new task for each form submission.

## What is MeisterTask?
MeisterTask is an online project management tool with a Kanban board UI, similar to Trello, Asana, or Jira. Learn More on MeisterTask - [meistertask.com](https://meistertask.com)

## Library Features & Requirements
At this time, the only feature is to POST new tasks to a specific section of a Meistertask board. This library requires the following:
- An API access token registered with MeisterTask
- The MeisterTask Project ID for the board you want to work with
- The MeisterTask Section ID where you want to put tasks


## How to use this library
It's pretty simple, just download the class-meistertask.php file and require it in your project.

### Basic usage example

```php
<?php
// Load client library
require 'path/to/class-meistertask.php';

//Load Composer's autoloader
require 'vendor/autoload.php';


try {

    //Create an instance; passing `true` enables exceptions
    $task = new MeisterTask();

    // Set your api access token
    $task->setSecretKey('ACCESSTOKEN');

    // Set your MeisterTask project id
    $task->setProjectID('PROJECTID');

    // Set your MeisterTask section id
    $task->setSectionID('SECTIONID');

    // define the details of your task
    $taskTitle = 'Get a coffee';
    $taskNotes = 'Coffee is vital to complete other tasks. This should be given high priority';
    $assignedTeamMemberID = '5'; // optional
    $taskLabels = array('1', '4'); // optional
    $status = '1'; // optional defaults to 1 (1=open, 2=completed, 8=trashed, 18=completed_archived)

    // Create the task
    $task->createTask($taskTitle, $taskNotes, $assignedTeamMemberID, $taskLabels, $status);
} catch (Exception $e) {
    echo 'Task could not be created. ' . $e->getMessage();
}

```

## Future Roadmap
Moving forward, I would like to add more features to this library. Right now it only fits a small use case, but the MeisterTask API has much more support than just creating tasks. 

Here are a few basic methods that I want to add:
- Get Projects (all or by ID)
- Get Sections (all or by ID)
- Get Persons (all or by ID)
- Get Tasks (all or by ID)
- Update a Task
- Delete a Task

# Thanks for visiting
If you find this library interesting, or think you could use it if it had more features, let me know! I'm also open to accepting contributions if this project gains any traction. 