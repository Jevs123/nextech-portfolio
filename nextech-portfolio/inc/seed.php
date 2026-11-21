<?php
/**
 * NexTech Portfolio – inc/seed.php
 *
 * Creates the starter content once:
 *  - three placeholder member pages (replace with the real members),
 *  - the group's four projects with their real descriptions.
 *
 * Upgrading is safe: an existing project is only replaced while it still contains
 * the old "[Placeholder]" text. Anything you have edited yourself is left alone.
 *
 * @package NexTech_Portfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** The four group projects. Feature lines are written as "Name – description". */
function nextech_starter_projects() {
	return array(
		array(
			'slug'    => 'multi-branch-coffee-shop-system',
			'image'   => 'multi-branch-coffee-shop-system.jpg',
			'old'     => array(),
			'title'   => 'Multi-Branch Coffee Shop System with Inventory Tracking and Sales Monitoring for KAPEpiliin Cafe',
			'excerpt' => 'A centralized management system that streamlines the daily operations of a coffee shop operating across multiple branches.',
			'content' => '<p>The Multi-Branch Coffee Shop System with Inventory Tracking and Sales Monitoring is a centralized management system designed to streamline the daily operations of a coffee shop operating across multiple branches. It provides an integrated platform for managing sales transactions, monitoring inventory levels, tracking product availability, and generating sales reports. The system helps management oversee branch operations, maintain accurate inventory records, and make informed business decisions through organized and accessible information.</p>',
			'meta'    => array(
				'_nt_type'     => 'Capstone Project',
				'_nt_category' => 'Business Management System',
				'_nt_client'   => 'KAPEpiliin Cafe',
				'_nt_users'    => 'Management and authorized branch personnel',
				'_nt_status'   => 'To be confirmed',
				'_nt_problem'  => 'Managing multiple coffee shop branches manually can lead to difficulties in monitoring sales, tracking inventory, and maintaining accurate business records. Separate recording processes may result in inconsistent data, delayed reports, inventory discrepancies, and difficulties identifying product demand. Without a centralized system, management may struggle to monitor branch performance and maintain efficient operations.',
				'_nt_features' => "Multi-Branch Management – Centralized monitoring and management of multiple coffee shop branches.\nPoint of Sale (POS) – Processes customer orders and records sales transactions.\nInventory Tracking – Monitors available stocks, stock movements, and product quantities.\nSales Monitoring – Tracks sales performance and transaction records across branches.\nProduct Management – Manages product details, categories, prices, and availability.\nStock Management – Records stock additions, deductions, and inventory adjustments.\nSales Reports – Generates organized sales reports for monitoring business performance.\nUser Management – Provides role-based access for authorized personnel.",
			),
		),
		array(
			'slug'    => 'hotel-management-system',
			'image'   => 'hotel-management-system.jpg',
			'old'     => array(),
			'title'   => 'Hotel Management System',
			'excerpt' => 'A digital platform that simplifies and organizes hotel operations, from room reservations to guest information and accommodation records.',
			'content' => '<p>The Hotel Management System is a digital platform developed to simplify and organize hotel operations by providing tools for managing room reservations, guest information, room availability, and accommodation records. It helps hotel personnel handle booking activities efficiently while maintaining organized guest and room information. Through a centralized system, the hotel can improve its reservation process, monitor room occupancy, and provide better service to guests.</p>',
			'meta'    => array(
				'_nt_type'     => '',
				'_nt_category' => 'Hospitality Management System',
				'_nt_client'   => '',
				'_nt_users'    => 'Hotel personnel',
				'_nt_status'   => 'To be confirmed',
				'_nt_problem'  => 'Traditional hotel management processes may involve manual reservation records, paper-based documentation, and separate monitoring of room availability. These practices can lead to booking conflicts, misplaced guest information, inaccurate room records, and delays in processing reservations. Managing guest details and room assignments manually can also make daily hotel operations more difficult and time-consuming.',
				'_nt_features' => "Room Management – Maintains room information, categories, rates, and availability.\nReservation Management – Records and manages guest room reservations.\nGuest Management – Stores and organizes guest information and booking history.\nCheck-in and Check-out – Records guest arrival and departure transactions.\nRoom Availability Monitoring – Displays available, occupied, and reserved rooms.\nBilling and Payment Management – Records guest charges and payment transactions.\nReservation Records – Maintains organized booking and accommodation records.\nReports Generation – Provides summaries of reservations, occupancy, and transactions.",
			),
		),
		array(
			'slug'    => 'iot-based-earthquake-alarm-system',
			'old'     => array( 'drrm-emergency-management-system', 'drrm-emergency-response-management' ),
			'replace' => array( 'Disaster Risk Reduction', 'DRRM' ),
			'image'   => 'iot-earthquake-alarm-system.jpg',
			'title'   => 'IoT-Based Earthquake Alarm System',
			'excerpt' => 'A technology-driven solution that detects ground vibrations and sounds an alarm when possible earthquake activity is detected.',
			'content' => '<p>The IoT-Based Earthquake Alarm System is a technology-driven solution designed to detect ground vibrations and provide early warnings when potential earthquake activity is detected. Using Internet of Things (IoT) technology and vibration sensors, the system monitors ground movement and triggers an alarm when the detected vibrations reach a predefined threshold. Its primary purpose is to help people become aware of possible earthquake activity and respond quickly to improve their safety.</p>',
			'meta'    => array(
				'_nt_type'     => '',
				'_nt_category' => 'IoT Safety System',
				'_nt_client'   => '',
				'_nt_users'    => 'Individuals within the monitored area',
				'_nt_status'   => 'To be confirmed',
				'_nt_problem'  => "Earthquakes can occur unexpectedly, leaving people with limited time to prepare and take necessary safety precautions. Traditional warning methods may not provide immediate alerts within a specific area. This can delay people's awareness of ground movement and increase the risk of injuries and damage. The system addresses this problem by providing an automated earthquake alert mechanism that detects significant vibrations and immediately activates an alarm to notify nearby individuals.",
				'_nt_features' => "Vibration Detection – Uses sensors to detect ground vibrations and movements.\nReal-Time Monitoring – Continuously monitors vibration levels through connected hardware.\nAutomatic Alarm Activation – Triggers an alarm when vibration readings reach the configured threshold.\nIoT-Based Monitoring – Uses IoT technology to connect the detection device with monitoring components.\nSound Alert Notification – Produces an audible warning to notify nearby individuals of detected vibrations.\nAdjustable Sensitivity – Allows the system's vibration detection threshold to be configured.\nEarthquake Activity Monitoring – Provides information about detected vibration levels for monitoring purposes.",
			),
		),
		array(
			'slug'    => 'computer-repair-booking-system',
			'image'   => 'computer-repair-booking-system.jpg',
			'old'     => array( 'computer-repair-booking' ),
			'title'   => 'Computer Repair Booking System',
			'excerpt' => 'A web-based platform that simplifies requesting and managing computer repair services.',
			'content' => '<p>The Computer Repair Booking System is a web-based platform designed to simplify the process of requesting and managing computer repair services. It allows customers to submit repair requests, provide information about their devices and technical issues, and monitor the progress of their service requests. The system also helps repair personnel organize appointments, manage service records, and track repair activities through a centralized platform.</p>',
			'meta'    => array(
				'_nt_type'     => '',
				'_nt_category' => 'Service Booking System',
				'_nt_client'   => '',
				'_nt_users'    => 'Customers and repair personnel',
				'_nt_status'   => 'To be confirmed',
				'_nt_problem'  => 'Traditional computer repair services may rely on walk-in inquiries, handwritten service records, and manual appointment scheduling. These processes can result in disorganized repair requests, scheduling conflicts, difficulty tracking device status, and delays in communicating updates to customers. Without a centralized booking and tracking platform, both customers and repair personnel may experience difficulties managing service transactions.',
				'_nt_features' => "Online Repair Booking – Allows customers to submit computer repair service requests.\nCustomer Management – Stores customer contact details and service information.\nDevice Information Management – Records device type, specifications, and reported problems.\nAppointment Scheduling – Organizes repair appointments and service schedules.\nRepair Status Tracking – Monitors repair progress, such as pending, in progress, and completed.\nService Request Management – Allows authorized personnel to review and manage repair requests.\nRepair History – Maintains records of previous repair services.\nNotifications and Updates – Provides customers with updates about their repair requests, if supported by the system.",
			),
		),
	);
}

