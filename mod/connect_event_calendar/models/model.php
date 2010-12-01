<?php
/**
 * Elgg event model
 * 
 * @package event_calendar
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Kevin Jardine <kevin@radagast.biz>
 * @copyright Radagast Solutions 2008
 * @link http://radagast.biz/
 * 
 */

function event_calendar_get_event_for_edit($event_id) {
	if ($event_id && $event = get_entity($event_id)) {
		if ($event->canEdit()) {
			return $event;
		} else {
			return false;
		}
	} else {
		return false;
	}
}

function event_calendar_get_event_from_form() {
	
		// returns an event data object (not an ElggObject)
	
		$event_data = new stdClass();
		$event_data->form_data = true;
		$event_data->event_id = get_input('event_id',0);	
		$event_data->access_id = get_input('access',ACCESS_PRIVATE);
		$event_data->title = get_input('title','');
		$event_data->description = get_input('brief_description','');
		$event_data->venue = get_input('venue','');
		$event_calendar_times = get_plugin_setting('times', 'event_calendar');
		$event_calendar_region_display = get_plugin_setting('region_display', 'event_calendar');
		$event_calendar_type_display = get_plugin_setting('type_display', 'event_calendar');
		if ($event_calendar_times == 'yes') {
			$sh = get_input('start_time_h','');
			$sm = get_input('start_time_m','');
			if (is_numeric($sh) && is_numeric($sm)) {
				// workaround for pulldown zero value bug
				$sh--;
				$sm--;
				$event_data->start_time = $sh*60+$sm;
			} else {
				$event_data->start_time = '';
			}
			$eh = get_input('end_time_h','');
			$em = get_input('end_time_m','');
			if (is_numeric($eh) && is_numeric($em)) {
				// workaround for pulldown zero value bug
				$eh--;
				$em--;
				$event_data->end_time = $eh*60+$em;
			} else {
				$event_data->end_time = '';
			}
		}
		$event_data->start_date = get_input('start_date','');
		$event_data->end_date = get_input('end_date','');
		if ($event_calendar_region_display == 'yes') {
			$region = get_input('region','');
			if ($region == '-') {
				$region = '';
			}
			$event_data->region = $region;
		}
		if ($event_calendar_type_display == 'yes') {
			$event_type = get_input('event_type','');
			if ($event_type == '-') {
				$event_type = '';
			}
			$event_data->event_type = $event_type;
		}
		$event_data->fees = get_input('fees','');
		$event_data->contact = get_input('contact','');
		$event_data->organiser = get_input('organiser','');
		$event_data->event_tags = get_input('event_tags','');
		$event_data->long_description = get_input('long_description','');
		
		return $event_data;
}

function event_calendar_set_event_from_form() {
	$group_guid = 0;
	$result = new stdClass();
	$ed = event_calendar_get_event_from_form();
	$result->form_data = $ed;
	if ($ed->title && $ed->venue && $ed->start_date) {
		if ($ed->event_id) {
			$event = get_entity($ed->event_id);
			if (!$event) {
				// do nothing because this is a bad event id
				$result->success = false;
			}
		} else {
			$event = new ElggObject();
			$event->subtype = 'event_calendar';
			$event->owner_guid = $_SESSION['user']->getGUID();
			$group_guid = (int) get_input('group_guid',0);
			if ($group_guid) {
				$event->container_guid = $group_guid;	
			} else {
				$event->container_guid = $event->owner_guid;
			}
		}
		$event->access_id = $ed->access_id;
		$event->title = $ed->title;
		$event->description = $ed->description;
		$event->venue = $ed->venue;
		$event->start_date = strtotime($ed->start_date);
		if ($ed->end_date) {
			$event->end_date = strtotime($ed->end_date);
		} else {
			$event->end_date = $ed->end_date;
		}
		$event_calendar_times = get_plugin_setting('times', 'event_calendar');
		$event_calendar_region_display = get_plugin_setting('region_display', 'event_calendar');
		$event_calendar_type_display = get_plugin_setting('type_display', 'event_calendar');
		if ($event_calendar_times == 'yes') {
			$event->start_time = $ed->start_time;
			//$event->original_start_date = $event->start_date;
			if (is_numeric($ed->start_time)) {
				// Set start date to the Unix start time, if set.
				// This allows sorting by date *and* time.
				$event->start_date += $ed->start_time*60;
			}
			$event->end_time = $ed->end_time;
		}
		if ($event_calendar_region_display == 'yes') {
			$event->region = $ed->region;
		}
		if ($event_calendar_type_display == 'yes') {
			$event->event_type = $ed->event_type;
		}
		$event->fees = $ed->fees;
		$event->contact = $ed->contact;
		$event->organiser = $ed->organiser;
		$event->event_tags = array_reverse(string_to_tag_array($ed->event_tags));
		$event->long_description = $ed->long_description;
		$result->success = $event->save();
		if ($result->success && $group_guid && (get_plugin_setting('autogroup', 'event_calendar') == 'yes')) {
			event_calendar_add_personal_events_from_group($event->getGUID(),$group_guid);
		}
		$result->event = $event;
	} else {
		// required data missing
		$result->success = false;
	}
	
	return $result;
}

