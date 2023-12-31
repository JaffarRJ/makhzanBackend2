<?php

define('PAGINATE', 15);

// Statuses
define('STATUS_DEACTIVE', 0);
define('STATUS_ACTIVE', 1);

// Record Status
define('ACTIVE_RECORD', 1);
define('DEACTIVE_RECORD', 0);
define('SHOW_RECORD', 1);
define('HIDE_RECORD', 0);

// Status Codes
define('ERROR_401', 401);
define('ERROR_400', 400);
define('SUCCESS_200', 200);
define('ERROR_500', 500);

// User Types
define('USER_ADMIN', 1);
define('USER_APP', 2);

// Profile Status
define('PROFILE_STATUS_PENDING', 1);
define('PROFILE_STATUS_COMPLETE', 2);

// Login Types
define('LOGIN_EMAIL', 1);
define('LOGIN_GOOGLE', 2);
define('LOGIN_FACEBOOK', 3);
define('LOGIN_APPLE', 4);


// Messages
define('GENERAL_ERROR_MESSAGE', 'Operation Failed');
define('GENERAL_DELETED_MESSAGE', 'Data Deleted Successfully');
define('GENERAL_SUCCESS_MESSAGE', 'Data Saved Successfully');
define('GENERAL_FETCHED_MESSAGE', 'Data Fetched Successfully');
define('GENERAL_UPDATED_MESSAGE', 'Data Updated Successfully');
define('GENERAL_LOGIN_MESSAGE', 'Login Successfully');


// Notifications Push Type
define('NOTIFICATION_WEB_PUSH', 1);
define('NOTIFICATION_MOBILE_PUSH', 2);

// Notification Device Status
define('ACTIVE', 1);

// chat
define('MESSAGE_CHAT', 1);
define('MESSAGE_IMAGE', 2);
define('MESSAGE_VIDEO', 3);


// Device Types
define('DEVICE_ANDROID', 1);
define('DEVICE_IOS', 2);
define('DEVICE_WEB', 3);
