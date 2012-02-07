<?php

function check_email($email) {
	if(preg_match('/^\w[-.\w]*@(\w[-._\w]*\.[a-zA-Z]{2,}.*)$/', $email, $matches)){
		if(function_exists('checkdnsrr')){
			if(checkdnsrr($matches[1] . '.', 'MX')) return true;
			if(checkdnsrr($matches[1] . '.', 'A')) return true;
		}else{
			
			// windows workstation - bypass stuff
			if($_SERVER['HTTP_HOST'] == 'localhost') return true;
			
			if(!empty($hostName)){
				if( $recType == '' ) $recType = "MX";
				exec("nslookup -type=$recType $hostName", $result);
				foreach ($result as $line){
					if(eregi("^$hostName",$line)){
						return true;
					}
				}
				return false;
			}
			return false;
		}
	}
	return false;
}

function get_revision($id) {
	$sql = db_query('SELECT body FROM {node_revisions} WHERE nid = %d ORDER BY vid DESC LIMIT 1', $id);
    while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	return $rows['0']['body'];
}

function get_title($id) {
	$sql = db_query('SELECT title FROM {node_revisions} WHERE nid = %d ORDER BY vid DESC LIMIT 1', $id);
    while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	return $rows['0']['title'];
}

function node_title($id) {
	$sql = db_query('SELECT title FROM {node} WHERE nid = %d', $id);
    while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	return $rows['0']['title'];
}

function node_created($id) {
	$sql = db_query('SELECT created FROM {node} WHERE nid = %d', $id);
    while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	return $rows['0']['created'];
}

function get_user_roles($id) {
	$sql = db_query("SELECT rid FROM {users_roles} WHERE uid='$id'");
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	return $rows;
}

function is_admin() {
	global $user;
	$roles = get_user_roles($user->uid);
	foreach($roles as $role) {
		if($role['rid']=='4') {
			$admin=1;
		}
	}
	return $admin;
}

function site_section($id) {
	$sql = db_query('SELECT name FROM {term_data} n, {term_node} t WHERE t.tid=n.tid AND n.vid="3" AND t.nid = %d',$id);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	$site_section =  $rows['0']['name'];
	$site_section = strtolower(str_replace(' ','_',$site_section));
	return $site_section;
}

function get_comments() {
	$sql = db_query("SELECT n.nid,n.title,c.timestamp FROM {node} n, {comments} c WHERE n.nid=c.nid AND n.type='forum' ORDER BY c.nid DESC LIMIT 5");
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	return $rows;
}

function get_genres() {
	$sql = db_query('SELECT tid,name FROM {term_data} WHERE vid = 1 ORDER BY tid ASC LIMIT 12');
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	return $rows;
}


function genre_list() {
	$genres = get_genres();
	$genre_count = count($genres);
	$halfway = $genre_count/2;
	if($genres) {
		$output = '<ul class="list">';
		for($i=0;$i<$genre_count;$i++) {
			$output .='<li><a href="/taxonomy/term/'.$genres[$i]['tid'].'">'.$genres[$i]['name'].'</a></li>';
			if($i==$halfway) {
				$output .='</ul><ul class="list">';
			}
		}
		$output .='</ul>';
	}
	return $output;
}

function body_classes() {
	$uri_path = trim($_SERVER['REQUEST_URI'], '/');
	// Split up the remaining URI into an array, using '/' as delimiter.
	$uri_parts = explode('/', $uri_path);
	/*
	switch ($uri_parts['0']) {
	case 'news-listings':
    	$body_classes = 'news_and_alerts';
    break;
	case 'events-listings':
    	$body_classes = 'news_and_alerts';
    break;
	case 'related-events':
    	$body_classes = 'news_and_alerts';
    break;
	case 'related-campaigns':
    	$body_classes = 'campaigns';
    break;
	case 'campaign-videos':
    	$body_classes = 'campaigns';
    break;
	case 'campaigns-archive':
    	$body_classes = 'campaigns';
    break;
	case 'image':
    	$body_classes = 'campaigns';
    break;
	case 'og':
    	$body_classes = 'user';
    break;
}
*/
	return $body_classes;
}
function latest_news() {
	$sql = db_query("SELECT * FROM {node} as n,{node_revisions} as r WHERE n.type='news' AND n.status = '1' AND r.nid=n.nid ORDER BY n.nid DESC LIMIT 1");
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	return $rows['0'];
}
function user_picture($id) {
	$sql = db_query('SELECT name,picture FROM {users} WHERE uid = %d',$id);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	if($rows) {
		$path = $rows['0']['picture'];
		if($path) { 
		   $image = '<img src="/'.$path.'" alt="" class="user-picture" title="'.$rows['0']['name'].'"/>';
	    } else {
		   $image = '<img src="/sites/all/themes/bookbloc/images/profile-pic.gif" alt="" class="user-picture" title="'.$rows['0']['name'].'"/>';
    	}
    }
	return $image;
}

function user_picture_alerts($id) {
	$sql = db_query('SELECT name,picture FROM {users} WHERE uid = %d',$id);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	if($rows) {
		$path = $rows['0']['picture'];
		if($path) { 
		   $image = '<img src="/'.$path.'" alt="'.$rows['0']['name'].'" />';
	    } else {
		   $image = '<img src="/sites/all/themes/bookbloc/images/profile-pic.gif" alt="'.$rows['0']['name'].'" />';
    	}
    }
	return $image;
}

function user_img($id) {
	$sql = db_query('SELECT name,picture FROM {users} WHERE uid = %d',$id);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	if($rows['0']['picture']==NULL) {
		$rows['0']['picture'] = 'sites/all/themes/bookbloc/images/profile-pic.gif';
	}
	return $rows['0']['picture'];
}

function user_link($id) {
	$sql = db_query('SELECT name,uid FROM {users} WHERE uid = %d',$id);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
    return $rows;
}

function page_link($id,$title) {
	$link = '<a href="/node/'.$id.'">'.$title.'</a>';
    return $link;
}
function get_genre($id) {
	$sql = db_query('SELECT name FROM {term_data} n, {term_node} t WHERE t.tid=n.tid AND n.vid="1" AND t.nid = %d',$id);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	$genre =  $rows['0']['name'];
	return $genre;
}
function get_node_count($id) {
	$sql = db_query('SELECT totalcount FROM {node_counter} WHERE nid = %d',$id);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	return $rows['0']['totalcount'];

}
function get_users_total_views($uid)
{
	$sql = db_query("SELECT SUM(totalcount) AS n FROM node_counter n WHERE nid IN (SELECT nid FROM node WHERE type = 'word' AND uid = %d", $uid);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	return 0+$rows['0']['n'];
}
function get_node_comments($id) {
	$sql = db_query('SELECT cid FROM {comments} WHERE nid = %d',$id);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	return $rows;

}
function get_node_votes($id) {
	$sql = db_query('SELECT value FROM {votingapi_vote} WHERE content_id = %d',$id);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	$value = $rows['0']['value'];
	$value = $value/20;
	$value = number_format($value,2);
	return $value;
}

function get_votes_count($id) {
	$sql = db_query('SELECT value FROM {votingapi_vote} WHERE content_id = %d',$id);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	$count = count($rows);
	return $count;
}
function get_rating($id) {
	$rate = 0;
	$sql = db_query('SELECT value FROM {votingapi_vote} WHERE content_id = %d',$id);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	if (count($rows)) {
		foreach($rows as $row) {
			$rate += $row['value'];
		}
		if (count($rows)>0) {
			$rate = $rate/count($rows);
		}
	}
	return (0+$rate)*0.05;
}

function get_publishers_votes_count($id) {
	$sql = db_query('SELECT v.value FROM {votingapi_vote} v, {users_roles} r WHERE v.content_id = %d AND r.rid=v.uid AND r.rid=4',$id);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	$count = count($rows);
	return $count;
}
function get_node_publisher_votes($id) {
	$sql = db_query('SELECT v.value FROM {votingapi_vote} v, {users_roles} r WHERE v.content_id = %d AND r.rid=v.uid AND r.rid=4',$id);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	$value = $rows['0']['value'];
	$value = $value/20;
	$value = number_format($value,2);
	return $value;
}
function get_user_details() {
	global $user;
	$id = $user->uid;
	$sql = db_query('SELECT * FROM {profile_values} WHERE uid = %d ORDER BY fid ASC',$id);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	return $rows;
}
function user_details($id) {
	$sql = db_query('SELECT * FROM {profile_values} WHERE uid = %d ORDER BY fid ASC',$id);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	return $rows;
}
function user_username($id) {
	$sql = db_query('SELECT name FROM {users} WHERE uid = %d',$id);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	return $rows['0']['name'];
}

function user_userid($str) {
	$sql = db_query("SELECT uid FROM {users} WHERE name = '%s'",$str);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	return $rows['0']['uid'];
}


function user_detail($uid,$fid) {
	$sql = db_query('SELECT value FROM {profile_values} WHERE uid = %d AND fid = %d',$uid,$fid);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	return $rows['0']['value'];
}
function neat_trim($str, $n, $delim='<br/>') {
   $len = strlen($str);
   if ($len > $n) {
       preg_match('/(.{' . $n . '}.*?)\b/', $str, $matches);
       return ($matches[1]) . $delim;
   }
   else {
       return $str;
   }
}
function get_activity($uid) {
	$sql = db_query('SELECT data FROM {activity} WHERE uid = %d',$uid);
	while($row = db_fetch_array($sql)) {
		$row['data'] = unserialize($row['data']);
        $row['data']['aid'] 		= $row['aid'];
		$row['data']['uid'] 		= $row['uid'];
	    $row['data']['module'] 		= $row['module'];
	    $row['data']['type'] 		= $row['type'];
	    $row['data']['operation'] 	= ($row['data']['operation'] ? $row['data']['operation'] : $row['operation']);
	   $rows[] = $row;
	}
	return $rows;
}
function check_bookmark($id) {
	global $user; 
	$uid = $user->uid;
	$sql = db_query("SELECT nid FROM {favorite_nodes} WHERE nid='$id' AND uid = '$uid'");
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	return $rows['0']['nid'];
}

function latest_words($id) {
	$sql = db_query('SELECT * FROM {node} WHERE uid = %d AND type="word" ORDER BY nid DESC',$id);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	for($i=0;$i<count($rows);$i++) {
		$words[$i]['user'] = $rows[$i]['uid'];
		$words[$i]['created'] = $rows[$i]['created'];
		$words[$i]['extra'] = $rows[$i]['nid'];
		$words[$i]['action'] = 'word';
	}
	return $words;
}


function user_words($id) {
	$sql = db_query('SELECT nid,title,created FROM {node} WHERE uid = %d AND type="word" AND status=1 ORDER BY nid DESC',$id);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	return $rows;
}

function wall_date($timestamp) {
	//$output = '<p class="wall_date">'.date('F d Y H:i:s',$timestamp).'</p>';
	$output = '<br /><span class="phTime">'.date('d F Y',$timestamp).' </span>';
	return $output;
}

function sort2d($array, $index, $order='asc', $natsort=TRUE, $case_sensitive=FALSE) 
    {
        if(is_array($array) && count($array)>0) 
        {
           foreach(array_keys($array) as $key) 
               $temp[$key]=$array[$key][$index];
               if(!$natsort) 
                   ($order=='asc')? asort($temp) : arsort($temp);
              else 
              {
                 ($case_sensitive)? natsort($temp) : natcasesort($temp);
                 if($order!='asc') 
                     $temp=array_reverse($temp,TRUE);
           }
           foreach(array_keys($temp) as $key) 
               (is_numeric($key))? $sorted[]=$array[$key] : $sorted[$key]=$array[$key];
           return $sorted;
      }
      return $array;
    }

