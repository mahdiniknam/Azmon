<?php
// resources/lang/en/errors.php
return [
    // General errors
    'validation' => 'The submitted data is not valid.',
    'unauthorized' => 'Unauthorized access.',
    'forbidden' => 'Forbidden access.',
    'not_found' => 'Requested resource not found.',
    'method_not_allowed' => 'The request method is not allowed.',
    'server_error' => 'Internal server error.',
    'service_unavailable' => 'Service unavailable.',
    'too_many_requests' => 'Too many requests.',
    'action_failed' => 'Operation failed.',
    'something_wrong' => 'Something went wrong.',
    'bad_request' => 'Bad request.',
    'timeout' => 'Request timeout.',

    // Authentication errors
    'invalid_login' => 'Invalid login credentials.',
    'unauthenticated' => 'Unauthenticated.',
    'token_expired' => 'Token has expired.',
    'token_invalid' => 'Token is invalid.',
    'token_missing' => 'Token not provided.',
    'session_expired' => 'Session has expired.',

    // OTP errors
    'invalid_otp' => 'The entered code is invalid or expired.',
    'otp_expired' => 'OTP code has expired.',
    'otp_required' => 'OTP code is required.',
    'otp_send_failed' => 'Failed to send OTP code.',
    'otp_attempts_exceeded' => 'OTP attempts exceeded.',

    // Registration errors
    'password_incorect' => 'Password is Wrong',
    'email_taken' => 'Email is already registered.',
    'mobile_taken' => 'Mobile number is already registered.',
    'password_mismatch' => 'Password and confirmation do not match.',
    'user_not_found' => 'User with these credentials not found.',
    'invalid_password' => 'Incorrect password.',
    'password_complexity' => 'Password must contain at least one uppercase letter, one lowercase letter, and one number.',
    'mobile_not_verified' => 'Your mobile number is not verified yet.',
    'email_not_verified' => 'Your email is not verified yet.',
    'account_disabled' => 'Account is disabled.',
    'account_pending' => 'Account is pending approval.',
    'account_locked' => 'Account is locked.',

    // User errors
    'profile_update_failed' => 'Failed to update profile.',
    'password_update_failed' => 'Failed to change password.',
    'current_password_incorrect' => 'Current password is incorrect.',
    'user_update_failed' => 'Failed to update user.',
    'user_delete_failed' => 'Failed to delete user.',
    'user_create_failed' => 'Failed to create user.',

    // File errors
    'file_upload_failed' => 'File upload failed.',
    'file_too_large' => 'File is too large.',
    'file_type_not_allowed' => 'File type not allowed.',
    'file_not_found' => 'File not found.',
    'file_delete_failed' => 'Failed to delete file.',

    // Database errors
    'database_connection' => 'Database connection error.',
    'query_failed' => 'Database query failed.',
    'record_not_found' => 'Record not found.',
    'duplicate_entry' => 'Duplicate entry.',
    'constraint_violation' => 'Database constraint violation.',

    // Payment errors
    'payment_failed' => 'Payment failed.',
    'insufficient_funds' => 'Insufficient funds.',
    'payment_gateway_error' => 'Payment gateway error.',
    'transaction_failed' => 'Transaction failed.',
    'refund_failed' => 'Refund failed.',

    // Email errors
    'email_send_failed' => 'Failed to send email.',
    'email_required' => 'Email is required.',
    'email_format_invalid' => 'Invalid email format.',

    // SMS errors
    'sms_send_failed' => 'Failed to send SMS.',
    'mobile_required' => 'Mobile number is required.',
    'mobile_format_invalid' => 'Invalid mobile number format.',

    // Validation errors (generic)
    'required' => 'The :attribute field is required.',
    'string' => 'The :attribute field must be a string.',
    'max' => 'The :attribute field must not be greater than :max characters.',
    'min' => 'The :attribute field must be at least :min characters.',
    'email' => 'The :attribute field must be a valid email address.',
    'unique' => 'The :attribute has already been taken.',
    'confirmed' => 'The :attribute confirmation does not match.',
    'digits' => 'The :attribute field must be :digits digits.',
    'in' => 'The selected :attribute is invalid.',
    'numeric' => 'The :attribute field must be a number.',
    'integer' => 'The :attribute field must be an integer.',
    'boolean' => 'The :attribute field must be true or false.',
    'date' => 'The :attribute field must be a valid date.',
    'date_format' => 'The :attribute field must match the format :format.',
    'url' => 'The :attribute field must be a valid URL.',
    'ip' => 'The :attribute field must be a valid IP address.',
    'image' => 'The :attribute field must be an image.',
    'mimes' => 'The :attribute field must be a file of type: :values.',
    'mimetypes' => 'The :attribute field must be a file of type: :values.',
    'size' => 'The :attribute field must be :size kilobytes.',
    'between' => 'The :attribute field must be between :min and :max.',
    'regex' => 'The :attribute field format is invalid.',
    'required_if' => 'The :attribute field is required when :other is :value.',
    'required_unless' => 'The :attribute field is required unless :other is in :values.',
    'required_with' => 'The :attribute field is required when :values is present.',
    'required_with_all' => 'The :attribute field is required when :values are present.',
    'required_without' => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same' => 'The :attribute field must match :other.',
    'different' => 'The :attribute field must be different from :other.',
    'exists' => 'The selected :attribute is invalid.',
    'timezone' => 'The :attribute field must be a valid timezone.',
    'json' => 'The :attribute field must be a valid JSON string.',
    'array' => 'The :attribute field must be an array.',

    // Custom validation messages
    'password' => [
        'min' => 'Password must be at least :min characters.',
        'mixed' => 'Password must contain both uppercase and lowercase letters.',
        'numbers' => 'Password must contain numbers.',
        'symbols' => 'Password must contain symbols.',
    ],
    'username_not_found' => 'Username Not Found',
    'status_id_inactive' => 'Status Id Inactive',

    'mobile' => [
        'iran' => 'Mobile number must be Iranian.',
    ],
    // role
    'role' => [
        'already_exists'     => 'این نقش قبلاً ایجاد شده است',
        'permission_invalid' => 'برخی از دسترسی‌های انتخاب‌شده معتبر نیستند',
        'create_failed'      => 'خطا در ایجاد نقش کاربری',
        'role_has_admins' => 'This role is assigned to admins and cannot be deleted.'
    ],
    'super_admin_cannot_be_deleted' => 'Super Admin Cannot Be Deleted',
    // Success messages (for consistency)
    'success' => 'Operation completed successfully.',
    'created' => 'Successfully created.',
    'updated' => 'Successfully updated.',
    'deleted' => 'Successfully deleted.',
    'sent' => 'Successfully sent.',
    'verified' => 'Successfully verified.',
    'logged_in' => 'Successfully logged in.',
    'registered' => 'Successfully registered.',
    'google_2fa_activated' => 'Google 2Fa Activated',
    'operation_success' => 'Operation Success',


    // Warning messages
    'warning' => 'Warning',
    'confirm_action' => 'Are you sure you want to perform this action?',
    'irreversible_action' => 'This action is irreversible.',

    // Info messages
    'info' => 'Information',
    'no_data' => 'No data available.',
    'no_changes' => 'No changes were made.',
    //sms setting
    'invalid_sms_provider' => 'Invalid SMS provider.',
    //file
    'file_upload_failed' => 'File upload failed.',
    'file_delete_failed' => 'Failed to delete file.',
    
    'invalid_sms_provider' => 'Selected SMS provider is invalid.',
    'invalid_email_provider' => 'Selected email provider is invalid.',
];
