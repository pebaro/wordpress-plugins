<?php
// total no. download requests
$download_requests = $wpdb->get_var(
	"SELECT COUNT(*) FROM `" . $wpdb->prefix . "dm_requests`"
);

// requests pending
$requests_pending = $wpdb->get_var(
	"SELECT COUNT(*) FROM `" . $wpdb->prefix . "dm_requests` 
	WHERE request_status='pending'"
);

// requests approved
$request_approvals = $wpdb->get_var(
	"SELECT COUNT(*) FROM `" . $wpdb->prefix . "dm_requests` 
	WHERE request_status='approved'"
);

// requests denied
$request_denials = $wpdb->get_var(
	"SELECT COUNT(*) FROM `" . $wpdb->prefix . "dm_requests` 
	WHERE request_status='denied'"
);

// requests in review
$request_reviews = $wpdb->get_var(
	"SELECT COUNT(*) FROM `" . $wpdb->prefix . "dm_requests` 
	WHERE request_status='review'"
);

// requests archived
$requests_archived = $wpdb->get_var(
	"SELECT COUNT(*) FROM `" . $wpdb->prefix . "dm_requests` 
	WHERE request_status='history'"
);

// requests for 'course & labs'
$course_labs = $wpdb->get_var(
	"SELECT COUNT(*) FROM `" . $wpdb->prefix . "dm_requests` 
	WHERE request_purpose='course-labs'"
);

// requests for 'student projects'
$student_projects = $wpdb->get_var(
	"SELECT COUNT(*) FROM `" . $wpdb->prefix . "dm_requests` 
	WHERE request_purpose='student-projects'"
);

// requests for 'others'
$others = $wpdb->get_var(
	"SELECT COUNT(*) FROM `" . $wpdb->prefix . "dm_requests` 
	WHERE request_purpose='others'"
);

// licenses agreements
$license_agreements = $wpdb->get_results(
	"SELECT * FROM `" . $wpdb->prefix . "dm_agreements`"
);

// total no. of licenses agreed
$licenses_agreed = $wpdb->get_var(
	"SELECT COUNT(*) FROM `" . $wpdb->prefix . "dm_agreements`"
);

// no. of ... agreed
$teaching_materials_agreed = $wpdb->get_var(
	"SELECT COUNT(*) FROM `" . $wpdb->prefix . "dm_agreements`
	WHERE license_id='199'"
);