function pigeonhole($id,$count) { 
	$latest_words = latest_words($id);
	$my_fans = user_fans($id);
	$reverse_fans = user_fans_reverse($id);
	$idea_comments = idea_comments($id);
	$r_idea_comments = r_idea_comments($id);
	$profile_wall_comments = profile_wall_comments($id);
	$r_profile_wall_comments = r_profile_wall_comments($id);
	$my_friends = user_friend($id);
	$reverse_friends = user_friend_reverse($id);
	$my_reviews = my_reviews($id);
	$my_reviewed = my_reviewed($id);
	$my_reviewed_words = my_reviewed_words($id);
	$my_favorites = my_favorites($id);
	$my_favorited = my_favorited($id);
	$my_votes = my_votes($id);
	$my_voted = my_voted($id);
    $genre_updates = get_genre_updates($id);
	
	$all = $latest_words;

	if(empty($all)) {
		$all = array();
	}

	
	if($my_fans) {
	   $all = array_merge($all,$my_fans);
    }
	if($reverse_fans) {
	   $all = array_merge($all,$reverse_fans);
    }
	if($idea_comments) {
	   $all = array_merge($all,$idea_comments);
    }
	if($r_idea_comments) {
	   $all = array_merge($all,$r_idea_comments);
    }
	if($profile_wall_comments) {
	   $all = array_merge($all,$profile_wall_comments);
    }
	if($r_profile_wall_comments) {
	   $all = array_merge($all,$r_profile_wall_comments);
    }
	if($my_friends) {
	   $all = array_merge($all,$my_friends);
    }
	if($reverse_friends) {
	   $all = array_merge($all,$reverse_friends);
    }
	if($my_reviews) {
	   $all = array_merge($all,$my_reviews);
    }
	if($my_reviewed) {
	   $all = array_merge($all,$my_reviewed);
    } 
	if($my_reviewed_words) {
	   $all = array_merge($all,$my_reviewed_words);
    }
	if($my_favorites) {
	   $all = array_merge($all,$my_favorites);
    }
	if($my_favorited) {
	   $all = array_merge($all,$my_favorited);
    }
	if($my_votes) {
	   $all = array_merge($all,$my_votes);
    }
	if($my_voted) {
	   $all = array_merge($all,$my_voted);
    }
	if($genre_updates) {
	   $all = array_merge($all,$genre_updates);
    }
	
	$all = sort2d($all, 'created', $order='desc', $natsort=FALSE, 'created');
	

	
	if($count) {
		for($i=0;$i<$count;$i++) {	
			switch($all[$i]['action']) {
				case "fan":
					$extra = '<a href="/user/'.$all[$i]['extra'].'">'.user_username($all[$i]['extra']).'</a>';
					$output .= '<li>'.wall_date($all[$i]['created']).'- ';
				    $output .= ''.$profile.' became a fan of '.$extra.'</li>';
				break;
				case "friend":
					$profile = '<a href="/user/'.$all[$i]['user'].'">'.user_username($all[$i]['user']).'</a>';
					$extra = '<a href="/user/'.$all[$i]['extra'].'">'.user_username($all[$i]['extra']).'</a>';
					$output .= '<li>'.wall_date($all[$i]['created']).'- ';
				    $output .= ''.$profile.' and '.$extra.' are now friends'.'</li>';
				break;
				case "word":
					$profile = '<a href="/user/'.$all[$i]['user'].'">'.user_username($all[$i]['user']).'</a>';
					$extra = '<a href="/node/'.$all[$i]['extra'].'">'.node_title($all[$i]['extra']).'</a>';
					$output .= '<li>'.wall_date($all[$i]['created']).'- ';
				    $output .= ''.$profile.' added new words '.$extra.'</li>';
				break;
				case "rfan":
					$profile = '<a href="/user/'.$all[$i]['extra'].'">'.user_username($all[$i]['extra']).'</a>';
					$extra = '<a href="/user/'.$all[$i]['user'].'">'.user_username($all[$i]['user']).'</a>';
					$output .= '<li>'.wall_date($all[$i]['created']).'- ';
				    $output .= ''.$profile.' became a fan of '.$extra.'</li>';
				break;
				case "idea_comments":
					$profile = '<a href="/'.$all[$i]['extra'].'">'.$all[$i]['extra'].'</a>';
					$extra = '<a href="/user/'.$all[$i]['user'].'">'.user_username($all[$i]['user']).'</a>';
					$output .= '<li>'.wall_date($all[$i]['created']).'- ';
				    $output .= ''.$profile.' added a comment on your idea <a href="/node/'.$all[$i]['nid'].'">'.node_title($all[$i]['nid']).'</a>'.'</li>';
				break;
				case "r_idea_comments":
					$profile = '<a href="/'.user_username(node_author($all[$i]['nid'])).'">'.user_username(node_author($all[$i]['nid'])).'</a>';
					//$extra = '<a href="/user/'.$all[$i]['user'].'">'.user_username($all[$i]['user']).'</a>';
					$output .= '<li>'.wall_date($all[$i]['created']).'- ';
				    $output .= 'You commented on '.$profile.'\'s <a href="/node/'.$all[$i]['nid'].'">'.node_title($all[$i]['nid']).'</a></li>';
				break;
				case "profile_comments":
					$profile = '<a href="/'.user_username($all[$i]['user']).'">'.user_username($all[$i]['user']).'</a>';
					$extra = '<a href="/'.user_username($all[$i]['user']).'">'.user_username($all[$i]['user']).'</a>';
					$output .= '<li>'.wall_date($all[$i]['created']).'- ';
				    $output .= ''.$profile.' commented on your <a href="/'.user_username($all[$i]['extra']).'">profile</a>'.'</li>';
				break;
				case "r_profile_comments":
					$profile = '<a href="/'.user_username($all[$i]['user']).'">'.user_username($all[$i]['user']).'</a>';
					$extra = '<a href="/'.user_username($all[$i]['extra']).'">'.user_username($all[$i]['extra']).'</a>';
					$output .= '<li>'.wall_date($all[$i]['created']).'- ';
				    $output .= '<a href="/'.user_username($all[$i]['user']).'">You</a> commented on '.$extra.'\'s profile'.'</li>';
				break;
				
				case "review":
					$profile = '<a href="/user/'.$all[$i]['user'].'">'.user_username($all[$i]['user']).'</a>';
					$extra = '<a href="/node/'.$all[$i]['extra'].'">'.node_title($all[$i]['extra']).'</a>';
					$output .= '<li>'.wall_date($all[$i]['created']).'- ';
					$author = '<a href="/user/'.node_author($all[$i]['extra']).'">'.user_username(node_author($all[$i]['extra'])).'</a>';
				    $output .= ''.$profile.' reviewed '.$author.'\'s '.$extra.'</li>';
				break;
				case "reviewed":
					$profile = '<a href="/user/'.$all[$i]['user'].'">'.user_username($all[$i]['user']).'</a>';
					$extra = '<a href="/node/'.$all[$i]['extra'].'">'.node_title($all[$i]['extra']).'</a>';
					$output .= '<li>'.wall_date($all[$i]['created']).'- ';
					$author = '<a href="/user/'.node_author($all[$i]['extra']).'">'.user_username(node_author($all[$i]['extra'])).'</a>';
				    $output .= ''.$profile.' reviewed '.$author.'\'s '.$extra.'</li>';
				break;
				
				case "review_word":
					$profile = '<a href="/user/'.$all[$i]['user'].'">'.user_username($all[$i]['user']).'</a>';
					$extra = '<a href="/node/'.$all[$i]['extra'].'">'.node_title($all[$i]['extra']).'</a>';
					$output .= '<li>'.wall_date($all[$i]['created']).'- ';
					$author = '<a href="/user/'.node_author($all[$i]['extra']).'">'.user_username(node_author($all[$i]['extra'])).'</a>';
				    $output .= ''.$profile.' reviewed '.$author.'\'s '.$extra.'</li>';
				break;
				
				
				case "favorite":
					$profile = '<a href="/user/'.$all[$i]['user'].'">'.user_username($all[$i]['user']).'</a>';
					$extra = '<a href="/node/'.$all[$i]['extra'].'">'.node_title($all[$i]['extra']).'</a>';
					$output .= '<li>'.wall_date($all[$i]['created']).'- ';
					$author = '<a href="/user/'.node_author($all[$i]['extra']).'">'.user_username(node_author($all[$i]['extra'])).'</a>';
				    $output .= ''.$profile.' added '.$author.'\'s '.$extra.' as favourite'.'</li>';
				break;
				case "favorited":
					$profile = '<a href="/user/'.$all[$i]['user'].'">'.user_username($all[$i]['user']).'</a>';
					$extra = '<a href="/node/'.$all[$i]['extra'].'">'.node_title($all['extra']).'</a>';
					$output .= '<li>'.wall_date($all[$i]['created']).'- ';
					$author = '<a href="/user/'.node_author($all[$i]['extra']).'">'.user_username(node_author($all[$i]['extra'])).'</a>';
				    $output .= ''.$profile.' added '.$author.'\'s '.$extra.' as favourite'.'</li>';
				break;
				case "vote":
					if($all[$i]['user']!=0) {
					$profile = '<a href="/user/'.$all[$i]['user'].'">'.user_username($all[$i]['user']).'</a>';
					$extra = '<a href="/node/'.$all[$i]['extra'].'">'.node_title($all[$i]['extra']).'</a>';
					$output .= '<li>'.wall_date($all[$i]['created']).'- ';
					$author = '<a href="/user/'.node_author($all[$i]['extra']).'">'.user_username(node_author($all[$i]['extra'])).'</a>';
				    $output .= ''.$profile.' rated '.$author.'\'s '.$extra.' '.$all[$i]['vote'].' out of 5'.'</li>';
					}
				break;
				case "voted":
					if($all[$i]['user']!=0) {
					$profile = '<a href="/user/'.$all[$i]['user'].'">'.user_username($all[$i]['user']).'</a>';
					$extra = '<a href="/node/'.$all[$i]['extra'].'">'.node_title($all[$i]['extra']).'</a>';
					$output .= '<li>'.wall_date($all[$i]['created']).'- ';
					$author = '<a href="/user/'.node_author($all[$i]['extra']).'">'.user_username(node_author($all[$i]['extra'])).'</a>';
				    $output .= ''.$profile.' rated '.$author.'\'s '.$extra.' '.$all[$i]['vote'].' out of 5'.'</li>';
					}
				break;
					case "fav_genre":
						if($all[$i]['user']!=0) {
						$title = title($all[$i]['extra']); 
						if($title):
						$profile = '<a href="/user/'.$all[$i]['user'].'">'.user_username($all[$i]['user']).'</a>';
						$extra = '<a href="/node/'.$all[$i]['extra'].'">'.node_title($all[$i]['extra']).'</a>';
						$title = title($all[$i]['extra']); 
						$output .= '<li>'.wall_date(strtotime($all[$i]['created'])).'- ';
						$word = '<a href="/node/'.$all[$i]['extra'].'">'.$title.'</a>';
					    $output .= ''.$profile.' added '.$word.' in '.genre_from_id($all[$i]['genre']).'</li>';
					    endif;
						}
					break;
			}

		}
	}
	else {

	foreach($all as $item) {	
		switch($item['action']) {
			case "fan":
				$extra = '<a href="/user/'.$item['extra'].'">'.user_username($item['extra']).'</a>';
				$output .= '<li>'.wall_date($item['created']).'- ';
			    $output .= ''.$profile.' became a fan of '.$extra.'</li>';
			break;
			case "friend":
				$profile = '<a href="/user/'.$item['user'].'">'.user_username($item['user']).'</a>';
				$extra = '<a href="/user/'.$item['extra'].'">'.user_username($item['extra']).'</a>';
				$output .= '<li>'.wall_date($item['created']).'- ';
			    $output .= ''.$profile.' and '.$extra.' are now friends'.'</li>';
			break;
			case "word":
				$profile = '<a href="/user/'.$item['user'].'">'.user_username($item['user']).'</a>';
				$extra = '<a href="/node/'.$item['extra'].'">'.node_title($item['extra']).'</a>';
				$output .= '<li>'.wall_date($item['created']).'- ';
			    $output .= ''.$profile.' added new words '.$extra.'</li>';
			break;
			case "idea_comments":
				$profile = '<a href="/'.$item['extra'].'">'.$item['extra'].'</a>';
				$extra = '<a href="/user/'.$item['user'].'">'.user_username($item['user']).'</a>';
				$output .= '<li>'.wall_date($item['created']).'- ';
				$output .= ''.$profile.' added a comment on your idea <a href="/node/'.$item['nid'].'">'.node_title($item['nid']).'</a>'.'</li>';
			break;
			case "r_idea_comments":
				$profile = '<a href="/'.user_username(node_author($item['nid'])).'">'.user_username(node_author($item['nid'])).'</a>';
				//$extra = '<a href="/user/'.$all[$i]['user'].'">'.user_username($all[$i]['user']).'</a>';
				$output .= '<li>'.wall_date($item['created']).'- ';
			    $output .= '<a href="/'.user_username($item['user']).'">You</a> commented on '.$profile.'\'s <a href="/node/'.$item['nid'].'">'.node_title($item['nid']).'</a>'.'</li>';
			break;
			case "profile_comments":
				$profile = '<a href="/'.user_username($item['user']).'">'.user_username($item['user']).'</a>';
				$extra = '<a href="/user/'.$item['user'].'">'.user_username($item['user']).'</a>';
				$output .= '<li>'.wall_date($item['created']).'- ';
			    $output .= ''.$profile.' commented on your <a href="/'.user_username($item['extra']).'">profile</a>'.'</li>';
			break;
			case "r_profile_comments":
				$profile = '<a href="/'.user_username($item['user']).'">'.user_username($item['user']).'</a>';
				$extra = '<a href="/'.user_username($item['extra']).'">'.user_username($item['extra']).'</a>';
				$output .= '<li>'.wall_date($item['created']).'- ';
			    $output .= 'You commented on '.$extra.'\'s profile'.'</li>';
			break;
			case "rfan":
				$profile = '<a href="/user/'.$item['extra'].'">'.user_username($item['extra']).'</a>';
				$extra = '<a href="/user/'.$item['user'].'">'.user_username($item['user']).'</a>';
				$output .= '<li>'.wall_date($item['created']).'- ';
			    $output .= ''.$profile.' became a fan of '.$extra.'</li>';
			break;
			
			case "review":
				$profile = '<a href="/user/'.$item['user'].'">'.user_username($item['user']).'</a>';
				$extra = '<a href="/node/'.$item['extra'].'">'.node_title($item['extra']).'</a>';
				$output .= '<li>'.wall_date($item['created']).'- ';
				$author = '<a href="/user/'.node_author($item['extra']).'">'.user_username(node_author($item['extra'])).'</a>';
			    $output .= ''.$profile.' reviewed '.$author.'\'s '.$extra.'</li>';
			break;
			case "reviewed":
				$profile = '<a href="/user/'.$item['user'].'">'.user_username($item['user']).'</a>';
				$extra = '<a href="/node/'.$item['extra'].'">'.node_title($item['extra']).'</a>';
				$output .= '<li>'.wall_date($item['created']).'- ';
				$author = '<a href="/user/'.node_author($item['extra']).'">'.user_username(node_author($item['extra'])).'</a>';
			    $output .= ''.$profile.' reviewed '.$author.'\'s '.$extra.'</li>';
			break;
			
			
			case "review_word":
				$profile = '<a href="/user/'.$all[$i]['user'].'">'.user_username($all[$i]['user']).'</a>';
				$extra = '<a href="/node/'.$all[$i]['extra'].'">'.node_title($all[$i]['extra']).'</a>';
				$output .= '<li>'.wall_date($all[$i]['created']).'- ';
				$author = '<a href="/user/'.node_author($all[$i]['extra']).'">'.user_username(node_author($all[$i]['extra'])).'</a>';
			    $output .= ''.$profile.' reviewed '.$author.'\'s '.$extra.'</li>';
			break;
			
			case "favorite":
				$profile = '<a href="/user/'.$item['user'].'">'.user_username($item['user']).'</a>';
				$extra = '<a href="/node/'.$item['extra'].'">'.node_title($item['extra']).'</a>';
				$output .= '<li>'.wall_date($item['created']).'- ';
				$author = '<a href="/user/'.node_author($item['extra']).'">'.user_username(node_author($item['extra'])).'</a>';
			    $output .= ''.$profile.' added '.$author.'\'s '.$extra.' as favourite'.'</li>';
			break;
			case "favorited":
				$profile = '<a href="/user/'.$item['user'].'">'.user_username($item['user']).'</a>';
				$extra = '<a href="/node/'.$item['extra'].'">'.node_title($item['extra']).'</a>';
				$output .= '<li>'.wall_date($item['created']).'- ';
				$author = '<a href="/user/'.node_author($item['extra']).'">'.user_username(node_author($item['extra'])).'</a>';
			    $output .= ''.$profile.' added '.$author.'\'s '.$extra.' as favourite'.'</li>';
			break;
			case "vote":
				$profile = '<a href="/user/'.$item['user'].'">'.user_username($item['user']).'</a>';
				$extra = '<a href="/node/'.$item['extra'].'">'.node_title($item['extra']).'</a>';
				$output .= '<li>'.wall_date($item['created']).'- ';
				$author = '<a href="/user/'.node_author($item['extra']).'">'.user_username(node_author($item['extra'])).'</a>';
			    $output .= ''.$profile.' rated '.$author.'\'s '.$extra.' '.$item['vote'].' out of 5'.'</li>';
			break;
			case "voted":
				$profile = '<a href="/user/'.$item['user'].'">'.user_username($item['user']).'</a>';
				$extra = '<a href="/node/'.$item['extra'].'">'.node_title($item['extra']).'</a>';
				$output .= '<li>'.wall_date($item['created']).'- ';
				$author = '<a href="/user/'.node_author($item['extra']).'">'.user_username(node_author($item['extra'])).'</a>';
			    $output .= ''.$profile.' rated '.$author.'\'s '.$extra.' '.$item['vote'].' out of 5'.'</li>';
			break;
			case "fav_genre":
				if($item['user']!=0) {
				$title = title($item['extra']);
				if($title):
				$profile = '<a href="/user/'.$item['user'].'">'.user_username($item['user']).'</a>';
				$extra = '<a href="/node/'.$item['extra'].'">'.node_title($item['extra']).'</a>';
				$output .= '<li>'.wall_date(strtotime($item['created'])).'- '; 
				$title = title($item['extra']);
				$word = '<a href="/node/'.$item['extra'].'">'.$title.'</a>';
			    $output .= ''.$profile.' added '.$word.' in '.genre_from_id($item['genre']).'</li>';
			    endif;
				}
			break;
		}

	} 
	
}
	
	return $output;
}

