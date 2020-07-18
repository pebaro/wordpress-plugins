( ( $ ) => {
	$( document ).ready( () => {

		
		if ( document.getElementById( 'iupdm-access-la' ) ){
			const license_link = document.getElementById( 'iupdm-access-la' );

			license_link.addEventListener( 'click', ( e ) => {
				var current_date = new Date();
				var expiry_date = new Date( current_date.getTime() + 2*24*60*60*1000 );
				var use_expiry = expiry_date.toGMTString();
	
				var current_url = window.location.href;
				var license_url = "/";
	
				document.cookie = 'iupdm_save_download_url=' + current_url + '; ' + 'expires=' + use_expiry + '; path=' + license_url + ';';
			} );

		}	


		// =============================
		// ===== download requests =====
		// =============================
		if ( document.getElementById( 'iupdm-rf-request-purpose' ) ){
			// form
			const request_form 		= document.forms[ 'iupdmRF' ];
			// select route 
			const request_purpose 	= request_form[ 'iupdmRFRequestPurpose' ];

			// set the main route of questions to follow
			request_purpose.addEventListener( 'change', ( e ) => {
	

				// ===== COURSE & LABS ROUTE =====
				// ===============================
				if ( request_purpose.value == 'course-labs' ){
	
					// remove other routes if they exists
					const projects_route = document.getElementById( 'iupdm-rf-projects-route-container' );
					const others_route = document.getElementById( 'iupdm-rf-others-route-container' );
					if ( projects_route ){
						projects_route.remove();
					}
					if ( others_route ){
						others_route.remove();
					}
	
					// create route container
					const 	course_route_container = document.createElement( 'div' );
							course_route_container.setAttribute( 'id', 'iupdm-rf-course-route-container' );
	

					// course name input elements
					// =============================
					const 	course_name_container = document.createElement( 'div' );
							course_name_container.className = 'iupdm-rf-question-container';
					// question
					const 	course_name_question = document.createElement( 'p' );
							course_name_question.className = 'iupdm-rf-question';
							course_name_question.textContent = 'What is the name of the course?';
							course_name_container.appendChild( course_name_question );
					// course name
					const 	course_name_input = document.createElement( 'input' );
							course_name_input.setAttribute( 'type', 'text' );
							course_name_input.setAttribute( 'name', 'iupdmRFCourseName' );
							course_name_input.setAttribute( 'id', 'iupdm-rf-course-name' );
							course_name_input.setAttribute( 'placeholder', 'course name...' );
							course_name_input.setAttribute( 'required', '' );
							course_name_input.className = 'iupdm-rf-input';
							course_name_container.appendChild( course_name_input );
					// add to route container
					course_route_container.appendChild( course_name_container );
	

					// optional or madatory elements
					// ================================
					const 	optional_mandatory_container = document.createElement( 'div' );
							optional_mandatory_container.className = 'iupdm-rf-question-container';
					// question
					const 	optional_mandatory_question = document.createElement( 'p' );
							optional_mandatory_question.className = 'iupdm-rf-question';
							optional_mandatory_question.textContent = 'Is it optional or mandatory?';
							optional_mandatory_container.appendChild( optional_mandatory_question );
					// radio group
					const 	optional_mandatory_radio_div = document.createElement( 'div' );
							optional_mandatory_radio_div.className = 'iupdm-rf-radio-group';
					// optional
					const 	optional_label = document.createElement( 'label' );
							optional_label.className = 'iupdm-rf-radio-label';
							optional_label.setAttribute( 'for', 'iupdm-rf-optional' );
							optional_label.textContent = 'Optional';
					const 	optional_radio = document.createElement( 'input' );
							optional_radio.setAttribute( 'type', 'radio' );
							optional_radio.setAttribute( 'name', 'iupdmRFOptionalMandatory' );
							optional_radio.setAttribute( 'value', 'optional' );
							optional_radio.setAttribute( 'id', 'iupdm-rf-optional' );
							optional_radio.setAttribute( 'required', '' );
							optional_radio.className = 'iupdm-rf-radio';
							optional_label.appendChild( optional_radio );
							optional_mandatory_radio_div.appendChild( optional_label );
					// mandatory
					const 	mandatory_label = document.createElement( 'label' );
							mandatory_label.className = 'iupdm-rf-radio-label';
							mandatory_label.setAttribute( 'for', 'iupdm-rf-mandatory' );
							mandatory_label.textContent = 'Mandatory';
					const 	mandatory_radio = document.createElement( 'input' );
							mandatory_radio.setAttribute( 'type', 'radio' );
							mandatory_radio.setAttribute( 'name', 'iupdmRFOptionalMandatory' );
							mandatory_radio.setAttribute( 'value', 'mandatory' );
							mandatory_radio.setAttribute( 'id', 'iupdm-rf-mandatory' );
							mandatory_radio.className = 'iupdm-rf-radio';
							mandatory_label.appendChild( mandatory_radio );
							optional_mandatory_radio_div.appendChild( mandatory_label );
					// add to container
							optional_mandatory_container.appendChild( optional_mandatory_radio_div );
					// add to route container
					course_route_container.appendChild( optional_mandatory_container );
	
					
					// start date elements
					// ======================
					const 	start_date_container = document.createElement( 'div' );
							start_date_container.className = 'iupdm-rf-question-container';
					// question
					const 	start_date_question = document.createElement( 'p' );
							start_date_question.className = 'iupdm-rf-question';
							start_date_question.textContent = 'When does it start?';
							start_date_container.appendChild( start_date_question );
					// select group
					const 	start_date_select_div = document.createElement( 'div' );
							start_date_select_div.className = 'iupdm-rf-select-group';
					// arrays
					const 	months = [ 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December' ];
					const 	years = [ 2019, 2020, 2021, 2022, 2023, 2024, 2025 ];
					// months select
					const 	start_month = document.createElement( 'select' );
							start_month.setAttribute( 'name', 'iupdmRFStartMonth' );
							start_month.setAttribute( 'id', 'iupdm-rf-start-month' );
							start_month.className = 'iupdm-rf-select';
					const 	select_start_month = document.createElement( 'option' );
							select_start_month.textContent = 'start month...';
							start_month.appendChild( select_start_month);
					// year select
					const 	start_year = document.createElement( 'select' );
							start_year.setAttribute( 'name', 'iupdmRFStartYear' );
							start_year.setAttribute( 'id', 'iupdm-rf-start-year' );
							start_year.className = 'iupdm-rf-select';
					const 	select_start_year = document.createElement( 'option' );
							select_start_year.textContent = 'start year...';
							start_year.appendChild( select_start_year );
					// months options
							for ( let i = 0; i < months.length; i++ ){
								let option = document.createElement( 'option' );
								option.setAttribute( 'value', months[ i ].toLowerCase() );
								option.textContent = months[ i ];
								start_month.appendChild( option );
							}
							start_date_select_div.appendChild( start_month );
					// years options
							for ( let i = 0; i < years.length; i++ ){
								let option = document.createElement( 'option' );
								option.setAttribute( 'value', years[ i ] );
								option.textContent = years[ i ];
								start_year.appendChild( option );
							}
							start_date_select_div.appendChild( start_year );
					// add select field group to main container
							start_date_container.appendChild( start_date_select_div );
					// add to route container
					course_route_container.appendChild( start_date_container );
	

					// number of students elements
					// ==============================
					const 	students_num_container = document.createElement( 'div' );
							students_num_container.className = 'iupdm-rf-question-container';
					// question
					const 	students_num_question = document.createElement( 'p' );
							students_num_question.className = 'iupdm-rf-question';
							students_num_question.textContent = 'How many students involved?';
							students_num_container.appendChild( students_num_question );
					// number of students
					const 	students_num_input = document.createElement( 'input' );
							students_num_input.setAttribute( 'type', 'number' );
							students_num_input.setAttribute( 'name', 'iupdmRFStudentsNumber' );
							students_num_input.setAttribute( 'id', 'iupdm-rf-students-number' );
							students_num_input.setAttribute( 'min', '1' );
							students_num_input.setAttribute( 'max', '199' );
							students_num_input.setAttribute( 'placeholder', 'maximum 199' );
							students_num_input.setAttribute( 'required', '' );
							students_num_input.className = 'iupdm-rf-input';
							students_num_container.appendChild( students_num_input );
					// add to route container
					course_route_container.appendChild( students_num_container );
	

					// student level elements
					// =========================
					const 	student_level_container = document.createElement( 'div' );
							student_level_container.className = 'iupdm-rf-question-container';
					// question
					const 	student_level_question = document.createElement( 'p' );
							student_level_question.className = 'iupdm-rf-question';
							student_level_question.textContent = 'What is their level?';
							student_level_container.appendChild( student_level_question );
					// select group
					const 	student_level_select_div = document.createElement( 'div' );
							student_level_select_div.className = 'iupdm-rf-select-group';
					// arrays
					const 	levels = [ 'Undergraduate', 'Postgraduate', 'PhD', 'Postdoctoral' ];
					// level select
					const 	student_level_select = document.createElement( 'select' );
							student_level_select.setAttribute( 'name', 'iupdmRFStudentLevel' );
							student_level_select.setAttribute( 'id', 'iupdm-rf-student-level' );
							student_level_select.className = 'iupdm-rf-select';
					const 	select_student_level = document.createElement( 'option' );
							select_student_level.textContent = 'select level...';
							student_level_select.appendChild( select_student_level );
					// levels options
							for ( let i = 0; i < levels.length; i++ ){
								let option = document.createElement( 'option' );
								option.setAttribute( 'value', levels[ i ].toLowerCase() );
								option.textContent = levels[ i ];
								student_level_select.appendChild( option );
							}
							student_level_select_div.appendChild( student_level_select );
					// add select field group to main container
							student_level_container.appendChild( student_level_select_div );
					// add to route container
					course_route_container.appendChild( student_level_container );
	

					// agree feedback elements
					// ==========================
					const 	feedback_container = document.createElement( 'div' );
							feedback_container.className = 'iupdm-rf-question-container';
					// question
					const 	feedback_question = document.createElement( 'p' );
							feedback_question.className = 'iupdm-rf-question';
							feedback_question.textContent = 'Will you feedback with their reports?';
							feedback_container.appendChild( feedback_question );
					// radio group
					const 	feedback_radio_div = document.createElement( 'div' );
							feedback_radio_div.className = 'iupdm-rf-radio-group';
					// project feedback yes
					const 	feedback_yes_label = document.createElement( 'label' );
							feedback_yes_label.className = 'iupdm-rf-radio-label';
							feedback_yes_label.setAttribute( 'for', 'iupdm-rf-feedback-yes' );
							feedback_yes_label.textContent = 'Yes';
					const 	feedback_yes_radio = document.createElement( 'input' );
							feedback_yes_radio.setAttribute( 'type', 'radio' );
							feedback_yes_radio.setAttribute( 'name', 'iupdmRFFeedbackYesNo' );
							feedback_yes_radio.setAttribute( 'value', 'yes' );
							feedback_yes_radio.setAttribute( 'id', 'iupdm-rf-feedback-yes' );
							feedback_yes_radio.setAttribute( 'required', '' );
							feedback_yes_radio.className = 'iupdm-rf-radio';
							feedback_yes_label.appendChild( feedback_yes_radio );
							feedback_radio_div.appendChild( feedback_yes_label );
					// project feedback no
					const 	feedback_no_label = document.createElement( 'label' );
							feedback_no_label.className = 'iupdm-rf-radio-label';
							feedback_no_label.setAttribute( 'for', 'iupdm-rf-feedback-no' );
							feedback_no_label.textContent = 'No';
					const 	feedback_no_radio = document.createElement( 'input' );
							feedback_no_radio.setAttribute( 'type', 'radio' );
							feedback_no_radio.setAttribute( 'name', 'iupdmRFFeedbackYesNo' );
							feedback_no_radio.setAttribute( 'value', 'no' );
							feedback_no_radio.setAttribute( 'id', 'iupdm-rf-feedback-no' );
							feedback_no_radio.className = 'iupdm-rf-radio';
							feedback_no_label.appendChild( feedback_no_radio );
							feedback_radio_div.appendChild( feedback_no_label );
					// add to container
							feedback_container.appendChild( feedback_radio_div );
					// add to route container
					course_route_container.appendChild( feedback_container );
	

					// feedback when input elements
					// ===============================
					const 	feedback_when_container = document.createElement( 'div' );
							feedback_when_container.className = 'iupdm-rf-question-container';
					// question
					const 	feedback_when_question = document.createElement( 'p' );
							feedback_when_question.className = 'iupdm-rf-question';
							feedback_when_question.textContent = 'When can we have the feedback?';
							feedback_when_container.appendChild( feedback_when_question );
					// course name
					const 	feedback_when_input = document.createElement( 'input' );
							feedback_when_input.setAttribute( 'type', 'text' );
							feedback_when_input.setAttribute( 'name', 'iupdmRFFeedbackWhen' );
							feedback_when_input.setAttribute( 'id', 'iupdm-rf-feedback-when' );
							feedback_when_input.setAttribute( 'placeholder', 'feedback when...' );
							feedback_when_input.className = 'iupdm-rf-input';
							feedback_when_container.appendChild( feedback_when_input );
					// add to route container
					course_route_container.appendChild( feedback_when_container );
	

					// comments input elements
					// ==========================
					const 	comments_container = document.createElement( 'div' );
							comments_container.className = 'iupdm-rf-question-container';
					// question
					const 	comments_question = document.createElement( 'p' );
							comments_question.className = 'iupdm-rf-question';
							comments_question.textContent = 'Comments / Additional Information';
							comments_container.appendChild( comments_question );
					// course name
					const 	comments_textarea = document.createElement( 'textarea' );
							comments_textarea.setAttribute( 'type', 'text' );
							comments_textarea.setAttribute( 'name', 'iupdmRFComments' );
							comments_textarea.setAttribute( 'id', 'iupdm-rf-comments' );
							comments_textarea.setAttribute( 'rows', 6 );
							comments_textarea.setAttribute( 'placeholder', 'comments and/or additional information...' );
							comments_textarea.className = 'iupdm-rf-textarea';
							comments_container.appendChild( comments_textarea );
					// guidance note
					const 	comments_notes = document.createElement( 'span' );
							comments_notes.textContent = '(maximum number of characters allowed is 500)';
							comments_notes.className = 'iupdm-rf-guidance-note';
							comments_container.appendChild( comments_notes );
					// add to route container
					course_route_container.appendChild( comments_container );
	

					// submit button
					// ================
					const 	submit_btn = document.createElement( 'input' );
							submit_btn.setAttribute( 'type', 'submit' );
							submit_btn.setAttribute( 'value', 'Submit' );
							submit_btn.className = 'iupdm-rf-btn';
					// add to form
					course_route_container.appendChild( submit_btn );
	

					// add route to form
					// ===================================================
					request_form.appendChild( course_route_container );
					// ===================================================
				}
	
	
				// ==================================
				// ===== STUDENT PROJECTS ROUTE =====
				// ==================================
				if ( request_purpose.value == 'student-projects' ){
	
					// remove course route if it exists
					const course_route = document.getElementById( 'iupdm-rf-course-route-container' );
					const others_route = document.getElementById( 'iupdm-rf-others-route-container' );
					if ( course_route ){
						course_route.remove();
					}
					if ( others_route ){
						others_route.remove();
					}
	
					// create route container
					const 	projects_route_container = document.createElement( 'div' );
							projects_route_container.setAttribute( 'id', 'iupdm-rf-projects-route-container' );
	
					// ===================================
					// project objective input elements
					const 	project_objective_container = document.createElement( 'div' );
							project_objective_container.className = 'iupdm-rf-question-container';
					// question
					const 	project_objective_question = document.createElement( 'p' );
							project_objective_question.className = 'iupdm-rf-question';
							project_objective_question.textContent = 'What is the objective of the project?';
							project_objective_container.appendChild( project_objective_question );
					// project objective
					const 	project_objective_textarea = document.createElement( 'textarea' );
							project_objective_textarea.setAttribute( 'type', 'text' );
							project_objective_textarea.setAttribute( 'name', 'iupdmRFProjectObjective' );
							project_objective_textarea.setAttribute( 'id', 'iupdm-rf-project-objective' );
							project_objective_textarea.setAttribute( 'rows', 4 );
							project_objective_textarea.setAttribute( 'placeholder', 'the objective of this project is to...' );
							project_objective_textarea.setAttribute( 'required', '' );
							project_objective_textarea.className = 'iupdm-rf-textarea';
							project_objective_container.appendChild( project_objective_textarea );
					// guidance note
					const 	project_objective_notes = document.createElement( 'span' );
							project_objective_notes.textContent = '(maximum number of characters allowed is 255)';
							project_objective_notes.className = 'iupdm-rf-guidance-note';
							project_objective_container.appendChild( project_objective_notes );
					// add to route container
					projects_route_container.appendChild( project_objective_container );
	
					// ==============================
					// number of students elements
					const 	students_num_container = document.createElement( 'div' );
							students_num_container.className = 'iupdm-rf-question-container';
					// question
					const 	students_num_question = document.createElement( 'p' );
							students_num_question.className = 'iupdm-rf-question';
							students_num_question.textContent = 'How many students involved?';
							students_num_container.appendChild( students_num_question );
					// number of students
					const 	students_num_input = document.createElement( 'input' );
							students_num_input.setAttribute( 'type', 'number' );
							students_num_input.setAttribute( 'name', 'iupdmRFStudentsNumber' );
							students_num_input.setAttribute( 'id', 'iupdm-rf-students-number' );
							students_num_input.setAttribute( 'min', '1' );
							students_num_input.setAttribute( 'max', '20' );
							students_num_input.setAttribute( 'placeholder', 'maximum 20' );
							students_num_input.className = 'iupdm-rf-input';
							students_num_container.appendChild( students_num_input );
					// add to route container
					projects_route_container.appendChild( students_num_container );
	
					// =========================
					// student level elements
					const 	student_level_container = document.createElement( 'div' );
							student_level_container.className = 'iupdm-rf-question-container';
					// question
					const 	student_level_question = document.createElement( 'p' );
							student_level_question.className = 'iupdm-rf-question';
							student_level_question.textContent = 'What is their level?';
							student_level_container.appendChild( student_level_question );
					// select group
					const 	student_level_select_div = document.createElement( 'div' );
							student_level_select_div.className = 'iupdm-rf-select-group';
					// arrays
					const 	levels = [ 'Undergraduate', 'Postgraduate', 'PhD', 'Postdoctoral' ];
					// level select
					const 	student_level_select = document.createElement( 'select' );
							student_level_select.setAttribute( 'name', 'iupdmRFStudentLevel' );
							student_level_select.setAttribute( 'id', 'iupdm-rf-student-level' );
							student_level_select.className = 'iupdm-rf-select';
					const 	select_student_level = document.createElement( 'option' );
							select_student_level.textContent = 'select level...';
							student_level_select.appendChild( select_student_level );
					// levels options
							for ( let i = 0; i < levels.length; i++ ){
								let option = document.createElement( 'option' );
								option.setAttribute( 'value', levels[ i ].toLowerCase() );
								option.textContent = levels[ i ];
								student_level_select.appendChild( option );
							}
							student_level_select_div.appendChild( student_level_select );
					// add select field group to main container
							student_level_container.appendChild( student_level_select_div );
					// add to route container
					projects_route_container.appendChild( student_level_container );
	
					// ==========================
					// agree feedback elements
					const 	feedback_container = document.createElement( 'div' );
							feedback_container.className = 'iupdm-rf-question-container';
					// question
					const 	feedback_question = document.createElement( 'p' );
							feedback_question.className = 'iupdm-rf-question';
							feedback_question.textContent = 'Will you feedback with their reports?';
							feedback_container.appendChild( feedback_question );
					// radio group
					const 	feedback_radio_div = document.createElement( 'div' );
							feedback_radio_div.className = 'iupdm-rf-radio-group';
					// project feedback yes
					const 	feedback_yes_label = document.createElement( 'label' );
							feedback_yes_label.className = 'iupdm-rf-radio-label';
							feedback_yes_label.setAttribute( 'for', 'iupdm-rf-feedback-yes' );
							feedback_yes_label.textContent = 'Yes';
					const 	feedback_yes_radio = document.createElement( 'input' );
							feedback_yes_radio.setAttribute( 'type', 'radio' );
							feedback_yes_radio.setAttribute( 'name', 'iupdmRFFeedbackYesNo' );
							feedback_yes_radio.setAttribute( 'value', 'yes' );
							feedback_yes_radio.setAttribute( 'id', 'iupdm-rf-feedback-yes' );
							feedback_yes_radio.setAttribute( 'required', '' );
							feedback_yes_radio.className = 'iupdm-rf-radio';
							feedback_yes_label.appendChild( feedback_yes_radio );
							feedback_radio_div.appendChild( feedback_yes_label );
					// project feedback no
					const 	feedback_no_label = document.createElement( 'label' );
							feedback_no_label.className = 'iupdm-rf-radio-label';
							feedback_no_label.setAttribute( 'for', 'iupdm-rf-feedback-no' );
							feedback_no_label.textContent = 'No';
					const 	feedback_no_radio = document.createElement( 'input' );
							feedback_no_radio.setAttribute( 'type', 'radio' );
							feedback_no_radio.setAttribute( 'name', 'iupdmRFFeedbackYesNo' );
							feedback_no_radio.setAttribute( 'value', 'no' );
							feedback_no_radio.setAttribute( 'id', 'iupdm-rf-feedback-no' );
							feedback_no_radio.className = 'iupdm-rf-radio';
							feedback_no_label.appendChild( feedback_no_radio );
							feedback_radio_div.appendChild( feedback_no_label );
					// add to container
							feedback_container.appendChild( feedback_radio_div );
					// add to route container
					projects_route_container.appendChild( feedback_container );
	
					// ===============================
					// feedback when input elements
					const 	feedback_when_container = document.createElement( 'div' );
							feedback_when_container.className = 'iupdm-rf-question-container';
					// question
					const 	feedback_when_question = document.createElement( 'p' );
							feedback_when_question.className = 'iupdm-rf-question';
							feedback_when_question.textContent = 'When can we have the feedback?';
							feedback_when_container.appendChild( feedback_when_question );
					// course name
					const 	feedback_when_input = document.createElement( 'input' );
							feedback_when_input.setAttribute( 'type', 'text' );
							feedback_when_input.setAttribute( 'name', 'iupdmRFFeedbackWhen' );
							feedback_when_input.setAttribute( 'id', 'iupdm-rf-feedback-when' );
							feedback_when_input.setAttribute( 'placeholder', 'feedback when...' );
							feedback_when_input.className = 'iupdm-rf-input';
							feedback_when_container.appendChild( feedback_when_input );
					// add to route container
					projects_route_container.appendChild( feedback_when_container );
	
					// ==========================
					// comments input elements
					const 	comments_container = document.createElement( 'div' );
							comments_container.className = 'iupdm-rf-question-container';
					// question
					const 	comments_question = document.createElement( 'p' );
							comments_question.className = 'iupdm-rf-question';
							comments_question.textContent = 'Comments / Additional Information';
							comments_container.appendChild( comments_question );
					// course name
					const 	comments_textarea = document.createElement( 'textarea' );
							comments_textarea.setAttribute( 'type', 'text' );
							comments_textarea.setAttribute( 'name', 'iupdmRFComments' );
							comments_textarea.setAttribute( 'id', 'iupdm-rf-comments' );
							comments_textarea.setAttribute( 'rows', 6 );
							comments_textarea.setAttribute( 'placeholder', 'comments and/or additional information...' );
							comments_textarea.className = 'iupdm-rf-textarea';
							comments_container.appendChild( comments_textarea );
					// guidance note
					const 	comments_notes = document.createElement( 'span' );
							comments_notes.textContent = '(maximum number of characters allowed is 500)';
							comments_notes.className = 'iupdm-rf-guidance-note';
							comments_container.appendChild( comments_notes );
					// add to route container
					projects_route_container.appendChild( comments_container );
	
					// ================
					// submit button
					const 	submit_btn = document.createElement( 'input' );
							submit_btn.setAttribute( 'type', 'submit' );
							submit_btn.setAttribute( 'value', 'Submit' );
							submit_btn.className = 'iupdm-rf-btn';
					// add to form
					projects_route_container.appendChild( submit_btn );
	
					// ===================================================
					// add route to form
					request_form.appendChild( projects_route_container );
					// ===================================================
				}
	
	
				// ==============================
				// ===== OTHER REASON ROUTE =====
				// ==============================
				if ( request_purpose.value == 'others' ){
	
					// remove course route if it exists
					const course_route = document.getElementById( 'iupdm-rf-course-route-container' );
					const projects_route = document.getElementById( 'iupdm-rf-projects-route-container' );
					if ( course_route ){
						course_route.remove();
					}
					if ( projects_route ){
						projects_route.remove();
					}
	
					// create route container
					const 	others_route_container = document.createElement( 'div' );
							others_route_container.setAttribute( 'id', 'iupdm-rf-others-route-container' );
	
					// ==============================
					// other reason input elements
					const 	other_reason_container = document.createElement( 'div' );
							other_reason_container.className = 'iupdm-rf-question-container';
					// question
					const 	other_reason_question = document.createElement( 'p' );
							other_reason_question.className = 'iupdm-rf-question';
							other_reason_question.textContent = 'What is the reason?';
							other_reason_container.appendChild( other_reason_question );
					// project objective
					const 	other_reason_textarea = document.createElement( 'textarea' );
							other_reason_textarea.setAttribute( 'type', 'text' );
							other_reason_textarea.setAttribute( 'name', 'iupdmRFOtherReason' );
							other_reason_textarea.setAttribute( 'id', 'iupdm-rf-other-reason' );
							other_reason_textarea.setAttribute( 'rows', 4 );
							other_reason_textarea.setAttribute( 'placeholder', 'my reason for requesting this download is...' );
							other_reason_textarea.setAttribute( 'required', '' );
							other_reason_textarea.className = 'iupdm-rf-textarea';
							other_reason_container.appendChild( other_reason_textarea );
					// guidance note
					const 	other_reason_notes = document.createElement( 'span' );
							other_reason_notes.textContent = '(maximum number of characters allowed is 255)';
							other_reason_notes.className = 'iupdm-rf-guidance-note';
							other_reason_container.appendChild( other_reason_notes );
					// add to route container
					others_route_container.appendChild( other_reason_container );
	
					// ==============================
					// number of students elements
					const 	students_num_container = document.createElement( 'div' );
							students_num_container.className = 'iupdm-rf-question-container';
					// question
					const 	students_num_question = document.createElement( 'p' );
							students_num_question.className = 'iupdm-rf-question';
							students_num_question.textContent = 'How many people involved?';
							students_num_container.appendChild( students_num_question );
					// number of students
					const 	students_num_input = document.createElement( 'input' );
							students_num_input.setAttribute( 'type', 'number' );
							students_num_input.setAttribute( 'name', 'iupdmRFStudentsNumber' );
							students_num_input.setAttribute( 'id', 'iupdm-rf-students-number' );
							students_num_input.setAttribute( 'min', '1' );
							students_num_input.setAttribute( 'max', '20' );
							students_num_input.setAttribute( 'placeholder', 'maximum 20' );
							students_num_input.setAttribute( 'required', '' );
							students_num_input.className = 'iupdm-rf-input';
							students_num_container.appendChild( students_num_input );
					// add to route container
					others_route_container.appendChild( students_num_container );
	
					// =========================
					// student level elements
					const 	student_level_container = document.createElement( 'div' );
							student_level_container.className = 'iupdm-rf-question-container';
					// question
					const 	student_level_question = document.createElement( 'p' );
							student_level_question.className = 'iupdm-rf-question';
							student_level_question.textContent = 'What is their level?';
							student_level_container.appendChild( student_level_question );
					// select group
					const 	student_level_select_div = document.createElement( 'div' );
							student_level_select_div.className = 'iupdm-rf-select-group';
					// arrays
					const 	levels = [ 'Undergraduate', 'Postgraduate', 'PhD', 'Postdoctoral' ];
					// level select
					const 	student_level_select = document.createElement( 'select' );
							student_level_select.setAttribute( 'name', 'iupdmRFStudentLevel' );
							student_level_select.setAttribute( 'id', 'iupdm-rf-student-level' );
							student_level_select.className = 'iupdm-rf-select';
					const 	select_student_level = document.createElement( 'option' );
							select_student_level.textContent = 'select level...';
							student_level_select.appendChild( select_student_level );
					// levels options
							for ( let i = 0; i < levels.length; i++ ){
								let option = document.createElement( 'option' );
								option.setAttribute( 'value', levels[ i ].toLowerCase() );
								option.textContent = levels[ i ];
								student_level_select.appendChild( option );
							}
							student_level_select_div.appendChild( student_level_select );
					// add select field group to main container
							student_level_container.appendChild( student_level_select_div );
					// add to route container
					others_route_container.appendChild( student_level_container );
	
					// ==========================
					// agree feedback elements
					const 	feedback_container = document.createElement( 'div' );
							feedback_container.className = 'iupdm-rf-question-container';
					// question
					const 	feedback_question = document.createElement( 'p' );
							feedback_question.className = 'iupdm-rf-question';
							feedback_question.textContent = 'Will you give us feedback on your use of these materials?';
							feedback_container.appendChild( feedback_question );
					// radio group
					const 	feedback_radio_div = document.createElement( 'div' );
							feedback_radio_div.className = 'iupdm-rf-radio-group';
					// project feedback yes
					const 	feedback_yes_label = document.createElement( 'label' );
							feedback_yes_label.className = 'iupdm-rf-radio-label';
							feedback_yes_label.setAttribute( 'for', 'iupdm-rf-feedback-yes' );
							feedback_yes_label.textContent = 'Yes';
					const 	feedback_yes_radio = document.createElement( 'input' );
							feedback_yes_radio.setAttribute( 'type', 'radio' );
							feedback_yes_radio.setAttribute( 'name', 'iupdmRFFeedbackYesNo' );
							feedback_yes_radio.setAttribute( 'value', 'yes' );
							feedback_yes_radio.setAttribute( 'id', 'iupdm-rf-feedback-yes' );
							feedback_yes_radio.setAttribute( 'required', '' );
							feedback_yes_radio.className = 'iupdm-rf-radio';
							feedback_yes_label.appendChild( feedback_yes_radio );
							feedback_radio_div.appendChild( feedback_yes_label );
					// project feedback no
					const 	feedback_no_label = document.createElement( 'label' );
							feedback_no_label.className = 'iupdm-rf-radio-label';
							feedback_no_label.setAttribute( 'for', 'iupdm-rf-feedback-no' );
							feedback_no_label.textContent = 'No';
					const 	feedback_no_radio = document.createElement( 'input' );
							feedback_no_radio.setAttribute( 'type', 'radio' );
							feedback_no_radio.setAttribute( 'name', 'iupdmRFFeedbackYesNo' );
							feedback_no_radio.setAttribute( 'value', 'no' );
							feedback_no_radio.setAttribute( 'id', 'iupdm-rf-feedback-no' );
							feedback_no_radio.className = 'iupdm-rf-radio';
							feedback_no_label.appendChild( feedback_no_radio );
							feedback_radio_div.appendChild( feedback_no_label );
					// add to container
							feedback_container.appendChild( feedback_radio_div );
					// add to route container
					others_route_container.appendChild( feedback_container );
	
					// ===============================
					// feedback when input elements
					const 	feedback_when_container = document.createElement( 'div' );
							feedback_when_container.className = 'iupdm-rf-question-container';
					// question
					const 	feedback_when_question = document.createElement( 'p' );
							feedback_when_question.className = 'iupdm-rf-question';
							feedback_when_question.textContent = 'When can we have the feedback?';
							feedback_when_container.appendChild( feedback_when_question );
					// course name
					const 	feedback_when_input = document.createElement( 'input' );
							feedback_when_input.setAttribute( 'type', 'text' );
							feedback_when_input.setAttribute( 'name', 'iupdmRFFeedbackWhen' );
							feedback_when_input.setAttribute( 'id', 'iupdm-rf-feedback-when' );
							feedback_when_input.setAttribute( 'placeholder', 'feedback when...' );
							feedback_when_input.className = 'iupdm-rf-input';
							feedback_when_container.appendChild( feedback_when_input );
					// add to route container
					others_route_container.appendChild( feedback_when_container );
	
					// ==========================
					// comments input elements
					const 	comments_container = document.createElement( 'div' );
							comments_container.className = 'iupdm-rf-question-container';
					// question
					const 	comments_question = document.createElement( 'p' );
							comments_question.className = 'iupdm-rf-question';
							comments_question.textContent = 'Comments / Additional Information';
							comments_container.appendChild( comments_question );
					// course name
					const 	comments_textarea = document.createElement( 'textarea' );
							comments_textarea.setAttribute( 'type', 'text' );
							comments_textarea.setAttribute( 'name', 'iupdmRFComments' );
							comments_textarea.setAttribute( 'id', 'iupdm-rf-comments' );
							comments_textarea.setAttribute( 'rows', 6 );
							comments_textarea.setAttribute( 'placeholder', 'comments and/or additional information...' );
							comments_textarea.className = 'iupdm-rf-textarea';
							comments_container.appendChild( comments_textarea );
					// guidance note
					const 	comments_notes = document.createElement( 'span' );
							comments_notes.textContent = '(maximum number of characters allowed is 500)';
							comments_notes.className = 'iupdm-rf-guidance-note';
							comments_container.appendChild( comments_notes );
					// add to route container
					others_route_container.appendChild( comments_container );
	
					// ================
					// submit button
					const 	submit_btn = document.createElement( 'input' );
							submit_btn.setAttribute( 'type', 'submit' );
							submit_btn.setAttribute( 'value', 'Submit' );
							submit_btn.className = 'iupdm-rf-btn';
					// add to form
					others_route_container.appendChild( submit_btn );
	
					// ===================================================
					// add route to form
					request_form.appendChild( others_route_container );
					// ===================================================
				}
			} );

			// questions
			function iupdm_get_request_answers( e ){
				e.preventDefault();
	
				var optional = document.getElementById( 'iupdm-rf-optional' );
				var feedback = document.getElementById( 'iupdm-rf-feedback-yes' );
	
				// check request_purpose value to set the form configuration
				if ( request_purpose.value == 'course-labs' ){
					var form = {
						action 					: 'iupdm_download_request',
						user_ip 				: downloadRequest.user_ip,
						user_id 				: downloadRequest.user_id,
						download_id 			: downloadRequest.download_id,
						download_url 			: downloadRequest.download_url,
						download_title 			: downloadRequest.download_title,
						download_page 			: downloadRequest.download_page,
						download_version 		: downloadRequest.download_version,
						request_status 			: 'pending',
						request_purpose 		: request_purpose.value,
						course_name 			: document.forms[ 'iupdmRF' ][ 'iupdmRFCourseName' ].value,
						optional 				: optional.checked ? 'yes' : 'no',
						start_month 			: document.forms[ 'iupdmRF' ][ 'iupdmRFStartMonth' ].value,
						start_year 				: document.forms[ 'iupdmRF' ][ 'iupdmRFStartYear' ].value,
						number_of_students 		: document.forms[ 'iupdmRF' ][ 'iupdmRFStudentsNumber' ].value,
						student_level 			: document.forms[ 'iupdmRF' ][ 'iupdmRFStudentLevel' ].value,
						feedback 				: feedback.checked ? 'yes' : 'no',
						feedback_when 			: document.forms[ 'iupdmRF' ][ 'iupdmRFFeedbackWhen' ].value,
						comments 				: document.forms[ 'iupdmRF' ][ 'iupdmRFComments' ].value
					}	
				} else if ( request_purpose.value == 'student-projects' ){
					var form = {
						action 					: 'iupdm_download_request',
						user_ip 				: downloadRequest.user_ip,
						user_id 				: downloadRequest.user_id,
						download_id 			: downloadRequest.download_id,
						download_url 			: downloadRequest.download_url,
						download_title 			: downloadRequest.download_title,
						download_page 			: downloadRequest.download_page,
						download_version 		: downloadRequest.download_version,
						request_status 			: 'pending',
						request_purpose 		: request_purpose.value,
						project_objective 		: document.forms[ 'iupdmRF' ][ 'iupdmRFProjectObjective' ].value,
						number_of_students 		: document.forms[ 'iupdmRF' ][ 'iupdmRFStudentsNumber' ].value,
						student_level 			: document.forms[ 'iupdmRF' ][ 'iupdmRFStudentLevel' ].value,
						feedback 				: feedback.checked ? 'yes' : 'no',
						feedback_when 			: document.forms[ 'iupdmRF' ][ 'iupdmRFFeedbackWhen' ].value,
						comments 				: document.forms[ 'iupdmRF' ][ 'iupdmRFComments' ].value
					}
				} else {
					var form = {
						action 					: 'iupdm_download_request',
						user_ip 				: downloadRequest.user_ip,
						user_id 				: downloadRequest.user_id,
						download_id 			: downloadRequest.download_id,
						download_url 			: downloadRequest.download_url,
						download_title 			: downloadRequest.download_title,
						download_page 			: downloadRequest.download_page,
						download_version 		: downloadRequest.download_version,
						request_status 			: 'pending',
						request_purpose 		: request_purpose.value,
						other_reason 			: document.forms[ 'iupdmRF' ][ 'iupdmRFOtherReason' ].value,
						number_of_students 		: document.forms[ 'iupdmRF' ][ 'iupdmRFStudentsNumber' ].value,
						student_level 			: document.forms[ 'iupdmRF' ][ 'iupdmRFStudentLevel' ].value,
						feedback 				: feedback.checked ? 'yes' : 'no',
						feedback_when 			: document.forms[ 'iupdmRF' ][ 'iupdmRFFeedbackWhen' ].value,
						comments 				: document.forms[ 'iupdmRF' ][ 'iupdmRFComments' ].value
					}
				}
	
				$.post(
					downloadRequest.ajax_url,
					form,
					( response ) => {

						const 	removal_container = document.getElementById( 'iupdm-remove-post-submission' );
								removal_container.remove();

						const 	pending_message_container = document.getElementById( 'iupdm-status-msg-container' );

						const 	pending_message_H4 = document.createElement( 'h4' );
								pending_message_H4.setAttribute( 'id', 'iupdm-status-msg-h4' );
								pending_message_H4.className = 'iupdm-status-msg-h4';
								pending_message_H4.textContent = 'Thank you for successfully requesting this download';
								pending_message_container.appendChild( pending_message_H4 );
						const 	pending_message_P = document.createElement( 'p' );
								pending_message_P.setAttribute( 'id', 'iupdm-status-msg-p' );
								pending_message_P.className = 'iupdm-status-msg';
								pending_message_P.textContent = 'The university team are extremely busy but work hard to ensure that all download requests are reviewed and actioned as swiftly as possible. Please be patient and allow us a few days. If your response does not come through to your inbox, please check your junk mail - Thank you!';
								pending_message_container.appendChild( pending_message_P );
								 


						console.log( 'Form Submission Was A Succes!!!\n' + response );
					}
				);
			}

			// event handlers
			request_form.addEventListener( 'submit', iupdm_get_request_answers );
		}


	} );
} )( jQuery );