/** Finds a project by any of the given slugs (any status except trash). */
function nextech_find_project( $slugs ) {
	foreach ( $slugs as $slug ) {
		$found = get_posts(
			array(
				'post_type'      => 'nextech_project',
				'post_status'    => 'any',
				'name'           => $slug,
				'posts_per_page' => 1,
			)
		);
		if ( $found ) {
			return $found[0];
		}
	}
	return null;
}

/** The three group members, in display order. Skill lists are one item per line. */
function nextech_starter_members() {
	return array(
		array(
			'slug'    => 'jevie-vhoy-gaa',
			'match'   => 'Gaa',
			'image'   => 'jevie-vhoy-gaa.jpg',
			'title'   => 'Jevie Vhoy Gaa',
			'excerpt' => 'Project Manager focused on project planning, team coordination, task management, and project documentation.',
			'content' => '<p>I am an aspiring IT professional responsible for managing and coordinating project activities within our team. As the Project Manager, I focus on organizing tasks, monitoring project progress, managing timelines, and ensuring effective communication among team members. I aim to keep our projects organized and aligned with their objectives while encouraging teamwork and collaboration.</p>',
			'meta'    => array(
				'_nt_role'          => 'Project Manager',
				'_nt_languages'     => "HTML|70\nCSS|65\nJava|40\nJavaScript|45\nPHP|60\nPython|35",
				'_nt_skills'        => "Project Planning and Management\nTeam Coordination\nTime Management\nTask Delegation\nProblem-Solving\nCommunication and Collaboration\nProject Documentation\nRequirements Coordination\nProgress Monitoring\nRisk Management",
				'_nt_tools'         => "Microsoft Word\nGitHub\nGoogle Drive\nGoogle Docs\nMicrosoft Excel\nZotero",
				'_nt_contributions' => "Organized project schedules and development timelines.\nAssigned and coordinated tasks among team members.\nMonitored project progress and deadlines.\nFacilitated communication and collaboration.\nHelped prepare project documentation and presentations.",
			),
		),
		array(
			'slug'    => 'john-carlo-carrasco',
			'match'   => 'Carrasco',
			'image'   => 'john-carlo-carrasco.jpg',
			'title'   => 'John Carlo Carrasco',
			'excerpt' => 'Programmer focused on software development, coding, debugging, and system implementation.',
			'content' => '<p>I am an aspiring IT professional interested in software development and programming. As the Programmer, I focus on translating system requirements and designs into functional applications. I work on developing system functionalities, writing and maintaining code, troubleshooting errors, and ensuring that the system performs according to its intended purpose.</p>',
			'meta'    => array(
				'_nt_role'          => 'Programmer',
				'_nt_languages'     => "HTML|90\nCSS|85\nJava|70\nJavaScript|88\nPHP|90\nPython|75",
				'_nt_skills'        => "Programming and Coding\nWeb Development\nFront-End Development\nBack-End Development\nDatabase Integration\nDebugging and Troubleshooting\nSystem Implementation\nSoftware Testing\nCode Maintenance\nProblem-Solving",
				'_nt_tools'         => "XAMPP\nVS Code\nGitHub\nHostinger\nRailway\nDeepSeek\nGoogle Drive",
				'_nt_contributions' => "Developed and implemented system functionalities.\nWrote and maintained application code.\nIntegrated database operations and system components.\nIdentified and fixed programming errors.\nConducted testing and debugging.\nImproved system functionality and performance.",
			),
		),
		array(
			'slug'    => 'joerenz-paul-blanco',
			'match'   => 'Blanco',
			'image'   => 'joerenz-paul-blanco.jpg',
			'title'   => 'Joerenz Paul Blanco',
			'excerpt' => 'System Analyst focused on requirements analysis, system design, process documentation, and system evaluation.',
			'content' => '<p>I am an aspiring IT professional interested in analyzing and designing information systems. As the System Analyst, I focus on understanding user needs, identifying system requirements, analyzing existing processes, and preparing system documentation. I help ensure that the developed applications address the intended problems and meet the needs of their users.</p>',
			'meta'    => array(
				'_nt_role'          => 'System Analyst',
				'_nt_languages'     => "HTML|65\nCSS|60\nJava|50\nJavaScript|50\nPHP|55\nPython|45",
				'_nt_skills'        => "Systems Analysis and Design\nRequirements Gathering\nRequirements Analysis\nProcess Modeling\nUse Case Diagram Development\nData Flow Diagram (DFD)\nUML Diagram Development\nSystem Documentation\nDatabase Analysis\nSoftware Testing and Evaluation\nProblem Analysis",
				'_nt_tools'         => "Draw.io\nLucidchart\nMicrosoft Visio\nMicrosoft Word\nGoogle Docs\nVisual Studio Code",
				'_nt_contributions' => "Gathered and analyzed project requirements.\nIdentified problems and proposed system solutions.\nPrepared system diagrams and documentation.\nAnalyzed system workflows and processes.\nCoordinated with the programmer regarding system requirements.\nAssisted in system testing and evaluation.",
			),
		),
	);
}