function pigeonhole_new($id,$count) { 
	$latest_words = latest_words($id);
	$my_fans = user_fans($id);
	$reverse_fans = user_fans_reverse($id);
	$idea_comments = idea_comments($id);
	$r_idea_comments = r_idea_comments($id);
	$profile_wall_comments = profile_wall_comments($id);
	$r_profile_wall_comments = r_profile_wall_comments($id);
	$my_friends = user_friend($id);
	$reverse_friends = user_friend_reverse($id);
	$my_reviews = my_reviews($id);
	$my_reviewed = my_reviewed($id);
	$my_reviewed_words = my_reviewed_words($id);
	$my_favorites = my_favorites($id);
	$my_favorited = my_favorited($id);
	$my_votes = my_votes($id);
	$my_voted = my_voted($id);
    $genre_updates = get_genre_updates($id);
	
	$all = $latest_words;

	if(empty($all)) {
		$all = array();
	}

	
	if($my_fans) {
	   $all = array_merge($all,$my_fans);
    }
	if($reverse_fans) {
	   $all = array_merge($all,$reverse_fans);
    }
	if($idea_comments) {
	   $all = array_merge($all,$idea_comments);
    }
	if($r_idea_comments) {
	   $all = array_merge($all,$r_idea_comments);
    }
	if($profile_wall_comments) {
	   $all = array_merge($all,$profile_wall_comments);
    }
	if($r_profile_wall_comments) {
	   $all = array_merge($all,$r_profile_wall_comments);
    }
	if($my_friends) {
	   $all = array_merge($all,$my_friends);
    }
	if($reverse_friends) {
	   $all = array_merge($all,$reverse_friends);
    }
	if($my_reviews) {
	   $all = array_merge($all,$my_reviews);
    }
	if($my_reviewed) {
	   $all = array_merge($all,$my_reviewed);
    } 
	if($my_reviewed_words) {
	   $all = array_merge($all,$my_reviewed_words);
    }
	if($my_favorites) {
	   $all = array_merge($all,$my_favorites);
    }
	if($my_favorited) {
	   $all = array_merge($all,$my_favorited);
    }
	if($my_votes) {
	   $all = array_merge($all,$my_votes);
    }
	if($my_voted) {
	   $all = array_merge($all,$my_voted);
    }
	if($genre_updates) {
	   $all = array_merge($all,$genre_updates);
    }
	
	$all = sort2d($all, 'created', $order='desc', $natsort=FALSE, 'created');
	

	
	if($count) {
		
		$total = $count;
		
		for($i=0;$i<$count;$i++) {	
			switch($all[$i]['action']) {
				case "fan":
					$extra = '<a href="/user/'.$all[$i]['extra'].'">'.user_username($all[$i]['extra']).'</a>';					
				    $output .= '<li>'.$profile.' became a fan of '.$extra.'';
					$output .= wall_date($all[$i]['created']).'</li>';
				break;
				case "friend":
					$profile = '<a href="/user/'.$all[$i]['user'].'">'.user_username($all[$i]['user']).'</a>';
					$extra = '<a href="/user/'.$all[$i]['extra'].'">'.user_username($all[$i]['extra']).'</a>';					
				    $output .= '<li>'.$profile.' and '.$extra.' are now friends';
					$output .= wall_date($all[$i]['created']).'</li>';
				break;
				case "word":
					$profile = '<a href="/user/'.$all[$i]['user'].'">'.user_username($all[$i]['user']).'</a>';
					$extra = '<a href="/node/'.$all[$i]['extra'].'">'.node_title($all[$i]['extra']).'</a>';					
				    $output .= '<li>'.$profile.' added new words '.$extra.'';
					$output .= wall_date($all[$i]['created']).'</li>';
				break;
				case "rfan":
					$profile = '<a href="/user/'.$all[$i]['extra'].'">'.user_username($all[$i]['extra']).'</a>';
					$extra = '<a href="/user/'.$all[$i]['user'].'">'.user_username($all[$i]['user']).'</a>';					
				    $output .= '<li>'.$profile.' became a fan of '.$extra.'';
					$output .= wall_date($all[$i]['created']).'</li>';
				break;
				case "idea_comments":
					$profile = '<a href="/'.$all[$i]['extra'].'">'.$all[$i]['extra'].'</a>';
					$extra = '<a href="/user/'.$all[$i]['user'].'">'.user_username($all[$i]['user']).'</a>';					
				    $output .= '<li>'.$profile.' added a comment on your idea <a href="/node/'.$all[$i]['nid'].'">'.node_title($all[$i]['nid']).'</a>';
					$output .= wall_date($all[$i]['created']).'</li>';
				break;
				case "r_idea_comments":
					$profile = '<a href="/'.user_username(node_author($all[$i]['nid'])).'">'.user_username(node_author($all[$i]['nid'])).'</a>';
					//$extra = '<a href="/user/'.$all[$i]['user'].'">'.user_username($all[$i]['user']).'</a>';					
				    $output .= '<li>You commented on '.$profile.'\'s <a href="/node/'.$all[$i]['nid'].'">'.node_title($all[$i]['nid']).'</a>';
					$output .= wall_date($all[$i]['created']).'</li>';
				break;
				case "profile_comments":
					$profile = '<a href="/'.user_username($all[$i]['user']).'">'.user_username($all[$i]['user']).'</a>';
					$extra = '<a href="/'.user_username($all[$i]['user']).'">'.user_username($all[$i]['user']).'</a>';					
				    $output .= '<li>'.$profile.' commented on your <a href="/'.user_username($all[$i]['extra']).'">profile</a>';
					$output .= wall_date($all[$i]['created']).'</li>';
				break;
				case "r_profile_comments":
					$profile = '<a href="/'.user_username($all[$i]['user']).'">'.user_username($all[$i]['user']).'</a>';
					$extra = '<a href="/'.user_username($all[$i]['extra']).'">'.user_username($all[$i]['extra']).'</a>';					
				    $output .= '<li><a href="/'.user_username($all[$i]['user']).'">You</a> commented on '.$extra.'\'s profile';
					$output .= wall_date($all[$i]['created']).'</li>';
				break;
				
				case "review":
					$profile = '<a href="/user/'.$all[$i]['user'].'">'.user_username($all[$i]['user']).'</a>';
					$extra = '<a href="/node/'.$all[$i]['extra'].'">'.node_title($all[$i]['extra']).'</a>';					
					$author = '<a href="/user/'.node_author($all[$i]['extra']).'">'.user_username(node_author($all[$i]['extra'])).'</a>';
				    $output .= '<li>'.$profile.' reviewed '.$author.'\'s '.$extra.'';
					$output .= wall_date($all[$i]['created']).'</li>';
				break;
				case "reviewed":
					$profile = '<a href="/user/'.$all[$i]['user'].'">'.user_username($all[$i]['user']).'</a>';
					$extra = '<a href="/node/'.$all[$i]['extra'].'">'.node_title($all[$i]['extra']).'</a>';					
					$author = '<a href="/user/'.node_author($all[$i]['extra']).'">'.user_username(node_author($all[$i]['extra'])).'</a>';
				    $output .= '<li>'.$profile.' reviewed '.$author.'\'s '.$extra.'';
					$output .= wall_date($all[$i]['created']).'</li>';
				break;
				
				case "review_word":
					$profile = '<a href="/user/'.$all[$i]['user'].'">'.user_username($all[$i]['user']).'</a>';
					$extra = '<a href="/node/'.$all[$i]['extra'].'">'.node_title($all[$i]['extra']).'</a>';					
					$author = '<a href="/user/'.node_author($all[$i]['extra']).'">'.user_username(node_author($all[$i]['extra'])).'</a>';
				    $output .= '<li>'.$profile.' reviewed '.$author.'\'s '.$extra.'';
					$output .= wall_date($all[$i]['created']).'</li>';
				break;
				
				
				case "favorite":
					$profile = '<a href="/user/'.$all[$i]['user'].'">'.user_username($all[$i]['user']).'</a>';
					$extra = '<a href="/node/'.$all[$i]['extra'].'">'.node_title($all[$i]['extra']).'</a>';					
					$author = '<a href="/user/'.node_author($all[$i]['extra']).'">'.user_username(node_author($all[$i]['extra'])).'</a>';
				    $output .= '<li>'.$profile.' added '.$author.'\'s '.$extra.' as favourite';
					$output .= wall_date($all[$i]['created']).'</li>';
				break;
				case "favorited":
					$profile = '<a href="/user/'.$all[$i]['user'].'">'.user_username($all[$i]['user']).'</a>';
					$extra = '<a href="/node/'.$all[$i]['extra'].'">'.node_title($all['extra']).'</a>';					
					$author = '<a href="/user/'.node_author($all[$i]['extra']).'">'.user_username(node_author($all[$i]['extra'])).'</a>';
				    $output .= '<li>'.$profile.' added '.$author.'\'s '.$extra.' as favourite';
					$output .= wall_date($all[$i]['created']).'</li>';
				break;
				case "vote":
					if($all[$i]['user']!=0) {
					$profile = '<a href="/user/'.$all[$i]['user'].'">'.user_username($all[$i]['user']).'</a>';
					$extra = '<a href="/node/'.$all[$i]['extra'].'">'.node_title($all[$i]['extra']).'</a>';					
					$author = '<a href="/user/'.node_author($all[$i]['extra']).'">'.user_username(node_author($all[$i]['extra'])).'</a>';
				    $output .= '<li>'.$profile.' rated '.$author.'\'s '.$extra.' '.$all[$i]['vote'].' out of 5';
					$output .= wall_date($all[$i]['created']).'</li>';
					}
				break;
				case "voted":
					if($all[$i]['user']!=0) {
					$profile = '<a href="/user/'.$all[$i]['user'].'">'.user_username($all[$i]['user']).'</a>';
					$extra = '<a href="/node/'.$all[$i]['extra'].'">'.node_title($all[$i]['extra']).'</a>';					
					$author = '<a href="/user/'.node_author($all[$i]['extra']).'">'.user_username(node_author($all[$i]['extra'])).'</a>';
				    $output .= '<li>'.$profile.' rated '.$author.'\'s '.$extra.' '.$all[$i]['vote'].' out of 5';
					$output .= wall_date($all[$i]['created']).'</li>';
					}
				break;
					case "fav_genre":
						if($all[$i]['user']!=0) {
						$title = title($all[$i]['extra']); 
						if($title):
						$profile = '<a href="/user/'.$all[$i]['user'].'">'.user_username($all[$i]['user']).'</a>';
						$extra = '<a href="/node/'.$all[$i]['extra'].'">'.node_title($all[$i]['extra']).'</a>';
						$title = title($all[$i]['extra']); 						
						$word = '<a href="/node/'.$all[$i]['extra'].'">'.$title.'</a>';
					    $output .= '<li>'.$profile.' added '.$word.' in '.genre_from_id($all[$i]['genre']).' ';
						$output .= wall_date(strtotime($all[$i]['created'])).'</li>';
					    endif;
						}
					break;
			}

		}
	}
	else {

	foreach($all as $item) {	
		
		$total = count($all);
		
		switch($item['action']) {
			case "fan":
				$extra = '<a href="/user/'.$item['extra'].'">'.user_username($item['extra']).'</a>';				
			    $output .= '<li>'.$profile.' became a fan of '.$extra.'';
				$output .= wall_date($item['created']).'</li>';
			break;
			case "friend":
				$profile = '<a href="/user/'.$item['user'].'">'.user_username($item['user']).'</a>';
				$extra = '<a href="/user/'.$item['extra'].'">'.user_username($item['extra']).'</a>';
			    $output .= '<li>'.$profile.' and '.$extra.' are now friends';
				$output .= wall_date($item['created']).'</li>';
			break;
			case "word":
				$profile = '<a href="/user/'.$item['user'].'">'.user_username($item['user']).'</a>';
				$extra = '<a href="/node/'.$item['extra'].'">'.node_title($item['extra']).'</a>';				
			    $output .= '<li>'.$profile.' added new words '.$extra.'';
				$output .= wall_date($item['created']).'</li>';
			break;
			case "idea_comments":
				$profile = '<a href="/'.$item['extra'].'">'.$item['extra'].'</a>';
				$extra = '<a href="/user/'.$item['user'].'">'.user_username($item['user']).'</a>';				
				$output .= '<li>'.$profile.' added a comment on your idea <a href="/node/'.$item['nid'].'">'.node_title($item['nid']).'</a>';
				$output .= wall_date($item['created']).'</li>';
			break;
			case "r_idea_comments":
				$profile = '<a href="/'.user_username(node_author($item['nid'])).'">'.user_username(node_author($item['nid'])).'</a>';
				//$extra = '<a href="/user/'.$all[$i]['user'].'">'.user_username($all[$i]['user']).'</a>';				
			    $output .= '<li><a href="/'.user_username($item['user']).'">You</a> commented on '.$profile.'\'s <a href="/node/'.$item['nid'].'">'.node_title($item['nid']).'</a>';
				$output .= wall_date($item['created']).'</li>';
			break;
			case "profile_comments":
				$profile = '<a href="/'.user_username($item['user']).'">'.user_username($item['user']).'</a>';
				$extra = '<a href="/user/'.$item['user'].'">'.user_username($item['user']).'</a>';				
			    $output .= '<li>'.$profile.' commented on your <a href="/'.user_username($item['extra']).'">profile</a>';
				$output .= wall_date($item['created']).'</li>';
			break;
			case "r_profile_comments":
				$profile = '<a href="/'.user_username($item['user']).'">'.user_username($item['user']).'</a>';
				$extra = '<a href="/'.user_username($item['extra']).'">'.user_username($item['extra']).'</a>';				
			    $output .= '<li>You commented on '.$extra.'\'s profile';
				$output .= wall_date($item['created']).'</li>';
			break;
			case "rfan":
				$profile = '<a href="/user/'.$item['extra'].'">'.user_username($item['extra']).'</a>';
				$extra = '<a href="/user/'.$item['user'].'">'.user_username($item['user']).'</a>';				
			    $output .= '<li>'.$profile.' became a fan of '.$extra.'';
				$output .= wall_date($item['created']).'</li>';
			break;
			
			case "review":
				$profile = '<a href="/user/'.$item['user'].'">'.user_username($item['user']).'</a>';
				$extra = '<a href="/node/'.$item['extra'].'">'.node_title($item['extra']).'</a>';				
				$author = '<a href="/user/'.node_author($item['extra']).'">'.user_username(node_author($item['extra'])).'</a>';
			    $output .= '<li>'.$profile.' reviewed '.$author.'\'s '.$extra.'';
				$output .= wall_date($item['created']).'</li>';
			break;
			case "reviewed":
				$profile = '<a href="/user/'.$item['user'].'">'.user_username($item['user']).'</a>';
				$extra = '<a href="/node/'.$item['extra'].'">'.node_title($item['extra']).'</a>';				
				$author = '<a href="/user/'.node_author($item['extra']).'">'.user_username(node_author($item['extra'])).'</a>';
			    $output .= '<li>'.$profile.' reviewed '.$author.'\'s '.$extra.'';
				$output .= wall_date($item['created']).'</li>';
			break;
			
			
			case "review_word":
				$profile = '<a href="/user/'.$all[$i]['user'].'">'.user_username($all[$i]['user']).'</a>';
				$extra = '<a href="/node/'.$all[$i]['extra'].'">'.node_title($all[$i]['extra']).'</a>';				
				$author = '<a href="/user/'.node_author($all[$i]['extra']).'">'.user_username(node_author($all[$i]['extra'])).'</a>';
			    $output .= '<li>'.$profile.' reviewed '.$author.'\'s '.$extra.'';
				$output .= wall_date($item['created']).'</li>';
			break;
			
			case "favorite":
				$profile = '<a href="/user/'.$item['user'].'">'.user_username($item['user']).'</a>';
				$extra = '<a href="/node/'.$item['extra'].'">'.node_title($item['extra']).'</a>';				
				$author = '<a href="/user/'.node_author($item['extra']).'">'.user_username(node_author($item['extra'])).'</a>';
			    $output .= '<li>'.$profile.' added '.$author.'\'s '.$extra.' as favourite';
				$output .= wall_date($item['created']).'</li>';
			break;
			case "favorited":
				$profile = '<a href="/user/'.$item['user'].'">'.user_username($item['user']).'</a>';
				$extra = '<a href="/node/'.$item['extra'].'">'.node_title($item['extra']).'</a>';				
				$author = '<a href="/user/'.node_author($item['extra']).'">'.user_username(node_author($item['extra'])).'</a>';
			    $output .= '<li>'.$profile.' added '.$author.'\'s '.$extra.' as favourite';
				$output .= wall_date($item['created']).'</li>';
			break;
			case "vote":
				$profile = '<a href="/user/'.$item['user'].'">'.user_username($item['user']).'</a>';
				$extra = '<a href="/node/'.$item['extra'].'">'.node_title($item['extra']).'</a>';				
				$author = '<a href="/user/'.node_author($item['extra']).'">'.user_username(node_author($item['extra'])).'</a>';
			    $output .= '<li>'.$profile.' rated '.$author.'\'s '.$extra.' '.$item['vote'].' out of 5';
				$output .= wall_date($item['created']).'</li>';
			break;
			case "voted":
				$profile = '<a href="/user/'.$item['user'].'">'.user_username($item['user']).'</a>';
				$extra = '<a href="/node/'.$item['extra'].'">'.node_title($item['extra']).'</a>';				
				$author = '<a href="/user/'.node_author($item['extra']).'">'.user_username(node_author($item['extra'])).'</a>';
			    $output .= '<li>'.$profile.' rated '.$author.'\'s '.$extra.' '.$item['vote'].' out of 5';
				$output .= wall_date($item['created']).'</li>';
			break;
			case "fav_genre":
				if($item['user']!=0) {
				$title = title($item['extra']);
				if($title):
				$profile = '<a href="/user/'.$item['user'].'">'.user_username($item['user']).'</a>';
				$extra = '<a href="/node/'.$item['extra'].'">'.node_title($item['extra']).'</a>';				
				$title = title($item['extra']);
				$word = '<a href="/node/'.$item['extra'].'">'.$title.'</a>';
			    $output .= '<li>'.$profile.' added '.$word.' in '.genre_from_id($item['genre']).' ';
				$output .= wall_date($item['created']).'</li>'; 
			    endif;
				}
			break;
		}

	} 
	
}
	
	return array(
		'output' 	=> $output,
		'count'		=>	$total,
	);
}

