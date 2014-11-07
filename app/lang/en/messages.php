<?php
/** 
 *   To aid quick referencing, keep entries in the same section ALPHABETICALLY ORDERED
 */

return array(

    /** 
     *   Generic names
     */

    'actions' => 'Actions',
    'back' => 'Previous Page',
    'both' => 'Both',
    'cancel' => 'Cancel',
    'close' => 'Close',
    'create' => 'Create',
    'date-created' => 'Date Created',
    'delete' => 'Delete',
    'description' => 'Description',
    'edit' => 'Edit',
    'email' => 'Email',
    'female' => 'Female',
    'email-address' => 'Email Address',
    'gender' => 'Gender',
    'field-required' => 'This field is required',
    'full-name' => 'Full Name',
    'home' => 'Home',
    'image-alternative' => 'No photo available',
    'login' => 'Login',
    'male' => 'Male',
    'logout' => 'Logout',
    'name' => 'Name|Names',
    'next' => 'Next',
    'password' => 'Password|Passwords',
    'photo' => 'Photo',
    'role' => 'Role|Roles',
    'roles' => '',
    'save' => 'Save',
    'type' => 'Type',
    'unit' => 'Unit',
    'update' => 'Update',
    'user' => 'User|Users',
    'username' => 'Username',
    'view' => 'View',

    /** 
     *   Generic phrases
     */
    'confirm-delete-title' => 'Confirm Delete',
    'confirm-delete-message' => 'Do you wish to delete this item?',
    'confirm-delete-irreversible' => 'This action is irreversible.',

    /** 
     *   User
     */
    'create-user' => 'Create User',
    'change-password' => 'Change Password',
    'current-password' => 'Current Password',
    'designation' => 'Designation',
    'edit-user' => 'Edit User',
    'edit-user-details' => 'Edit User Details',
    'edit-profile' => 'Edit Profile',
    'failure-creating-user' => 'Failed to create user.',
    'incorrect-current-passord' => 'Incorrect \''.trans('validation.attributes.current_password').'\' Entered',
    'invalid-login' => 'Username and/or password invalid.',
    'new-password' => 'New Password',
    'new-user' => 'New User',
    'password-mismatch' => 'Passwords do not match',
    'repeat-password' => 'Retype Password',
    'reset-password' => 'Reset Password',
    'success-creating-user' => 'Successfully created the user!',
    'success-deleting-user' => 'The user was successfully deleted!',
    'user-details' => 'User Details',
    'user-profile-edit-success' => 'The user details were successfully updated!',

    /** 
     *  Patient
     */

    'age' => 'Age',
    'create-patient' => 'Create Patient',
    'date-created' => 'Registration Date',
    'date-of-birth' => 'Date of Birth',
    'date-registered' => 'Registration Date',
    'edit-patient' => 'Edit Patient',
    'edit-patient-details' => 'Edit Patient Details',
    'email-address' => 'Email Address',
    'external-patient-number' => 'External Patient Number',
    'list-patients' => 'List Patients',
    'new-patient' => 'New Patient',
    'patient' => 'Patient|Patients',
    'patient-details' => 'Patient Details',
    'patient-id' => 'ID',
    'patient-search-button' => 'Go!',
    'patient-number' => 'Patient Number',
    'phone-number' => 'Phone Number',
    'physical-address' => 'Physical Address',
    
    /** 
     *   Specimen
     */

    'accept-specimen' => 'Accept',
    'accept-specimen-title' => 'Accept Specimen',
    'change-specimen' => 'Change',
    'change-specimen-title' => 'Change Specimen Type',
    'create-specimen-type' => 'Create Specimen Type',
    'edit-specimen-type' => 'Edit Specimen Type',
    'list-specimen-types' => 'List Specimen Types',
    'new-specimen-type' => 'New Specimen Type',
    'reject' => 'Reject',
    'reject-explained-to' => 'Person Talked To',
    'reject-title' => 'Reject Specimen',
    'rejection-reason' => 'Reason',
    'rejection-reason-title' => 'Rejection Reason',
    'specimen' => 'Specimen',
    'specimen-accepted' => 'Accepted',
    'specimen-accepted-label' => 'Specimen Accepted',
    'specimen-details' => 'Specimen Details',
    'specimen-number' => 'ID',
    'specimen-number-title' => 'Specimen ID',
    'specimen-not-collected' => 'Not Collected',
    'specimen-not-collected-label' => 'Specimen Not Collected',
    'specimen-rejected' => 'Rejected',
    'specimen-rejected-label' => 'Specimen Rejected',
    'specimen-status' => 'Status',
    'specimen-type' => 'Type|Specimen Types',
    'specimen-type-details' => 'Specimen Type Details',
    'specimen-type-title' => 'Specimen Type',
    'success-rejecting-specimen' => 'The specimen was rejected!',
    'update' => 'Update',
    
    /** 
     *   Test Catalog
     */
    /*Measure*/
    'add-new-measure-range' => 'Add New Range',
    'agemax' => 'Age Max',
    'agemin' => 'Age Min',
    'create-measure' => 'Create Measure',
    'error-creating-measure' => 'Error occured while creating measure!',
    'edit-measure' => 'Edit Measure',
    'edit-measure-details' => 'Edit Measure Details',
    'failure-test-measure-in-use' => 'This Measure is in use',
    'freetext-measure-config-input-message' => 'A text box will appear for results entry',
    'list-measures' => 'List Measures',
    'measure' => 'Measure|Measures',
    'measure-age-range' => 'Age Range',
    'measure-details' => 'Measure Details',
    'measure-range' => 'Measure Range',
    'measure-range-values' => 'Range Values',
    'measure-type' => 'Measure Type',
    'new-measure' => 'New Measure',
    'rangemin' => 'Range Lower Limit',
    'rangemax' => 'Range Upper Limit',
    'save-measure' => 'Save Measure',
    'success-creating-measure' => 'Successfully created measure!',
    'success-deleting-measure' => 'Successfully deleted the Measure!',
    'success-updating-measure' => 'The measure details were successfully updated!',
    'update-measure' => 'Update Measure',

    /*Specimen Type*/

    'failure-specimen-type-in-use' => 'This Specimen Type is in use',
    'success-creating-specimen-type' => 'Successfully created specimen type!',
    'success-deleting-specimen-type' => 'Successfully deleted the Specimen Type!',
    'success-updating-specimen-type' => 'The specimen type details were successfully updated!',

    /*Specimen Rejection*/
    
    'add-rejection-reason' => 'Add New Rejection Reason',
    'edit-rejection-reason' => ' Edit Rejection Reason',
    'failure-specimen-rejection-reason-in-use' => 'This Rejection Reason is in Use',
    'specimen-rejection' => 'Specimen Rejection',
    'success-creating-rejection-reason' => 'Rejection Reason Successfully Created',
    'success-deleting-rejection-reason' => 'Rejection Reason Successfully Deleted',
    'success-updating-rejection-reason' => 'Rejection Reason Successfully Updated',

    /*Test Categories*/

    'create-test-category' => 'Create Lab Section',
    'edit-test-category' => 'Edit Lab Section',
    'failure-test-category-in-use' => 'This category is a group of Test Types in use',
    'success-creating-test-category' => 'Successfully created Lab Section.',
    'success-deleting-test-category' => 'Successfully deleted the Lab Section.',
    'success-updating-test-category' => 'The lab section was successfully updated!',
    'test-category' => 'Lab Section|Lab Sections',
    'test-category-details' => 'Lab Section Details',
    'list-test-categories' => 'List Lab Sections',

    /* Test Types*/

    'compatible-specimen' => 'Compatible Specimen',
    'create-test-type' => 'Create Test Type',
    'edit-test-type' => 'Edit Test Type',
    'failure-test-type-in-use' => 'This Test Type is in use',
    'list-test-types' => 'List Test Types',
    'new-test-type' => 'New Test Type',
    'prevalence-threshold' => 'Prevalence Threshold',
    'select-measures' => 'Select Measures',
    'select-specimen-types' => 'Select Specimen Types',
    'success-creating-test-type' => 'Successfully created Test Type.',
    'success-deleting-test-type' => 'The Test Type was successfully deleted.',
    'success-updating-test-type' => 'The Test Type details were successfully updated.',
    'target-turnaround-time' => 'Target Turnaround Time',
    'test-type' => 'Test Type|Test Types',
    'test-type-details' => 'Test Type Details',

    /**
     *  Tests
     */

    'all' => 'All',
    'create-new-test' => 'Create New Test',
    'completed' => 'Test Completed',
    'date-ordered' => 'Date Ordered',
    'first-select-patient' => 'First select a patient below',
    'in-patient' => 'In Patient',
    'interpretation' => 'Interpretation',
    'lab-receipt-date' => 'Lab Receipt Date',
    'list-tests' => 'Ordered Tests List',
    'new-test' => 'New Test',
    'not-received' => 'Test Not Received',
    'out-patient' => 'Out Patient',
    'patient-name' => 'Patient',
    'pending' => 'Test Pending',
    'physician' => 'Requesting Physician',
    'receive-test' => 'Receive',
    'receive-test-title' => 'Receive Test',
    'registered-by' => 'Registered By',
    'save-test' => 'Save Test Request',
    'select-tests' => 'Select Test(s)',
    'start-test' => 'Start',
    'start-test-title' => 'Start Test',
    'started' => 'Test Started',
    'success-creating-test' => 'Successfully created test!',
    'test' => 'Test|Tests',
    'test-catalog' => 'Test Catalog',
    'test-details' => 'Test Details',
    'test-phase' => 'Test Phase',
    'test-remarks' => 'Remarks',
    'test-status' => 'Test Status',
    'tested-by' => 'Performed By',
    'turnaround-time' => 'Turnaround Time',
    'unknown' => 'Unknown',
    'update-test-results' => 'Update Test Results',
    'verification-pending' => 'Verification Pending',
    'verified-by' => 'Verified By',
    'verified' => 'Test Verified',
    'verify' => 'Verify',
    'verify-title' => 'Verify Test Results',
    'view-details' => 'View',
    'view-details-title' => 'View Test Details',
    'visit-number' => 'Lab No.',
    'visit-type' => 'Visit Type',

    /** 
     *   Tests search panel
     */
    'empty-search' => 'Your search did not match any test record!',
    'from' => 'From',
    'search' => 'Search',
    'search-patient-placeholder' => 'Enter patient name or ID',
    'to' => 'To',


    /**
     *   Tests Results
     */
    'edit-test-results' => 'Edit Test Results',
    'enter-results' => 'Enter Results',
    'enter-results-title' => 'Enter Test Results',
    'enter-test-results' => 'Enter Test Results',
    'save-test-results' => 'Save Results',
    'success-saving-results' => 'The results successfully saved!',
    'test-results' => 'Results',

    /** 
     *   Access Controls
     */

    'access-controls' => 'Access Controls',
    'assign-roles' => 'Assign Roles',
    'assign-roles-to-users' => 'Assign roles to Users',
    'edit-role' => 'Edit Role',
    'new-role' => 'New Role',
    'no-permissions-found' => 'No permissions found',
    'no-roles-found' => 'No roles found',
    'no-users-found' => 'No Users found',
    'permission' => 'Permission|Permissions',
    'user-accounts' => 'User Accounts',

    /** 
     *   Reports
     */
    'aggregate-reports' => 'Aggregate Reports',
    'collected-by'  =>  'Collected By',
    'counts' => 'Counts',
    'daily-log' => 'Daily Log',
    'daily-reports' => 'Daily Reports',
    'date-checked'  =>  'Date Checked',
    'date-tested' => 'Date Tested',
    'date-verified' => 'Date Verified',
    'export-to-pdf' => 'Export to PDF',
    'export-to-word' => 'Export to Word',
    'hospital-number'   =>  'Hospital number',
    'include-pending-tests' => 'Include Pending Tests',
    'include-range-visualization' => 'Include Range Visualization',
    'infection-report' => 'Infection Report',
    'no-records-found' => 'No records found.',
    'patient-report' => 'Patient Report',
    'prevalence-rates' => 'Prevalence Rates',
    'print' => 'Print',
    'rejected-by'   =>  'Rejected by',
    'report' => 'Report|Reports',
    'requesting-facility-department' => 'Requesting Facility/Department',
    'results-entry-date' => 'Entry Date',
    'test-results-values' => 'Test:Result',
    'view-report' => 'View Report',


    /** 
     *   Configurations
     */
    'lab-configuration' => 'Lab Configuration',

    /** 
     *   Dates
     */
    'year' => 'Year|Years',
    'week' => 'Week|Weeks',
    'day' => 'Day|Days',
    'hour' => 'Hour|Hours',
    'minute' => 'Minute|Minutes',
    'second' => 'Second|Seconds',

);