/** Copies a bundled picture into the Media Library and sets it as the featured image (only if none is set). */
function nextech_attach_image( $post_id, $file, $folder ) {
	if ( has_post_thumbnail( $post_id ) ) {
		return;
	}
	$path = get_template_directory() . '/assets/images/' . $folder . '/' . $file;
	if ( ! is_readable( $path ) ) {
		return;
	}

	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';

	$tmp = wp_tempnam( $file );
	if ( ! $tmp || ! copy( $path, $tmp ) ) {
		return;
	}
	$id = media_handle_sideload(
		array(
			'name'     => $file,
			'tmp_name' => $tmp,
		),
		$post_id,
		get_the_title( $post_id )
	);
	if ( is_wp_error( $id ) ) {
		if ( file_exists( $tmp ) ) {
			unlink( $tmp ); // phpcs:ignore WordPress.WP.AlternativeFunctions
		}
		return;
	}
	set_post_thumbnail( $post_id, $id );
}

/** Fills only the empty meta fields of an item the group has already edited. */
function nextech_fill_empty_meta( $post_id, $meta ) {
	foreach ( $meta as $key => $value ) {
		if ( '' === (string) get_post_meta( $post_id, $key, true ) && '' !== (string) $value ) {
			update_post_meta( $post_id, $key, $value );
		}
	}
}