function display_profile_comments($id,$count) {
	global $user;
	//print $id;
	//print $user->uid;
	$latest_comments = profile_comments($id);
	//print_R($latest_comments);
	if($latest_comments) {
		if($count) {
			$item = $latest_comments;
			for($i=0;$i<=$count;$i++) {
				$role = get_user_roles($item['author']);
				$rid = $role['0']['rid'];
				$profile = '<a href="/user/'.$item['author'].'">'.user_username($item['author']).'</a>';
				$output .= '<div class="comment odd">';
				if($rid!='4') {
					if($rid=='5') { $class="green_left";} else { $class='';}
					$output .= '<div class="user_picture '.$class.'">'.user_picture($comment->uid).'</div>';
					if($rid=='5') { $c_class="green";} else { $c_class='';}
					$output .='<div class="comment_area '.$c_class.'">';
					$output .=$item['message'];
					$output .='<span class="author">'.$profile.' says on '.date('d F Y',$item['created']).'</span>';
					if($id == $user->uid) {
						$output .= '<br/><a href="/guestbook/edit?id='.$item['id'].'&destination='.$_SERVER['REQUEST_URI'].'" class="action">Edit</a> | <a href="/guestbook/delete/'.$item['id'].'"  class="action">Delete</a><br/>';
					}
					$output .='<div class="comment_bottom"></div>';
					$output .='</div>';
			    } else {
					$output .= '<div class="user_picture align_right">'.user_picture($comment->uid).'</div>';
					$output .='<div class="comment_area align_left">';
					$output .=$item['message'];
					$output .='<span class="author">'.$profile.' says on '.date('d F Y',$item['created']).'</span>';
						if($id == $user->uid) {
							$output .= '<br/><a href="/guestbook/edit?id='.$item['id'].'&destination='.$_SERVER['REQUEST_URI'].'" class="action">Edit</a> | <a href="/guestbook/delete/'.$item['id'].'"  class="action">Delete</a><br/>';
						}
					$output .='<div class="comment_bottom"></div>';
					$output .='</div>';
			    }
				$output .='</div>';
				$output .='<div class="clear"></div>';
			}
        } else {
		
		
		foreach($latest_comments as $item) {
			$role = get_user_roles($item['author']);
			$rid = $role['0']['rid'];
			$profile = '<a href="/user/'.$item['author'].'">'.user_username($item['author']).'</a>';
			$output .= '<div class="comment odd">';
			if($rid!='4') {
				if($rid=='5') { $class="green_left";} else { $class='';}
				$output .= '<div class="user_picture '.$class.'">'.user_picture($comment->uid).'</div>';
				if($rid=='5') { $c_class="green";} else { $c_class='';}
				$output .='<div class="comment_area '.$c_class.'">';
				$output .=$item['message'];

				$output .='<span class="author">'.$profile.' says on '.date('d F Y',$item['created']).'</span>';
					if($id == $user->uid) {
						$output .= '<br/><a href="/guestbook/edit?id='.$item['id'].'&destination='.$_SERVER['REQUEST_URI'].'" class="action">Edit</a> | <a href="/guestbook/delete/'.$item['id'].'"  class="action">Delete</a><br/>';
					}
				$output .='<div class="comment_bottom"></div>';
				$output .='</div>';
		    } else {
				$output .= '<div class="user_picture align_right">'.user_picture($comment->uid).'</div>';
				$output .='<div class="comment_area align_left">';
				$output .=$item['message'];
		
				$output .='<span class="author">'.$profile.' says on '.date('d F Y',$item['created']).'</span>';
					if($id == $user->uid) {
						$output .= '<br/><a href="/guestbook/edit?id='.$item['id'].'&destination='.$_SERVER['REQUEST_URI'].'" class="action">Edit</a> | <a href="/guestbook/delete/'.$item['id'].'"  class="action">Delete</a><br/>';
					}
				$output .='<div class="comment_bottom"></div>';
				$output .='</div>';
		    }
			$output .='</div>';
			$output .='<div class="clear"></div>';
		}
	}
}

	$comments = array(
		'count'	=>	count($latest_comments),
		'output'	=>	$output,
	);

	return $comments;
}

