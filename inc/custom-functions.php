<?php

/* functions added later, */
	// ----------------- select trip ------------
	function selectTrip($key) {
	    
	    global $wpdb;
	    $sql = "
	            SELECT activityT1.name
	            FROM 0a6y1m9_terms activityT1, 0a6y1m9_term_taxonomy activityT2 
	            where activityT2.term_id = activityT1.term_id and activityT2.taxonomy='$key'
	    ";
	    $posts = $wpdb->get_results($sql);
	   	return $posts;

	}
	// ------------------- end --------------------

	function selectMonth() {
		$month = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
		return $month;
	}

	function selectMonthId() {
		$month = array("Jan" => '01', "Feb" => '02', "Mar" => '03', "Apr" => '04', "May" => '05', "Jun" => '06', "Jul" => '07', "Aug" => '08', "Sep" => '09', "Oct" => '10', "Nov" => '11', "Dec" => '12');
		return $month;
	}

	// ------------- front page find trip -------------------
	function findTripBy($destination, $activities, $costM, $costMa, $month, $key) {
		global $wpdb;
		$dest = displayMenuCategory('activity', $destination);
		$data = array();
		foreach ($dest as $key => $trek) {
		    if($trek->name == $activities) {
		        $packages = findSubmenuList($trek->term_id, $destination);
		        foreach ($packages as $keys => $package) {
		             $data[] = findTrip($package->ID, $month, $costM, $costMa, $key);
		        }
		    }
		}
		
		return $data;
	}

	function findTrip($post_Id, $month, $cost_min, $cost_max, $key) {
		
		global $wpdb;
		$sql = "
				select count(post_id) as post_id
				from 0a6y1m9_postmeta
				where 
				post_id = $post_Id
				and
				(meta_key = '" . findMetaKey('cost') . "' and (meta_value >= '$cost_min' and meta_value <= '$cost_max'))
				OR
				(meta_key = '" . findMetaKey('season') . "' and (meta_value like '%$month%'))
				
				
		";
		
		$posts = $wpdb->get_row($sql);
		
		if($posts->post_id > 0) {
			return $post_Id;
		}
		
	}
	// ----------- end ---------------------------------

	function retreiveSearchTrip($postId) {
		
		global $wpdb;
		$sql = "
				select * from 0a6y1m9_posts where ID = '$postId'
		";
		$posts = $wpdb->get_results($sql);
		return $posts;

	}

	function findMetaKey($of) {
		
		if ($of == 'activity') {
			return 'activity';
		} else if ($of == 'destination') {
			return 'country_visited';
		} else if ($of == 'cost'){
			return 'trip_cost';
		} else if ($of == 'season'){
			return 'best_season';
		} else {
			return '';
		}

	} 

	function returnMethod($method, $name) {
		
		if( $method == 'post') {
			return $_POST[$name];
		}
		if( $method == 'get') {
			return $_GET[$name];
		}

	}

	function getJourney($key, $pid) {
		global $wpdb;
		$sql = "
				SELECT meta_value as $key FROM 0a6y1m9_postmeta WHERE meta_key='$key' and post_id='$pid'
		";
		$journey = $wpdb->get_row($sql);
		return $journey;
	}

	function customScript() {
		wp_enqueue_script('custom-script-admin', get_template_directory_uri() . '/lib/js/custom-admin-scripts.js', false,false);
		wp_enqueue_script('date-range_scripts', '//cdn.jsdelivr.net/momentjs/latest/moment.min.js', array(), '1.11', false);
		wp_enqueue_script('date-range_script', '//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js', array(), '1.11', false);
		//wp_enqueue_style('date-range_style', '//cdn.jsdelivr.net/bootstrap/latest/css/bootstrap.css');
		wp_enqueue_style('date-range_styleui', '//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css');
		wp_enqueue_style('custom_admin_css', get_template_directory_uri() . '/lib/css/custom-admin-style.css', array());
	}
	add_action('admin_enqueue_scripts', 'customScript' );

	
	// ------------------------------ display menu ul->li list ----------------------------------
	function displayMenuCategory($taxonomy_key, $country) { //[plugin]
		global $wpdb;
		$sql = "
				SELECT distinct term.term_id,term.name ,term.slug
				FROM 
				0a6y1m9_term_relationships term_er,
				0a6y1m9_terms term,
				0a6y1m9_term_taxonomy taxonomy 
				where 
				term_er.object_id IN (
									select object_id from 0a6y1m9_term_relationships where term_taxonomy_id IN 
									(
									select term_id from 0a6y1m9_terms where name='$country'
									)
				)
				and 
				term_er.term_taxonomy_id = term.term_id 
				and 
				term.term_id=taxonomy.term_id 
				and 
				taxonomy.taxonomy='$taxonomy_key'
		";
		$ul_li_first = $wpdb->get_results($sql);
		return $ul_li_first;

	}
	// ------------------------ end ---------------------------------------------------------------------
	
	// ------------------------------ display menu ul->li->li list ----------------------------------
	function findSubmenuList($taxonomy_id, $country) { //[plugin]
		global $wpdb;
		$sql= "
				SELECT posts.ID, posts.post_title 
				FROM 
				0a6y1m9_posts posts,
				`0a6y1m9_term_relationships` term_er
				WHERE 
				term_er.term_taxonomy_id='$taxonomy_id'
				and 
				term_er.object_id = posts.ID 
				and 
				term_er.object_id IN (
									select object_id from 0a6y1m9_term_relationships where term_taxonomy_id IN 
									(
									select term_id from 0a6y1m9_terms where name='$country'
									)
				
				)
				and posts.post_status = 'publish'
				order by posts.ID asc
		";
		$li_list = $wpdb->get_results($sql);
		return $li_list;
	}
	// ------------------------------ end --------------------------------------------------------------

	function getDefaultTimeZone() {
		return date_default_timezone_set("Asia/Kathmandu");
	}

	function daysDiff($start_date, $end_date) {
		$sStartDate = gmdate("Y-m-d", strtotime($start_date));
		$sEndDate = gmdate("Y-m-d", strtotime($end_date));
		$aDays[] = $sStartDate;
		$sCurrentDate = $sStartDate;
		while ($sCurrentDate < $sEndDate) {
			$sCurrentDate = gmdate("Y-m-d", strtotime("+1 day", strtotime($sCurrentDate)));
			$aDays[] = $sCurrentDate;
		}
		$num = count($aDays) - 1;
		if ($num == 1) {
			$day = ' Day';
			return $num . $day;
		} else if ($num < 1) {
			getDefaultTimeZone();
			$time = date("h:i:sa");
	//$time = "22:00:00";
			$startdate = $start_date . " " . $time;
			$enddate = $end_date . " " . "11:00:00pm";
			$diff = strtotime($enddate) - strtotime($startdate);
	//convert to days
			if( strtotime($startdate) <= strtotime($enddate) ) {
				$temp = $diff / 86400;
	// days
				$days = floor($temp);
				$temp = 24 * ($temp - $days);
	// hours
				$hours = floor($temp);
				$temp = 60 * ($temp - $hours);
				if ( $hours != 0 ) {
					return $hours + 1 . ' hr';
				}
			}
		} else {
			$day = ' Days';
			return $num . $day;
		}
	}
	function tripLevel($value) {
		if($value == "Easy") {
			 //<img>
		} else if($value == "Beginners") {
			 //<img>
		} else if($value == "Moderate") {
			 //<img>
		} else if($value == "Demanding") {
			//<img>
		} else if($value == "Challenging") {
			//<img>
		} else if($value == "Strenuous"){
			//<img>
		} else {
			//<img>
		}
		return $img;
	}

	function checkStatus($id) {
		if(get_post_status($id) == 'publish') {
			return true;
		} else {
			return false;
		}
	}

	function countDeparture($date_s, $post_id) {
		global $wpdb;
		$sql = "SELECT count(post_id) as id FROM 0a6y1m9_postmeta WHERE meta_value like '$date_s%' and post_id = $post_id";
		$date_s_return = $wpdb->get_row($sql) ;
		return $date_s_return->id;
	}

	function countTrip($term_id) {
		global $wpdb;
		$sql = "SELECT count(ers.object_id) as id FROM 0a6y1m9_term_relationships as ers, 0a6y1m9_posts as pst WHERE ers.term_taxonomy_id = $term_id and pst.ID = ers.object_id and pst.post_status='publish'";
		$date_s_return = $wpdb->get_row($sql) ;
		return $date_s_return->id;
	}

	function getActivityBanner($slug) {
		global $wpdb;
		$sql = "SELECT ID FROM 0a6y1m9_posts WHERE post_type='activity-banner' and post_name like '%$slug%'";
		$slug_id = $wpdb->get_results($sql) ;
		return $slug_id[0]->ID;
	}



	

	