function event_calendar_get_events_between($start_date,$end_date,$is_count,$limit=10,$offset=0,$container_guid=0,$region='-') {
	if ($is_count) {
		$count = event_calendar_get_entities_from_metadata_between('start_date','end_date', 
			$start_date, $end_date, "object", "event_calendar", 0, $container_guid, $limit,$offset,"",0,false,true,$region);
		return $count;
	} else {
		$events = event_calendar_get_entities_from_metadata_between('start_date','end_date', 
			$start_date, $end_date, "object", "event_calendar", 0, $container_guid, $limit,$offset,"",0,false,false,$region);
		//return event_calendar_vsort($events,'start_date');
		return $events;
	}
}

function event_calendar_get_events_for_user_between($start_date,$end_date,$is_count,$limit=10,$offset=0,$user_guid,$container_guid=0,$region='-') {
	if ($is_count) {
		$count = event_calendar_get_entities_from_metadata_between('start_date','end_date', 
			$start_date, $end_date, "object", "event_calendar", $user_guid, $container_guid, $limit,$offset,"",0,true,true,$region);
		return $count;
	} else {
		$events = event_calendar_get_entities_from_metadata_between('start_date','end_date', 
			$start_date, $end_date, "object", "event_calendar", $user_guid, $container_guid, $limit,$offset,"",0,true,false,$region);
		//return event_calendar_vsort($events,'start_date');
		return $events;
	}
}

function event_calendar_get_events_for_friends_between($start_date,$end_date,$is_count,$limit=10,$offset=0,$user_guid,$container_guid=0,$region='-') {
	if ($user_guid) {
		$friends = get_user_friends($user_guid,"",5000);
		if ($friends) {
			$friend_guids = array();
			foreach($friends as $friend) {
				$friend_guids[] = $friend->getGUID();
			}
			if ($is_count) {
				$count = event_calendar_get_entities_from_metadata_between('start_date','end_date', 
					$start_date, $end_date, "object", "event_calendar", $friend_guids, $container_guid, $limit,$offset,"",0,true,true,$region);
				return $count;
			} else {
				$events = event_calendar_get_entities_from_metadata_between('start_date','end_date', 
					$start_date, $end_date, "object", "event_calendar", $friend_guids, $container_guid, $limit,$offset,"",0,true,false,$region);
				//return event_calendar_vsort($events,'start_date');
				return $events;
			}
		}
	}
	return array();
}