function display_profile_comments_new($id,$count) {
	global $user;
	//print $id;
	//print $user->uid;
	$latest_comments = profile_comments($id);
	//print_R($latest_comments);
	if($latest_comments) {
		if($count) {
			$item = $latest_comments;
			for($i=0;$i<=$count;$i++) {
				$role = get_user_roles($item['author']);
				$rid = $role['0']['rid'];
				$profile = '<a href="/user/'.$item['author'].'">'.user_username($item['author']).'</a> made a comment on <a href="'.drupal_get_path_alias('user/'.$id). '">your profile</a>';
				$output .= '<li>'.$profile.'<br /><span class="phTime">'.date('F jS Y H:i',$item['created']).'</span></li>';
			}
        } else {
		
		$count = count($latest_comments);
		
		foreach($latest_comments as $item) {
			$role = get_user_roles($item['author']);
			$rid = $role['0']['rid'];
			$profile = '<a href="/user/'.$item['author'].'">'.user_username($item['author']).'</a> made a comment on <a href="'.drupal_get_path_alias('user/'.$id). '">your profile</a>';
			$output .= '<li>'.$profile.'<br /><span class="phTime">'.date('F jS Y H:i',$item['created']).'</span></li>';
		}
	}
}
	return array('output' => $output, 'count' => $count);
}

function profile_comments($id) {
	$sql = db_query('SELECT * FROM {guestbook} WHERE recipient = %d ORDER BY created DESC',$id);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	return $rows;
}

function title($id) {
	$node = node_load($id);
	$sql = db_query('SELECT * FROM {node} WHERE nid = %d',$id);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	//print_r($rows);
	return $rows['0']['title'];
}


function idea_comments($id) {
	$sql = db_query('SELECT c.timestamp,c.uid,c.nid,c.name FROM {comments} c, {node} n WHERE n.uid = %d  AND n.nid=c.nid ORDER BY c.timestamp DESC',$id);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	for($i=0;$i<count($rows);$i++) {
		$comments[$i]['user'] = $rows[$i]['uid'];
		$comments[$i]['nid'] = $rows[$i]['nid'];
		$comments[$i]['created'] = $rows[$i]['timestamp'];
		$comments[$i]['extra'] = $rows[$i]['name'];
		$comments[$i]['action'] = 'idea_comments';
	}
	//print_r($comments);
	return $comments;
}

function r_idea_comments($id) {
	$sql = db_query('SELECT c.timestamp,c.uid,c.nid,c.name FROM {comments} c, {node} n WHERE c.uid = %d  AND n.nid=c.nid ORDER BY c.timestamp DESC',$id);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	for($i=0;$i<count($rows);$i++) {
		$comments[$i]['user'] = $rows[$i]['uid'];
		$comments[$i]['nid'] = $rows[$i]['nid'];
		$comments[$i]['created'] = $rows[$i]['timestamp'];
		$comments[$i]['extra'] = $rows[$i]['name'];
		$comments[$i]['action'] = 'r_idea_comments';
	}
	//print_r($comments);
	return $comments;
}

function profile_wall_comments($id) {
	$sql = db_query('SELECT * FROM {guestbook} WHERE recipient = %d ORDER BY created DESC',$id);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	for($i=0;$i<count($rows);$i++) {
		$comments[$i]['user'] = $rows[$i]['author'];
		$comments[$i]['created'] = $rows[$i]['created'];
		$comments[$i]['extra'] = $rows[$i]['recipient'];
		$comments[$i]['action'] = 'profile_comments';
	}
	//print_r($comments);
	return $comments;
}

function r_profile_wall_comments($id) {
	$sql = db_query('SELECT * FROM {guestbook} WHERE author = %d ORDER BY created DESC',$id);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	for($i=0;$i<count($rows);$i++) {
		$comments[$i]['user'] = $rows[$i]['author'];
		$comments[$i]['created'] = $rows[$i]['created'];
		$comments[$i]['extra'] = $rows[$i]['recipient'];
		$comments[$i]['action'] = 'r_profile_comments';
	}
	//print_r($comments);
	return $comments;
}

function profile_friends($id) {
	$sql = db_query('SELECT requester_id FROM {user_relationships} WHERE requestee_id = %d AND rtid=1 AND approved=1',$id);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	return $rows;
}

function user_fans($id) {
	$sql = db_query('SELECT * FROM {user_relationships} WHERE requester_id = %d AND rtid="2"',$id);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	for($i=0;$i<count($rows);$i++) {
		$fans[$i]['user'] = $rows[$i]['requester_id'];
		$fans[$i]['created'] = $rows[$i]['created_at'];
		$fans[$i]['extra'] = $rows[$i]['requestee_id'];
		$fans[$i]['action'] = 'fan';
	}
	return $fans;
}

function user_fans_reverse($id) {
	$sql = db_query('SELECT * FROM {user_relationships} WHERE requestee_id = %d AND rtid="2"',$id);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	for($i=0;$i<count($rows);$i++) {
		$rfans[$i]['user'] = $rows[$i]['requestee_id'];
		$rfans[$i]['created'] = $rows[$i]['created_at'];
		$rfans[$i]['extra'] = $rows[$i]['requester_id'];
		$rfans[$i]['action'] = 'rfan';
	}
	return $rfans;
}

function user_friend($id) {
	$sql = db_query('SELECT * FROM {user_relationships} WHERE requester_id = %d AND rtid="1"',$id);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	for($i=0;$i<count($rows);$i++) {
		$friends[$i]['user'] = $rows[$i]['requester_id'];
		$friends[$i]['created'] = $rows[$i]['created_at'];
		$friends[$i]['extra'] = $rows[$i]['requestee_id'];
		$friends[$i]['action'] = 'friend';
	}
	return $friends;
}

function user_friend_reverse($id) {
	$sql = db_query('SELECT * FROM {user_relationships} WHERE requestee_id = %d AND rtid="1"',$id);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	for($i=0;$i<count($rows);$i++) {
		$rfriends[$i]['user'] = $rows[$i]['requestee_id'];
		$rfriends[$i]['created'] = $rows[$i]['created_at'];
		$rfriends[$i]['extra'] = $rows[$i]['requester_id'];
		$rfriends[$i]['action'] = 'rfriend';
	}
	return $rfriends;
}