/** True when a post still holds starter placeholder text (or any extra marker text). */
function nextech_is_replaceable( $post, $markers = array() ) {
	$text = $post->post_title . ' ' . $post->post_content . ' ' . $post->post_excerpt;
	foreach ( array_merge( array( '[Placeholder', '(Placeholder)' ), $markers ) as $marker ) {
		if ( false !== strpos( $text, $marker ) ) {
			return true;
		}
	}
	return false;
}

function nextech_seed_members() {
	if ( get_option( 'nextech_members_v6' ) ) {
		return;
	}

	$pages = get_posts(
		array(
			'post_type'      => 'page',
			'post_status'    => 'any',
			'posts_per_page' => 10,
			'meta_key'       => '_wp_page_template',
			'meta_value'     => NEXTECH_MEMBER_TEMPLATE,
			'orderby'        => array(
				'menu_order' => 'ASC',
				'ID'         => 'ASC',
			),
		)
	);

	$claimed = array();
	foreach ( nextech_starter_members() as $index => $member ) {
		$target = null;

		// 1) A page that already carries this member's name.
		foreach ( $pages as $page ) {
			if ( ! in_array( $page->ID, $claimed, true ) && false !== stripos( $page->post_title, $member['match'] ) ) {
				$target = $page;
				break;
			}
		}
		// 2) Otherwise the next page that still holds placeholder text.
		if ( ! $target ) {
			foreach ( $pages as $page ) {
				if ( ! in_array( $page->ID, $claimed, true ) && nextech_is_replaceable( $page ) ) {
					$target = $page;
					break;
				}
			}
		}

		if ( $target ) {
			$claimed[] = $target->ID;
			$post_id   = $target->ID;
			if ( nextech_is_replaceable( $target ) || trim( $target->post_content ) === trim( $member['content'] ) ) {
				wp_update_post(
					array(
						'ID'           => $post_id,
						'post_title'   => $member['title'],
						'post_name'    => $member['slug'],
						'post_excerpt' => $member['excerpt'],
						'post_content' => $member['content'],
						'menu_order'   => $index + 1,
					)
				);
				foreach ( array( '_nt_languages', '_nt_networking', '_nt_databases', '_nt_web', '_nt_skills', '_nt_tools', '_nt_contributions', '_nt_achievements', '_nt_education' ) as $key ) {
					if ( ! isset( $member['meta'][ $key ] ) ) {
						delete_post_meta( $post_id, $key ); // drop leftover placeholder skills
					}
				}
				foreach ( $member['meta'] as $key => $value ) {
					update_post_meta( $post_id, $key, $value );
				}
			} else {
				nextech_fill_empty_meta( $post_id, $member['meta'] );
			}
		} else {
			$post_id = wp_insert_post(
				array(
					'post_type'     => 'page',
					'post_status'   => 'publish',
					'post_title'    => $member['title'],
					'post_name'     => $member['slug'],
					'post_excerpt'  => $member['excerpt'],
					'post_content'  => $member['content'],
					'menu_order'    => $index + 1,
					'page_template' => NEXTECH_MEMBER_TEMPLATE,
					'meta_input'    => $member['meta'],
				)
			);
			if ( is_wp_error( $post_id ) || ! $post_id ) {
				continue;
			}
		}

		nextech_attach_image( $post_id, $member['image'], 'members' );
	}

	update_option( 'nextech_members_v6', 1 );
}