function event_calendar_vsort($original,$field, $descending = false) {
    if (!$original) {
        return $original;
    }
    $sortArr = array();
   
    foreach ( $original as $key => $item ) {
        $sortArr[ $key ] = $item->$field;
    }

    if ( $descending ) {
        arsort( $sortArr );
    } else {
        asort( $sortArr );
    }
   
    $resultArr = array();
    foreach ( $sortArr as $key => $value ) {
        $resultArr[ $key ] = $original[ $key ];
    }

    return $resultArr;
}

	/**
	 * Return a list of entities based on the given search criteria.
	 * In this case, returns entities with the given metadata between two values inclusive
	 * 
	 * @param mixed $meta_start_name 
	 * @param mixed $meta_end_name 
	 * @param mixed $meta_start_value - start of metadata range, must be numerical value
	 * @param mixed $meta_end_value - end of metadata range, must be numerical value
	 * @param string $entity_type The type of entity to look for, eg 'site' or 'object'
	 * @param string $entity_subtype The subtype of the entity.
	 * @param mixed $owner_guid Either one integer user guid or an array of user guids
	 * @param int $container_guid If supplied, the result is restricted to events associated with a specific container
	 * @param int $limit 
	 * @param int $offset
	 * @param string $order_by Optional ordering.
	 * @param int $site_guid The site to get entities for. Leave as 0 (default) for the current site; -1 for all sites.
	 * @param boolean $filter Filter by events in personal calendar if true
	 * @param true|false $count If set to true, returns the total number of entities rather than a list. (Default: false)
	 * 
	 * @return int|array A list of entities, or a count if $count is set to true
	 */
	function event_calendar_get_entities_from_metadata_between($meta_start_name, $meta_end_name, $meta_start_value = "", $meta_end_value = "", $entity_type = "", $entity_subtype = "", $owner_guid = 0, $container_guid = 0, $limit = 10, $offset = 0, $order_by = "", $site_guid = 0, $filter = false, $count = false, $region='-')
	{
		global $CONFIG;
		
		$meta_start_n = get_metastring_id($meta_start_name);
		$meta_end_n = get_metastring_id($meta_end_name);
		if ($region && $region != '-') {
			$region_n = get_metastring_id('region');
			$region_value_n = get_metastring_id($region);
			if (!$region_n || !$region_value_n) {
				if ($count) {
					return 0;
				} else {
					return false;
				}
			}
		}
			
		$entity_type = sanitise_string($entity_type);
		$entity_subtype = get_subtype_id($entity_type, $entity_subtype);
		$limit = (int)$limit;
		$offset = (int)$offset;
		//if ($order_by == "") $order_by = "e.time_created desc";
		if ($order_by == "") $order_by = "v.string asc";
		$order_by = sanitise_string($order_by);
		$site_guid = (int) $site_guid;
		if ((is_array($owner_guid) && (count($owner_guid)))) {
			foreach($owner_guid as $key => $guid) {
				$owner_guid[$key] = (int) $guid;
			}
		} else {
			$owner_guid = (int) $owner_guid;
		}
		
		if ((is_array($container_guid) && (count($container_guid)))) {
			foreach($container_guid as $key => $guid) {
				$container_guid[$key] = (int) $guid;
			}
		} else {
			$container_guid = (int) $container_guid;
		}
		if ($site_guid == 0)
			$site_guid = $CONFIG->site_guid;
			
		//$access = get_access_list();
			
		$where = array();
		
		if ($entity_type!="")
			$where[] = "e.type='$entity_type'";
		if ($entity_subtype)
			$where[] = "e.subtype=$entity_subtype";
		$where[] = "m.name_id='$meta_start_n'";
		$where[] = "m2.name_id='$meta_end_n'";
		$where[] = "((v.string >= $meta_start_value AND v.string <= $meta_end_value) OR ( v2.string >= $meta_start_value AND v2.string <= $meta_end_value) OR (v.string <= $meta_start_value AND v2.string >= $meta_start_value) OR ( v2.string <= $meta_end_value AND v2.string >= $meta_end_value))";
		if ($region && $region != '-') {
			$where[] = "m3.name_id='$region_n'";
			$where[] = "m3.value_id='$region_value_n'";
		}
		if ($site_guid > 0)
			$where[] = "e.site_guid = {$site_guid}";
		if ($filter) {
			if (is_array($owner_guid)) {
				$where[] = "ms2.string in (".implode(",",$owner_guid).")";
			} else if ($owner_guid > 0) {
				$where[] = "ms2.string = {$owner_guid}";
			}
			
			$where[] = "ms.string = 'personal_event'";
		} else {
			if (is_array($owner_guid)) {
				$where[] = "e.owner_guid in (".implode(",",$owner_guid).")";
			} else if ($owner_guid > 0) {
				$where[] = "e.owner_guid = {$owner_guid}";
			}
		}
			
		if (is_array($container_guid)) {
			$where[] = "e.container_guid in (".implode(",",$container_guid).")";
		} else if ($container_guid > 0)
			$where[] = "e.container_guid = {$container_guid}";
		
		if (!$count) {
			$query = "SELECT distinct e.* "; 
		} else {
			$query = "SELECT count(distinct e.guid) as total ";
		}
			
		$query .= "from {$CONFIG->dbprefix}entities e JOIN {$CONFIG->dbprefix}metadata m on e.guid = m.entity_guid JOIN {$CONFIG->dbprefix}metadata m2 on e.guid = m2.entity_guid ";
		if ($filter) {
			$query .= "JOIN {$CONFIG->dbprefix}annotations a ON (a.entity_guid = e.guid) ";
			$query .= "JOIN {$CONFIG->dbprefix}metastrings ms ON (a.name_id = ms.id) ";
			$query .= "JOIN {$CONFIG->dbprefix}metastrings ms2 ON (a.value_id = ms2.id) ";
		}
		if ($region && $region != '-') {
			$query .= "JOIN {$CONFIG->dbprefix}metadata m3 ON (e.guid = m3.entity_guid) ";
		}
		$query .= "JOIN {$CONFIG->dbprefix}metastrings v on v.id = m.value_id JOIN {$CONFIG->dbprefix}metastrings v2 on v2.id = m2.value_id where";
		foreach ($where as $w)
			$query .= " $w and ";
		$query .= get_access_sql_suffix("e"); // Add access controls
		$query .= ' and ' . get_access_sql_suffix("m"); // Add access controls
		$query .= ' and ' . get_access_sql_suffix("m2"); // Add access controls
		
		if (!$count) {
			$query .= " order by $order_by limit $offset, $limit"; // Add order and limit
			return get_data($query, "entity_row_to_elggstar");
		} else {
			if ($row = get_data_row($query))
				return $row->total;
		}
		return false;
	}
	
	function event_calendar_has_personal_event($event_id,$user_id) {
		$annotations = 	get_annotations($event_id, "object", "event_calendar", "personal_event", (int) $user_id, $user_id);
		if ($annotations && count($annotations) > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	function event_calendar_add_personal_event($event_id,$user_id) {
		if ( !event_calendar_has_personal_event($event_id,$user_id) ) {
			create_annotation($event_id, "personal_event", (int) $user_id, 'integer', $user_id, ACCESS_PUBLIC);
		}
	}
	
	function event_calendar_add_personal_events_from_group($event_id,$group_guid) {
		$members = get_group_members($group_guid, 100000);
		foreach($members as $member) {
			$member_id = $member->getGUID();
			event_calendar_add_personal_event($event_id,$member_id);
		}
	}
	
	function event_calendar_remove_personal_event($event_id,$user_id) {
		$annotations = 	get_annotations($event_id, "object", "event_calendar", "personal_event", (int) $user_id, $user_id);
		if ($annotations) {
			foreach ($annotations as $annotation) {
				$annotation->delete();
			}
		}
		
	}
	
	function event_calendar_get_personal_events_for_user($user_id,$limit) {
		$events = 	get_entities_from_annotations("object", "event_calendar", "personal_event", $user_id,0, 0, 1000);
		$final_events = array();
		if ($events) {
			$now = time();
			$one_day = 60*60*24;
			// don't show events that have been over for more than a day
			foreach($events as $event) {
				if (($event->start_date > $now-$one_day) || ($event->end_date && ($event->end_date > $now-$one_day))) {
					$final_events[] = $event;
				}
			}
		}
		$sorted = event_calendar_vsort($final_events,'start_date');
		return array_slice($sorted,0,$limit);		
	}
	
	function event_calendar_get_users_for_event($event_id,$limit,$offset,$is_count) {
		if ($is_count) {
			return count_annotations($event_id, "object", "event_calendar", "personal_event");
		} else {
			$users = array();
			$annotations = get_annotations($event_id, "object", "event_calendar", "personal_event", "", 0, $limit, $offset);
			if ($annotations) {
				foreach($annotations as $annotation) {
					if (($user = get_entity($annotation->value)) && ($user instanceOf ElggUser)) {
						$users[] = $user;
					}
				}
			}
			return $users;
		}
	}
	
	function event_calendar_security_fields() {
		$ts = time();
		$token = generate_action_token($ts);
		return "__elgg_token=$token&__elgg_ts=$ts";
	}
	
	function event_calendar_get_events_for_group($group_guid) {
		return get_entities('object','event_calendar',0,"",0,0,false,0,$group_guid);
	}
	
	function event_calendar_handle_join($event, $object_type, $object) {		
		$group = $object['group'];
		$user = $object['user'];
		$user_guid = $user->getGUID();
		$events = event_calendar_get_events_for_group($group->getGUID());
		foreach ($events as $event) {
			$event_id = $event->getGUID();
			event_calendar_add_personal_event($event_id,$user_guid);
		}
	}
	
	function event_calendar_handle_leave($event, $object_type, $object) {		
		$group = $object['group'];
		$user = $object['user'];
		$user_guid = $user->getGUID();
		$events = event_calendar_get_events_for_group($group->getGUID());
		foreach ($events as $event) {
			$event_id = $event->getGUID();
			event_calendar_remove_personal_event($event_id,$user_guid);
		}
	}
	
	function event_calendar_convert_time($time) {
		$hour = floor($time/60);
		$minute = sprintf("%02d",$time-60*$hour);
		return "$hour:$minute";
	}

	function event_calendar_format_time($date,$time1,$time2='') {
		if (is_numeric($time1)) {
			$t = event_calendar_convert_time($time1);
			if (is_numeric($time2)) {
				$t .= " - ".event_calendar_convert_time($time2);
			}
			return "$t, $date";
		} else {
			return $date;
		}
	}
	
	function event_calendar_activated_for_group($group) {
		$group_calendar = get_plugin_setting('group_calendar', 'event_calendar');
		$group_default = get_plugin_setting('group_default', 'event_calendar');
		if ($group && ($group_calendar != 'no')) {
			if ( ($group->event_calendar_enable == 'yes') || ((!$group->event_calendar_enable && (!$group_default || $group_default == 'yes')))) {
				return true;
			}
		}
		return false;		
	}
	
	function event_calendar_get_formatted_full_items($event) {
		$time_bit = event_calendar_get_formatted_time($event);
		$event_calendar_region_display = get_plugin_setting('region_display', 'event_calendar');
		$event_calendar_type_display = get_plugin_setting('type_display', 'event_calendar');
		$event_items = array();
		$item = new stdClass();
		$item->title = elgg_echo('event_calendar:when_label');
		$item->value = $time_bit;
		$event_items[] = $item;
		$item = new stdClass();
		$item->title = elgg_echo('event_calendar:venue_label');
		$item->value = htmlspecialchars($event->venue);
		$event_items[] = $item;
		if ($event_calendar_region_display == 'yes') {
			$item = new stdClass();
			$item->title = elgg_echo('event_calendar:region_label');
			$item->value = htmlspecialchars($event->region);
			$event_items[] = $item;
		}
		if ($event_calendar_type_display == 'yes') {
			$item = new stdClass();
			$item->title = elgg_echo('event_calendar:type_label');
			$item->value = htmlspecialchars($event->event_type);
			$event_items[] = $item;
		}
		$item = new stdClass();
		$item->title = elgg_echo('event_calendar:fees_label');
		$item->value = htmlspecialchars($event->fees);
		$event_items[] = $item;
		$item = new stdClass();
		$item->title = elgg_echo('event_calendar:organiser_label');
		$item->value = htmlspecialchars($event->organiser);
		$event_items[] = $item;
		$item = new stdClass();
		$item->title = elgg_echo('event_calendar:contact_label');
		$item->value = htmlspecialchars($event->contact);
		$event_items[] = $item;
		$item = new stdClass();
		$item->title = elgg_echo('event_calendar:event_tags_label');
		$item->value = elgg_view("output/tags",array('value'=>$event->event_tags));
		$event_items[] = $item;
		
		return $event_items;
	}
	
	function event_calendar_get_formatted_time($event) {
		$date_format = 'j M Y';
		$event_calendar_times = get_plugin_setting('times', 'event_calendar');

		$start_date = date($date_format,$event->start_date);
		if ((!$event->end_date) || ($event->end_date == $event->start_date)) {
			if ($event_calendar_times) {
				$start_date = event_calendar_format_time($start_date,$event->start_time,$event->end_time);
			}
			$time_bit = $start_date;
		} else {
			$end_date = date($date_format,$event->end_date);
			if ($event_calendar_times) {
				$start_date = event_calendar_format_time($start_date,$event->start_time);
				$end_date = event_calendar_format_time($end_date,$event->end_time);
			}
			$time_bit = "$start_date - $end_date";
		}
		
		return $time_bit;
	}
	
	function event_calendar_get_formatted_date($ts) {
		// TODO: make the date format configurable
		return date('j/n/Y',$ts);
	}

?>