function user_views($uid) {
	$sql = db_query('SELECT data FROM {activity} WHERE  module = "useractivity" AND operation = "view"',$uid);
	while($row = db_fetch_array($sql)) {
		$row['data'] = unserialize($row['data']);
        $row['data']['aid'] 		= $row['aid'];
		$row['data']['uid'] 		= $row['uid'];
	    $row['data']['module'] 		= $row['module'];
	    $row['data']['type'] 		= $row['type'];
	    $row['data']['operation'] 	= ($row['data']['operation'] ? $row['data']['operation'] : $row['operation']);
	   $rows[] = $row;
	}
	foreach($rows as $item) {
		if($item['data']['target-uid'] == $uid) {
			$views[] = $item;
		}
	}
	 
	return $views;
}


function my_reviewed_words($uid) {
	$sql = db_query("SELECT * FROM {content_type_review} r,{node} n WHERE n.uid = %d AND r.field_nid_value = n.nid",$uid);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	for($i=0;$i<count($rows);$i++) {
		$reviews[$i]['user'] = $rows[$i]['uid'];
		$reviews[$i]['created'] = $rows[$i]['timestamp'];
		$reviews[$i]['extra'] = $rows[$i]['nid'];
		$reviews[$i]['action'] = 'review_word';
	}
	return $reviews;
}




function my_reviews($id) {
	$sql = db_query('SELECT * FROM {comments} WHERE uid = %d',$id);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	for($i=0;$i<count($rows);$i++) {
		$reviews[$i]['user'] = $rows[$i]['uid'];
		$reviews[$i]['created'] = $rows[$i]['timestamp'];
		$reviews[$i]['extra'] = $rows[$i]['nid'];
		$reviews[$i]['action'] = 'review';
	}
	return $reviews;
}



function my_reviewed($id) {
	$sql = db_query('SELECT c.uid,c.timestamp,c.nid FROM {comments} c,{node} n WHERE n.nid=c.nid AND n.uid = %d',$id);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	for($i=0;$i<count($rows);$i++) {
		$reviewed[$i]['user'] = $rows[$i]['uid'];
		$reviewed[$i]['created'] = $rows[$i]['timestamp'];
		$reviewed[$i]['extra'] = $rows[$i]['nid'];
		$reviewed[$i]['action'] = 'reviewed';
	}
	return $reviewed;
}

function my_favorites($id) {
	$sql = db_query('SELECT * FROM {favorite_nodes} WHERE uid = %d',$id);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	for($i=0;$i<count($rows);$i++) {
		$favorites[$i]['user'] = $rows[$i]['uid'];
		$favorites[$i]['created'] = $rows[$i]['last'];
		$favorites[$i]['extra'] = $rows[$i]['nid'];
		$favorites[$i]['action'] = 'favorite';
	}
	return $favorites;
}

function my_favorited($id) {
	$sql = db_query('SELECT f.uid,f.last,f.nid FROM {favorite_nodes} f,{node} n WHERE f.nid=n.nid AND n.uid = %d',$id);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	for($i=0;$i<count($rows);$i++) {
		$favorited[$i]['user'] = $rows[$i]['uid'];
		$favorited[$i]['created'] = $rows[$i]['last'];
		$favorited[$i]['extra'] = $rows[$i]['nid'];
		$favorited[$i]['action'] = 'favorited';
	}
	return $favorited;
}

function my_votes() {
	
}

function my_voted($id) {
	$sql = db_query('SELECT v.uid,v.timestamp,v.content_id,v.value FROM {votingapi_vote} v,{node} n WHERE v.content_id=n.nid AND n.uid = %d',$id);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	for($i=0;$i<count($rows);$i++) {
		$voted[$i]['user'] = $rows[$i]['uid'];
		$voted[$i]['created'] = $rows[$i]['timestamp'];
		$voted[$i]['extra'] = $rows[$i]['content_id'];
		$voted[$i]['vote'] = $rows[$i]['value'];
		$voted[$i]['vote'] = $voted[$i]['vote']/20;
		$voted[$i]['action'] = 'voted';
	}
	return $voted;
}

function node_author($id) {
	$sql = db_query('SELECT uid FROM {node} WHERE nid = %d',$id);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	return $rows['0']['uid'];
}
function other_words($uid,$nid) {
	$sql = db_query('SELECT * FROM {node} WHERE uid = %d AND nid!=%d AND type="word"',$uid,$nid);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
    return $rows;
}

function new_members() {
	global $user;
	$id = $user->uid;
	$sql = db_query('SELECT uid FROM {users} WHERE uid!=%d ORDER BY uid DESC LIMIT 10',$id);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	return $rows;
}

function new_words() {
	global $user;
	$id = $user->uid;
	$sql = db_query('SELECT nid,created,title FROM {node} WHERE uid!=%d AND type="word" AND status="1" ORDER BY nid DESC LIMIT 6',$id);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	return $rows;
}

function suggested_words($limit) {
	global $user;
	$id = $user->uid;
	// If limit isn't defined then set it to default at 12
  $limit = ($limit == null) ? 12: $limit;
  
  $sql = db_query('SELECT n.nid, n.created, n.title, f.* FROM {node} n LEFT JOIN {favorite_nodes} f ON n.nid=f.nid WHERE n.uid!=%d AND type ="word" AND status ="1" GROUP BY n.nid HAVING f.uid!=%d ORDER BY n.nid DESC LIMIT %d',$id,$id,$limit);
	while($row = db_fetch_array($sql)) {
	   // load the node. That way, we get a comment count, author details and the picture
	  $node = node_load($row['nid']);
	  
	  $node->rating = get_rating($node->nid);
	  
	  $nodes[] = $node;
	}
	return $nodes;
}

function my_latest_words($id) {
	$sql = db_query('SELECT nid,title FROM {node} WHERE uid = %d AND type="word" ORDER BY nid DESC LIMIT 5',$id);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	return $rows;
}

function all_members() {
	$sql = db_query('SELECT uid FROM {users} ORDER BY uid DESC');
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	return $rows;
}

function all_words() {
	$sql = db_query('SELECT nid FROM {node} WHERE  type="word" AND status="1" ORDER BY nid DESC ');
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	return $rows;
}


function most_popular() {
	$sql = db_query('SELECT c.nid FROM {node} n, {node_counter} c  WHERE n.type="word" AND n.status="1"  AND n.nid=c.nid ORDER BY c.totalcount DESC ');
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	return $rows;
}

function last_access() {
	$last_login = $GLOBALS['user']->last_login;
	return $last_login;
}

function new_requests() {
	global $user;
	$uid = $user->uid;
	$sql = db_query('SELECT * FROM {user_relationships} WHERE requestee_id = %d AND approved ="0" AND rtid="1"',$uid);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	for($i=0;$i<count($rows);$i++) {
		$requests[$i]['user'] .= $rows[$i]['requester_id'];
		$requests[$i]['action'] .= 'friend';
	}
	return $requests;
}

function my_alerts() {
	$requests  = new_requests();
	$items = $requests;
	foreach($items as $item) {
		$profile = '<a href="/'.user_username($item['user']).'">'.user_username($item['user']).'</a>';
		$alerts .= '<li>'.$profile.' has requested to be your friend. <a href="/relationships/requests">View</a></li>';
	}	
	return $alerts;
}


function last_comments() {
	global $user;
	$uid = $user->uid;
	foreach($items as $item) {
		$profile = '<a href="/'.user_username($item['user']).'">'.user_username($item['user']).'</a>';
		$alerts .= '<li>'.$profile.' has requested to be your friend. <a href="/relationships/requests">View</a></li>';
	}	
	return $alerts;
}


function search_author($author) {
	$sql = db_query("SELECT * FROM  {users} u, {profile_values} p WHERE u.name LIKE '%s%' OR p.value LIKE '%s%' AND p.uid = u.uid  GROUP BY p.uid ORDER BY u.uid DESC",$author,$author);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	//print_r($rows);
	return $rows;
}

function search_title($title) {
	$sql = db_query("SELECT * FROM {node} WHERE status='1' AND title LIKE '%s%' AND type='word' ",$title);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	return $rows;
}

function search_genre($genre) {
	$sql = db_query("SELECT tid FROM {term_data} WHERE name = '%s'",$genre);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	$g = $rows['0']['tid'];
	$sql = db_query("SELECT * FROM {node} n, {term_node} t WHERE n.status='1' AND t.nid = n.nid AND t.tid = '%d' AND n.type='word' GROUP BY n.nid",$g);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	return $rows;
}
function search_count() {
	$sql = db_query("SELECT * FROM {node} n, {node_counter} nc WHERE n.status='1' AND n.type='word' AND n.nid = nc.nid ORDER BY nc.totalcount DESC");
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	return $rows;
}

function publisher_reviews($id) {
	$sql = db_query("SELECT * FROM {node} WHERE status='1' AND uid= %d AND type='publisher_review'",$id);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	return $rows;
}

function favorite_authors($id) {
	$favs = my_favorites($id);
	foreach($favs as $fav) {
		$output .= '<li><a href="/'.user_username($fav['extra']).'">'.user_username($fav['extra']).'</a></li>';
	}
	return $output;
}

function publisher_favorite_words($id) {
	$favs = my_favorites($id);
	foreach($favs as $fav) {
		$output .= '<h4><a href="/node/'.$fav['extra'].'">'.node_title($fav['extra']).'</a></h4>
		<p class="storydate" style="margin-bottom:10px;">By <a href="/'.user_username($fav['user']).'">'.user_username($fav['user']).'</a> - '.count(get_node_comments($fav['extra'])).' comments</p>';
	}
	return $output;
}

function user_genres($id) {
	$sql = db_query("SELECT fid,value FROM {profile_values} WHERE uid= %d AND (fid='10' OR fid='11' OR fid='12' OR fid='13' OR fid='14' OR fid='15' OR fid='16' OR fid='17' OR fid='18' OR fid='19' OR fid='20' OR fid='21' OR fid='23') AND value='1' ",$id);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}

	if($rows) {
		$output ='<p>';
	foreach($rows as $row) {
		 $tid = genre_by_fid($row['fid']);
		 $output .='<a href="/taxonomy/term/'.$tid.'">'.term_name($tid).'</a><br/>';
	     }
        $output .='</p>';
    }
    return $output;
}
function field_name($id) {
	$sql = db_query("SELECT title FROM {profile_fields} WHERE fid= %d",$id);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	return $rows['0']['title'];
}

function term_name($id) {
	$sql = db_query("SELECT name FROM {term_data} WHERE tid= %d",$id);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	return $rows['0']['name'];
}

function genre_by_fid($fid) {
	switch($fid) {
		case '10':
			$tid = 1;
		break;
		case '11':
		    $tid = 4;
		break;
		case '12':
			$tid = 7;
		break;
		case '13':
			$tid = 10;
		break;
		case '14':
			$tid = 18;
		break;
		case '15':
			$tid = 5;
		break;
		case '16':
			$tid = 8;
		break;
		case '17':
			$tid = 11;
		break;
		case '18':
			$tid = 3;
		break;
		case '19':
			$tid = 6;
		break;
		case '20':
			$tid = 9;
		break;
		case '21':
			$tid = 12;
		break;
	}
	return $tid;
}


function is_publisher() {
	global $user;
	$uid = $user->uid;
	$roles = get_user_roles($uid);
	//print_r($roles);
	foreach($roles as $role) {
		if($role['rid']=='4') {
			$rid = 'publisher';

			} 
	}
	return $rid;
}

function check_is_publisher($id) {
	$roles = get_user_roles($id);
	foreach($roles as $role) {
		if($role['rid']=='4') {
			$rid = 'publisher';
			} 
	}
	return $rid;
}

function GetMonthString($n)
{
    $timestamp = mktime(0, 0, 0, $n, 1, 2005);
    
    return date("F", $timestamp);
}