function nextech_seed_projects() {
	if ( get_option( 'nextech_projects_v5' ) ) {
		return;
	}

	// Remove the very first generic placeholders ("[Placeholder] Project 1..3") from version 1.0.
	$old = get_posts(
		array(
			'post_type'      => 'nextech_project',
			'post_status'    => 'any',
			'posts_per_page' => -1,
			's'              => '[Placeholder] Project',
		)
	);
	foreach ( $old as $old_post ) {
		if ( 0 === strpos( $old_post->post_title, '[Placeholder] Project' ) ) {
			wp_trash_post( $old_post->ID );
		}
	}

	foreach ( nextech_starter_projects() as $index => $project ) {
		$existing = nextech_find_project( array_merge( array( $project['slug'] ), $project['old'] ) );
		$markers  = isset( $project['replace'] ) ? $project['replace'] : array();

		if ( $existing && ! nextech_is_replaceable( $existing, $markers ) ) {
			// Edited by the group: keep their text, only fill what is empty.
			nextech_fill_empty_meta( $existing->ID, $project['meta'] );
			if ( '' === trim( wp_strip_all_tags( $existing->post_content ) ) ) {
				wp_update_post( array( 'ID' => $existing->ID, 'post_content' => $project['content'] ) );
			}
			if ( '' === trim( $existing->post_excerpt ) ) {
				wp_update_post( array( 'ID' => $existing->ID, 'post_excerpt' => $project['excerpt'] ) );
			}
			nextech_attach_image( $existing->ID, $project['image'], 'projects' );
			continue;
		}

		$data = array(
			'post_type'    => 'nextech_project',
			'post_status'  => 'publish',
			'post_title'   => $project['title'],
			'post_name'    => $project['slug'],
			'post_excerpt' => $project['excerpt'],
			'post_content' => $project['content'],
			'menu_order'   => $index + 1,
		);

		if ( $existing ) {
			$data['ID'] = $existing->ID;
			$post_id    = wp_update_post( $data, true );
		} else {
			$post_id = wp_insert_post( $data, true );
		}

		if ( ! is_wp_error( $post_id ) && $post_id ) {
			foreach ( $project['meta'] as $key => $value ) {
				update_post_meta( $post_id, $key, $value );
			}
			nextech_attach_image( $post_id, $project['image'], 'projects' );
		}
	}

	update_option( 'nextech_projects_v5', 1 );
	flush_rewrite_rules();
}

function nextech_seed_content() {
	nextech_seed_members();
	nextech_seed_projects();
}
// Runs once on the first page load (front end or dashboard) after install or update.
add_action( 'init', 'nextech_seed_content', 99 );
add_action( 'after_switch_theme', 'nextech_seed_content' );
