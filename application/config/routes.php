<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'PageController';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Pages
$route['login'] = 'PageController/login';
$route['logout'] = 'PageController/logout';
$route['recovery-password'] = 'PageController/recoveryPassword';

$route['reset-password/(:any)'] = 'PageController/resetPassword/$1';
$route['dashboard'] = 'PageController/dashboard';

// user pages
$route['file-upload'] = 'DashboardController/pageFileUpload';
$route['manual-capture'] = 'DashboardController/pageManualCapture';
$route['schedule-payments'] = 'DashboardController/pageSchedulePayments';
$route['payment-activity'] = 'DashboardController/pagePaymentActivity';
$route['participants'] = 'DashboardController/pageParticipants';
$route['batch-file-view/(:any)'] = 'DashboardController/pageBatchFileView/$1';

// admin pages
$route['transactions'] = 'DashboardController/pageTransactions';
$route['email-server'] = 'DashboardController/pageEmailServer';
$route['api-gateways'] = 'DashboardController/pageAPIGateways';
$route['users'] = 'DashboardController/pageUsers';
$route['user-activities'] = 'DashboardController/pageUserActivities';
$route['txn-purpose'] = 'DashboardController/pageTxnPurpose';

// global apis
$route['api-transaction-generate'] = 'APIController/transactionGenerate';
$route['api-batch-generate'] = 'APIController/batchGenerate';


// user urls
$route['api-upload'] = 'DashboardController/apiUpload';
$route['api-load-batch-files'] = 'DashboardController/apiLoadBatchFiles';
$route['api-load-batch-records/(:any)'] = 'DashboardController/apiLoadBatchRecords/$1';
$route['api-delete-batch-file'] = 'DashboardController/apiDeleteBatchFile';
$route['api-submit-batch-file'] = 'DashboardController/apiSubmitBatchFile';
$route['api-authorise-batch-file'] = 'DashboardController/apiAuthoriseBatchFile';
$route['api-upload-manual'] = 'DashboardController/apiUploadManual';
$route['api-load-batch-files-submitted'] = 'DashboardController/apiLoadBatchFilesSubmitted';
$route['api-load-payment-activities'] = 'DashboardController/apiLoadPaymentActivities';

$route['api-participant-add'] = 'DashboardController/apiParticipantAdd';
$route['api-participant-update'] = 'DashboardController/apiParticipantUpdate';
$route['api-participant-delete'] = 'DashboardController/apiParticipantDelete';
$route['api-participants-load'] = 'DashboardController/apiParticipantsLoad';

$route['api-email-servers-load'] = 'DashboardController/apiEmailServersLoad';
$route['api-email-server-add'] = 'DashboardController/apiEmailServerAdd';
$route['api-email-server-delete'] = 'DashboardController/apiEmailServerDelete';
$route['api-email-server-update'] = 'DashboardController/apiEmailServerUpdate';

$route['api-gateways-load'] = 'DashboardController/apiGatewaysLoad';
$route['api-gateway-add'] = 'DashboardController/apiGatewayAdd';
$route['api-gateway-delete'] = 'DashboardController/apiGatewayDelete';
$route['api-gateway-update'] = 'DashboardController/apiGatewayUpdate';

$route['api-txn-purpose-load'] = 'DashboardController/apiTxnPurposeLoad';
$route['api-txn-purpose-add'] = 'DashboardController/apiTxnPurposeAdd';
$route['api-txn-purpose-delete'] = 'DashboardController/apiTxnPurposeDelete';

$route['api-users-load'] = 'DashboardController/apiUsersLoad';
$route['api-user-add'] = 'DashboardController/apiUserAdd';
$route['api-user-update'] = 'DashboardController/apiUserUpdate';
$route['api-user-delete'] = 'DashboardController/apiUserDelete';
$route['api-user-change-active'] = 'DashboardController/apiUserChangeActive';

$route['api-load-user-activities'] = 'DashboardController/apiLoadUserActivities';

$route['api-department-add'] = 'DashboardController/apiDepartmentAdd';

$route['api-user-role-add'] = 'DashboardController/apiUserRoleAdd';

$route['api-auto-logout'] = 'DashboardController/apiAutoLogout';
// Global APIS
$route['pay-update'] = 'APIController/payUpdate';

// cron job
$route['process-pending-batch-file'] = 'APIController/processPendingBatchFile';