function archives($id) {
	$sql = db_query("SELECT DATE_FORMAT(FROM_UNIXTIME(node.created), '%Y%m') AS created_year_month,
	   COUNT(node.nid) AS num_records
	 FROM node node 
	 WHERE (node.status <> 0) AND (node.type in ('blog')) AND node.uid = '$id'
	 GROUP BY created_year_month
	  ORDER BY created_year_month DESC
	");
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	if($rows) {
		$output = '<p>';
		foreach($rows as $row) {
			$year = substr($row['created_year_month'],0,4);
			$month = substr($row['created_year_month'],4,2);
			$month = GetMonthString($month);
			$output .= '<a href="/archive/'.$row['created_year_month'].'/'.$id.'">'.$month.' '.$year.'</a><br/>';
		}
	}
	$output .='</p>'; 
	
	return $output;
}
function supported_authors($id) {
	$sql = db_query("SELECT nid,title FROM {node} WHERE uid= %d AND type='supported_author'",$id);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	if($rows) {
		foreach($rows as $row) {
			$output .= '<a href="/node/'.$row['nid'].'">'.$row['title'].'</a>, ';
		}
	}
	return $output;
}

function books_published($id) {
	$sql = db_query("SELECT vid,nid,title FROM {node} WHERE uid= %d AND type='book_published'",$id);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	if($rows) {
		foreach($rows as $row) {
		  $node = node_load($row['nid']);

			$output .= '<li><div class="mainDetails">';
			$output .= '<h3>'.$row['title'].'</h3>
						<h4>Synopsis</h4>';
			$output .= neat_trim(get_revision($row['nid']),'80','...');
			$output .= '<p><a class="overviewLink" href="/node/'.$row['nid'].'">Read full synopsis</a></p>';
			$output .= '</div>';
			$output .= '<div class="sideDetails">';
			if($row->field_author_value=='1') {
				$output .= '<div class="bio_label">Author</div><div class="bio_data">'.$node->field_author[0]['value'].'</div>';
			}
			if($row->field_published_value=='1') {
				$output .= '<div class="bio_label">Date Published</div><div class="bio_data">'.$node->field_published[0]['value'].'</div>';
			}
			if($row->field_genre_value=='1') {
				$output .= '<div class="bio_label">Genre</div><div class="bio_data">'.$node->field_genre[0]['value'].'</div>';
			}			
			$output .= '</div></li>';
		}
	}
	return $output;
}

function books_published_list($id) {
	$sql = db_query("SELECT nid,title FROM {node} WHERE uid= %d AND type='book_published'",$id);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	if($rows) {
		$output .= '<ul>';
		foreach($rows as $row) {
			$output .= '<li><a href="/node/'.$row['nid'].'">'.$row['title'].'</a></li>';
		}
		$output .= '</ul>';
	}
	return $output;
}

function releases($id) {
	$sql = db_query("SELECT nid,title FROM {node} WHERE uid= %d AND type='release'",$id);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}	
	if($rows) {
		foreach($rows as $row) {
			$output .= '<li><div class="mainDetails">';
			$output .= '<h3>'.$row['title'].'</h3>
						<h4>Synopsis</h4>';
			$output .= neat_trim(get_revision($row['nid']),'300','...');
			$output .= '<p><a class="overviewLink" href="/node/'.$row['nid'].'">Read full synopsis</a></p>';
			$output .= '</div>';
			$output .= '<div class="sideDetails">';
			if($row->field_author_value=='1') {
				$output .= '<div class="bio_label">Author</div><div class="bio_data">'.$row['field_author_value'].'</div>';
			}
			if($row->field_published_value=='1') {
				$output .= '<div class="bio_label">Release Date</div><div class="bio_data">'.$row['field_published_value'].'</div>';
			}
			if($row->field_genre_value=='1') {
				$output .= '<div class="bio_label">Genre</div><div class="bio_data">'.$row['field_genre_value'].'</div>';
			}			
			$output .= '</div></li>';
		}
	}
	return $output;
}

function releases_list($id) {
	$sql = db_query("SELECT nid,title FROM {node} WHERE uid= %d AND type='release'",$id);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	if($rows) {
		$output .= '<ul>';
		foreach($rows as $row) {
			$output .= '<li><a href="/node/'.$row['nid'].'">'.$row['title'].'</a></li>';
		}
		$output .= '</ul>';
	}
	return $output;
}

function authors_love($id) {
   $authors = my_favorites($id);
 
   if($authors) {
		$output .= '<ul>';
			foreach($authors as $author) {
				$output .= '<li>'.user_username($author['extra']).'</li>';
			}
		$output .= '</ul>';
   }
return $output;	
}

function pub_reviews($id) {
	$sql = db_query("SELECT n.nid,n.title,n.uid FROM {node} n, {content_type_review} r WHERE n.uid= %d AND n.type='review' AND n.status = '1' AND n.nid = r.nid ",$id);
	while($row = db_fetch_array($sql)) {
	    // We should do a node_load here instead for each result we return.
	    // Now the entire review is exposed to us 
	   $rows[] = node_load($row['nid']);
	}
	if($rows) {
		$output .= '<ul class="pubFeeds">';
		foreach($rows as $row) {
			$output .= '<li><div class="overviewLeft">';
			$output .= '<h3>'.$row->field_word[0]['value'].' <span>';
			//$output .= t("by  !author.", array('!author' => l($row->name, "user/$row->uid")));
			$output .= '</span></h3>';
			//$output .= neat_trim(strip_tags(get_revision($row[0])),'500','...');
			//$output .= neat_trim(get_revision($row['nid']),'800','...');
			$output .= '<p>' . ($row->body) . '</p>';
			$output .= $content;
			$output .= '</div><div class="overviewRight">';
			//Date, ratings and genre need to here
			
			// Date
			$output .= '<p>' . format_date($row->created, 'small') . '</p>';
			// Genres
			$output .= '<p>';
			  foreach(taxonomy_node_get_terms_by_vocabulary($row->field_nid[0]['value'], 1) as $key => $value) {
			    $output .= '<span>' . $value . '</span>';
			  }
      $output .= '</p>';
      
      // Rating
      $output .= '<p>';
      $rating = db_fetch_object(db_query('SELECT value FROM {votingapi_vote} WHERE content_id = %d AND uid = %u',$id,$row->uid));
      $output .= theme_fivestar_static($rating->value);
      $output .= '</p>';
      
			$output .= '<p><a class="overviewLink" href="/node/'. $row>nid .'">View this piece</a></p>';
			$output .= '</div></li>';
		}
		$output .= '</ul>';
	}
	return $output;
}

function pub_reviews_overview($id) {
	$sql = db_query("SELECT n.nid,n.title,n.uid FROM {node} n, {content_type_review} r WHERE n.uid= %d AND n.type='review' AND n.status = '1' AND n.nid = r.nid LIMIT 1",$id);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	if($rows) {
		foreach($rows as $row) {
			$output .= '<div class="overviewLeft">
						<h4>'.$row['title'].'</h4>';
			$output .= neat_trim(get_revision($row['nid']),'500','...');
			$output .= '</div>
						<p class="overviewRight"><a href="/node/'.$row['nid'].'">Read review</a> &raquo</p>';
			$output .= '<p><a class="overviewLink" href="/publisher-review/&amp;uid='.$row['uid'].'" title="View all reviews">View all reviews &raquo;</a></p>';
		}
	}
	return $output;
}

function pub_blog_overview($id) {
	$sql = db_query("SELECT DISTINCT n.nid,n.title,n.uid FROM {users} u INNER JOIN {node} n ON n.uid = %d WHERE n.type = 'blog' ORDER BY u.name LIMIT 1",$id);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	
	if($rows) {
		foreach($rows as $row) {
			$output = '<div class="overviewLeft">
						<h4>'.$row['title'].'</h4>';
			$node = node_load($row['nid']);
			$output .= neat_trim(strip_tags(get_revision($row['nid'])),'500','...');
			$output .= '</div>
						<p class="overviewRight"><a href="/node/'.$row['nid'].'">Read article</a> &raquo</p>';
			$output .= '<p><a class="overviewLink" href="/blogs/'.$row['uid'].'" title="Visit blog">Visit blog &raquo;</a></p>';
		}
	}

	return $output;
}

function pub_events($id) {
	$today = date("Y-m-d H:i:s");
	$sql = db_query("SELECT n.nid,e.event_start,n.title FROM {node} n, {event} e WHERE n.status = '1' AND n.nid = e.nid  AND n.uid = %d AND e.event_start >= '%s' ORDER BY e.event_start DESC",$id,$date);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	if($rows) {
		//print_r($rows);
		$y = date('Y');
		$m = date('m');
		$d = date('d');
		
		//print $d;
		
		foreach($rows as $row) {
			$month = substr($row['event_start'],5,2);
			$year = substr($row['event_start'],0,4);
			$day = substr($row['event_start'],8,2);
			//print $month;print $year;print $day;
			if($year>=$y && $month>=$m) {
				$output .= '<p><a href="/node/'.$row['nid'].'"><strong>'.date('d F Y',strtotime($row['event_start'])).'</strong></a><br/>';
				$output .= $row['title'];
				$output .= '</p>';
			}
			
		}
	}
	return $output;
}
function user_by_name($name) {
	$sql = db_query("SELECT uid FROM {users} WHERE name = '%s'",$name);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
    return $rows['uid'];
}

function clean_user($str) {
	$str = str_replace('.','',$str);
	$str = str_replace('_','',$str);
	//$str = str_replace('-','',$str);
	return $str;
}
function my_interests($id) {
	$sql = db_query("SELECT uid,fid FROM {profile_values} WHERE uid ='$id' AND ( fid>='11' AND fid<='21') AND value = '1'",$id);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
    return $rows;
}

function suggested_users($id) {
	$mine = my_interests($id);
	global $user;
	$my_id = $user->uid;
	foreach($mine as $item) { 
		$fid = $item['fid'];
		$sql = db_query("SELECT uid,fid FROM {profile_values} WHERE fid = '$fid' AND value = '1' AND uid<>%d GROUP BY uid DESC",$id,$my_id);
		while($row = db_fetch_array($sql)) {
		   $rows[] = $row;
		}
    }
    //print_r($rows);
    return $rows;
}

function get_guestbook($id) {
	$sql = db_query("SELECT message FROM {guestbook} WHERE id = %d",$id);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
    return $rows['0']['message'];
}
function update_guestbook($form) {
	global $user;
	$name = $user->name;
	$id = $form['id'];
	$message = $form['comment'];
	$dest = $_GET['destination'];
	db_query("UPDATE {guestbook} set message='%s' WHERE id=%d",$message,$id) or die(mysql_error());
	drupal_set_message(t('Your comment has been moderated'));
	//print_r($_SERVER);exit;
	drupal_goto($dest);
}
function delete_guestbook($id) {
	db_query("DELETE FROM {guestbook} WHERE id=%d",$id) or die(mysql_error());
	drupal_set_message(t('Your comment has been deleted'));
}

function guestbook_recipient($id) {
	$sql = db_query("SELECT recipient FROM {guestbook} WHERE id = %d",$id);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
    return $rows['0']['recipient'];
}

function profile_comments_last_access() {
	global $user;
	$uid = $user->uid;
	//print $uid;
	//$access = last_access();
	$access = $user->access;
	$login = $user->login;
	
	//print $access;
	//print $login;
	
	
	$sql = db_query("SELECT * FROM {guestbook} WHERE recipient = %d AND created >='%s'",$uid,$access);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	if($rows):
	foreach($rows as $row) {
		
		$comments .= '<li><a href="/'.user_username($row['author']).'">'.user_username($row['author']).'</a> has commented on your profile.</li>';
	   
	} endif;
	//print_r($comments);
	return $comments;
}
function get_ideas_last_comment() {
	global $user;
	$uid = $user->uid;
	$last = $user->last_login;
	$now = time();
	//print date('d M Y H:i',$now);
	$access = last_access();
	//print date('d M Y h:i',$access);
	$sql = db_query("SELECT * FROM {comments} c,{node} n WHERE n.uid = %d AND c.nid = n.nid AND c.timestamp >'%s",$uid,$access);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
    foreach($rows as $row) {
		$output .= '<li><a href="/'.$row['name'].'">'.$row['name'].'</a> has commented on your idea <a href="/node/'.$row['nid'].'">'.node_title($row['nid']).'</a></li>';
	}
	return $output;
}

function node_tags($id) {
	$sql = db_query("SELECT n.tid,d.name FROM {term_node} n, {term_data} d WHERE nid = %d AND d.tid=n.tid GROUP BY n.tid",$id);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
    return $rows;
}


function last_logout() {
	global $user;
	$sql = db_query("SELECT time FROM {logout} WHERE uid = %d ORDER BY id DESC LIMIT 1",$user->uid);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
    return strtotime($rows['0']['time']);
}



function get_last_friends() {
	global $user;
	$uid = $user->uid;
	$access = last_logout();
	//print date('d M Y H:i',$access);
	$sql = db_query("SELECT * FROM {user_relationships} WHERE requestee_id = %d AND created_at > %d",$uid,$access);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
    if($rows) {
	    if(count($rows)==1) { $str = 'friend has';} else { $str = 'friends have';}
		$output .= '<li>'.count($rows).' '.$str.'  added you</li>';
	}
	return $output;
}


function get_age($Birthdate)

{

        // Explode the date into meaningful variables

        list($BirthYear,$BirthMonth,$BirthDay) = explode("-", $Birthdate);

        // Find the differences

        $YearDiff = date("Y") - $BirthYear;


        $DayDiff = date("d") - $BirthDay;

        // If the birthday has not occured this year

        if ($DayDiff < 0 || $MonthDiff < 0)

          $YearDiff--;

        return $YearDiff;

}

function genres_of_interest($uid) {
	$details = user_load($uid);
	$output .='<ul id="genresOfInterest">';
	if($details->general_fiction=='1') {
		$output .='<li><a href="/taxonomy/term/1" title="General Fiction">General Fiction</a></li>';
	} 
	if($details->essay=='1') {	
		$output .='<li><a href="/taxonomy/term/4" title="Essay">Essay</a></li>';
	}
	if($details->children_and_teens=='1') {
		$output .='<li><a href="/taxonomy/term/7" title="Children and Teens">Children and Teens</a></li>';
	}
	if($details->horror=='1') {
		$output .='<li><a href="/taxonomy/term/10" title="Horror">Horror</a></li>';
	}
	if($details->short_stories=='1') {
		$output .='<li><a href="/taxonomy/term/2" title="Short Stories">Short Stories</a></li>';
	}
	if($details->adventure=='1') {
		$output .='<li><a href="/taxonomy/term/5" title="Adventure">Adventure</a></li>';
	}
	if($details->crime_and_mystery=='1') {
		$output .='<li><a href="/taxonomy/term/8" title="Crime and Mystery">Crime and Mystery</a></li>';
	}
	if($details->romance=='1') {
		$output .='<li><a href="/taxonomy/term/11" title="Romance">Romance</a></li>';
	}
	if($details->poetry=='1') {
		$output .='<li><a href="/taxonomy/term/3" title="Poetry">Poetry</a></li>';
	}
	if($details->thriller=='1') {		
		$output .='<li><a href="/taxonomy/term/6" title="Thriller">Thriller</a></li>';
	}
	if($details->comedy=='1') {		
		$output .='<li><a href="/taxonomy/term/9" title="Comedy">Comedy</a></li>';
	}
	if($details->science_fiction_fantasy=='12') {
		$output .='<li><a href="/taxonomy/term/1" title="Science Fiction and Fantasy">Science Fiction and Fantasy</a></li>';
	}
	$ouput .='</ul>';
	return $output;
}

function extended_bio($uid) {
	$details = user_load($uid);
	//print_r($details);
	$b_year = $details->dob['year'];
	$b_month = $details->dob['month'];
	if($b_month < 10) {
		$b_month = '0'.$b_month.'';
	}
	$b_day = $details->dob['day'];
	if($b_day < 10) {
		$b_day = '0'.$b_day.'';
	}
	$birthdate = ''.$b_year.'-'.$b_month.'-'.$b_day.'';
	


	$age = get_age($birthdate);
	
	if(check_is_publisher($uid)):
		$url = publisher_url($uid);
	endif;

	
	if($details->display_age=='1') {
		$output .='<div class="bio_label">Age</div><div class="bio_data">'.$age.'</div>';
	}
	$output .= '<div class="bio_label">Genres of Interest</div><div class="bio_data">';
	if($details->general_fiction=='1') {
		$output .='General Fiction, ';
	} 
	if($details->essay=='1') {
	
		$output .='Essay, ';
	}
	if($details->children_and_teens=='1') {

		$output .='Children and Teens, ';
	}
	if($details->horror=='1') {

		$output .='Horror, ';
	}
	if($details->short_stories=='1') {

		$output .='Short Stories, ';
	}
	if($details->adventure=='1') {

		$output .='Adventure, ';
	}
	if($details->crime_and_mystery=='1') {

		$output .='Crime and Mystery, ';
	}
	if($details->romance=='1') {

		$output .='Romance, ';
	}
	if($details->poetry=='1') {

		$output .='Poetry, ';
	}
	if($details->thriller=='1') {
		
		$output .='Thriller, ';
	}
	if($details->comedy=='1') {
		
		$output .='Comedy, ';
	}
	if($details->science_fiction_fantasy=='1') {
		$output .='Science Fiction and Fantasy, ';
	}
	$output .='</div>';
	
	if($details->fav_authors):
		$output .= '<div class="bio_label">Favourite Authors</div><div class="bio_data">'.$details->fav_authors.'</div>';
	endif;
	
	if($details->fav_books):
		$output .= '<div class="bio_label">Favourite Books</div><div class="bio_data">'.$details->fav_books.'</div>';
	endif;
	
	if($details->fav_quotes):
		$output .= '<div class="bio_label">Favourite Quotations</div><div class="bio_data">'.$details->fav_quotes.'</div>';
	endif;
	
	if($url):
		$output .= '<div class="bio_label">Website</div><div class="bio_data"><a href="'.$url.'" target="_blank">'.$url.'</a></div>';
	endif;
	$output .= '<br/>';
	
	return $output;
}

function get_publisher_totalvotes($id) {
	$sql = db_query("SELECT sum(vote) FROM {publisher_rating} WHERE nid = %d",$id);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
    return $rows;
}

function get_publisher_numvotes($id) {
	$sql = db_query("SELECT count(vote) FROM {publisher_rating} WHERE nid = %d",$id);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
    return $rows;
}

function get_publisher_uids($id) {
	$sql = db_query("SELECT vote FROM {publisher_rating} WHERE nid = %d GROUP BY uid",$id);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
    return $rows;
}


function publisher_banner($id) {
	$sql = db_query("SELECT nid FROM {node} WHERE uid = %d AND type='banner' ORDER BY nid DESC LIMIT 1",$id);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
    return $rows['0']['nid'];
}

function publisher_banner_file($id) {
	
	$nid = publisher_banner($id);
	
	$sql = db_query("SELECT filepath FROM {files} f, {content_type_banner} b WHERE b.field_banner_fid = f.fid AND b.nid = %d",$nid);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
    return $rows['0']['filepath'];
}

function twitter_username($id) {
	$fid = 27;
	$sql = db_query("SELECT value FROM {profile_values} WHERE uid = %d AND fid = %d",$id,$fid);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
    return $rows['0']['value'];
}

function check_friend($id,$req) {
	$sql = db_query('SELECT requester_id FROM {user_relationships} WHERE requestee_id = %d AND rtid=1 AND approved=1 AND requester_id = %d',$id,$req);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	return $rows['0']['requester_id'];
}

function friend_user($id) {
	global $user;
	$request = check_friend($user->uid,$id);
	if($user->uid!=0):
		// Check if he user page is my own page
		if($user->uid != $id) {
			// Checks if user is already in my friends list.
			if(!$request) {
				$output = '<a class="user_relationships_popup_link" href="/relationship/'.$id.'/request/1?destination=user/'.$uid.'">
					   <img src="/sites/all/themes/bookbloc/images/friend-user.jpg" alt="" class="add_friend"/></a>';
			} else {
				$output = '<span class="add_friend"><img src="/sites/all/themes/bookbloc/images/added.gif"/></span>';
			}
		}
	endif;
	return $output;
}

function publisher_url($id) {
	$fid = 28;
	$sql = db_query("SELECT value FROM {profile_values} WHERE uid = %d AND fid = %d",$id,$fid);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
    $url = $rows['0']['value'];
    if($url):
    if(substr($url,0,7) == 'http://') {
		$url = $url;
    } else {
		$url = 'http://'.$url.'';
    }
   endif;
    return $url;
}
function get_genre_updates($id) { 
   // Query Genre_Log Database to get all values
   // Filter logs with one that match my fav genre
    $genres = user_main_genres($id);
    //print_r($genres);
   	$sql = db_query("SELECT * FROM {genre_log} ORDER BY id DESC");
	while($row = db_fetch_array($sql)) {
	   $row['genre'] = genre_id_from_name($row['genre']);
	   if($row['genre'] && $row['uid']!=$id) {
		    if(in_array($row['genre'],$genres)) {
	   			$rows[] = $row;
			}
       }
	}
	
	// Generate Pigeonhole array
	for($i=0;$i<count($rows);$i++) {
		$genre_updates[$i]['user'] = $rows[$i]['uid'];
		$genre_updates[$i]['created'] = $rows[$i]['created'];
		$genre_updates[$i]['extra'] = $rows[$i]['nid'];
		$genre_updates[$i]['action'] = 'fav_genre';
		$genre_updates[$i]['genre'] = $rows[$i]['genre'];
	}
	//print_r($genre_updates);
	return $genre_updates;
}
function user_main_genres($id) {
	$sql = db_query("SELECT fid FROM {profile_values} WHERE uid= %d AND (fid='10' OR fid='11' OR fid='12' OR fid='13' OR fid='14' OR fid='15' OR fid='16' OR fid='17' OR fid='18' OR fid='19' OR fid='20' OR fid='21' OR fid='23') AND value='1' ",$id);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row['fid'];
	}
	return $rows;
}
function genre_id_from_name($name) {
	$sql = db_query("SELECT fid FROM {profile_fields} WHERE title= '%s'",$name);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	return $rows['0']['fid'];
}
function genre_from_id($id) {
	$sql = db_query("SELECT title FROM {profile_fields} WHERE fid= '%d'",$id);
	while($row = db_fetch_array($sql)) {
	   $rows[] = $row;
	}
	return $rows['0']['title'];
}
function send_email($params) {
	
	$to = $params['context']['account']->mail;
	$subject = $params['context']['node']->title;
	$message = $params['context']['node']->body;
	$message = str_replace('src="','src="http://'.$_SERVER['SERVER_NAME'].'',$message);
	
  	$msg = '<div style="border:1px solid #4aa876;width:680px">
			<table width="761">
		    	<tr border="0">
					<td align="left" border="0">
						<img src="http://bookbloc.com/newsletter/new_head.gif" style="position:relative;margin-top:10px;margin-left:10px;"/>
					</td>
				</tr>
                <tr>
					<td style="color:#555555;padding:20px;">
					    <h1 style="color:#4aa876">Bookbloc Newsletter</h1>
             			'.$message.'
 						 <p>&nbsp;</p>
             			 <p>Best regards,<br/>The Bookbloc Team</p>
 			    	</td>
			    </tr>
		     <tr border="0">
		  			<td border="0">
						
				    </td>
			</tr>
		  </table>
		</div>
    ';

  // To send HTML mail, the Content-type header must be set
  $headers  = 'MIME-Version: 1.0' . "\r\n";
  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

  // Additional headers
  $headers .= 'To: Bookbloc <no-reply@bookbloc.com>' . "\r\n";
  $headers .= 'From: Bookbloc <no-reply@bookbloc.com>' . "\r\n";

  // Mail it
  $mail = mail($to, $subject, $msg, $headers);
  if($mail) {
	
  }
}

function number_of_words($uid) {
	$sql = db_query("SELECT COUNT(*) AS n FROM node WHERE type = 'word' AND uid = %d",$uid);
	$row = db_fetch_array($sql);	   
	return $row['n'];
}

?>
