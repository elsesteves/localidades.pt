<?php

require_once __DIR__.'/../inc/bootstrap.php';
require_once __DIR__.'/../inc/functions.php';

$lang_id = 2;//PT
$module = "md_eventos";
$baseURL = "https://viralagenda.com";

$patterns = array();
$patterns['event']['text'] = '/<div class="viral-event-description box" itemprop="description">
			<div class="container"(.*?)>
				
					<pre>((.|\s)*?)<\/pre>
							<\/div>
			<a class="expand/';
$patterns['event']['image+title'] = '/<img data-width="(.*?)" data-height="(.*?)" data-top="(.*?)" data-left="(.*?)" src="(.*?)" alt="(.*?)" class="cover-image">/m';
$patterns['event']['types'] = '/<div class="symbol"><span class="simple-icon simple-line-icons-(.*?)"><\/span><\/div>
											<div class="left">
							<a id="event-cat-(.*?)" title="Ver eventos desta categoria" href="(.*?)">
								<span>(.*?)<\/span>
							<\/a>
						<\/div/m';

$patterns['event']['dates']['dt_start'] = '/<script>
					const config = {((\s|.)*?)
						startDate: "(.*?)",/m';
$patterns['event']['dates']['dt_end'] = '/<script>
					const config = {((\s|.)*?)
						endDate: "(.*?)",/m';
$patterns['event']['dates']['time_start'] = '/<script>
					const config = {((\s|.)*?)
						startTime: "(.*?)",/m';
$patterns['event']['dates']['time_end'] = '/<script>
					const config = {((\s|.)*?)
						endTime: "(.*?)",/m';

$patterns['event']['dates']['location'] = '/<script>
					const config = {((\s|.)*?)
						location: "(.*?)",/m';


$patterns['event']['pricing'] = '/<div class="viral-event-price box">
			
				<div class="symbol"><span class="icon icon-34_icone_ticket"><\/span><\/div>
				<div class="text"><span>(.*?)<\/span><\/div>
						
		<\/div>/m';

$patterns['list']['events'] = '/<li itemscope itemtype="(.*?)" id="(.*?)" data-id="(.*?)" data-url="(.*?)"(.*?)<\/li>/m';


$typesMap = array(
	"4" => 1,
	"2" => 2,
	"1" => 3,
	"10" => 4,
	"8" => 5,
	"15" => 6,
	"33" => 7,
	"11" => 8,
	"13" => 9,
	"94" => 10,
	"9" => 11,
	"5" => 12,
	"3" => 13,
	"34" => 14,
	"6" => 15,
	"12" => 16,
	"70" => 17,
	"18" => 18,
	"14" => 19,
	"35" => 20,
	"17" => 21,
	"16" => 22,
	"19" => 23,
	"69" => 24,
);

function getEventData($url, $id_distrito, $id_concelho) {
	global $patterns, $typesMap;
	$page = crawlPage($url);

	$data = array(
		"title" => null,
		"id_distrito" => $id_distrito,
		"id_concelho" => $id_concelho,
		"scraped_url" => $url,
		"img" => null,
		"text" => null,
		"start" => array(
			"date" => null,
			"time" => null,
		),
		"end" => array(
			"date" => null,
			"time" => null,
		),
		"location" => null,
		"gps" => array(
			"lon" => null,
			"lat" => null,
		),
		"types" => array(),
	);

	preg_match($patterns['event']['text'], $page, $match);

	if (exists($match[2])) {
		$data['text'] = $match[2]; 
	}

	preg_match($patterns['event']['image+title'], $page, $match);

	if (exists($match[5])) {
		$data['img'] = $match[5]; 
	}
	if (exists($match[6])) {
		$data['title'] = $match[6]; 
	}

	preg_match_all($patterns['event']['types'], $page, $matches, PREG_SET_ORDER, 0);
	if (exists($matches)) {
		foreach($matches as $match) {
			if (exists($match[2]) && exists($match[4])) {
				$data['types'][] = array(
					"id" => $typesMap[$match[2]],
					"name" => $match[4],
				);
			}
		}
	}

	preg_match($patterns['event']['dates']['dt_start'], $page, $match);
	if(exists($match[3])) {
		$data['start']['date'] = $match[3];	
	}

	preg_match($patterns['event']['dates']['time_start'], $page, $match);
	if(exists($match[3])) {
		$data['start']['time'] = $match[3];
	}

	preg_match($patterns['event']['dates']['dt_end'], $page, $match);
	if(exists($match[3])) {
		$data['end']['date'] = $match[3];
	}

	preg_match($patterns['event']['dates']['time_end'], $page, $match);
	if(exists($match[3])) {
		$data['end']['time'] = $match[3];
	}

	if (!exists($data['start']) || !exists($data['end'])) {
		print "CHECK DATES: $url\n\n";
	}

	preg_match($patterns['event']['dates']['location'], $page, $match);
	if(exists($match[3])) {
		$data['location'] = $match[3];
	}

	preg_match($patterns['event']['pricing'], $page, $match);
	if(exists($match[1])) {
		$data['pricing'] = $match[1];
	}	

	$additionalData = getAdditionalEventData($url.'/map');

	if (exists($additionalData["events_pages"][0]['latitude'])) {
		$data['gps']['lat'] = $additionalData["events_pages"][0]['latitude'];
	}

	if (exists($additionalData["events_pages"][0]['longitude'])) {
		$data['gps']['lon'] = $additionalData["events_pages"][0]['longitude'];
	}

	return $data;
}


function getAdditionalEventData($url) {
	global $patterns;

	$post = array("ajax" => 1);	
	$ajax = crawlPage($url, array("post_fields" => $post));

	$data = json_decode($ajax, true);

	return $data;
}

function getEventFromList($distrito, $concelho, $id_distrito, $id_concelho) {
	global $patterns, $baseURL;

	$events = array();

	$perPage = 20;
	$page = 0;
	$reachedPastEvents = false;

	while (!$reachedPastEvents) {
		$url = $baseURL.'/pt/'.\Data\Str::permalink_clean($distrito).'/'.\Data\Str::permalink_clean($concelho).'?ajax=1&page='.$page.'&perpage='.$perPage.'&past=0';
		
		$json = file_get_contents($url);
	    $data = json_decode($json, true);


	    if(exists($data['html'])) {
	    	$eventsString = explode('<li class="viral-event-past"><div class="viral-event-past-text"><span>Passados</span></div></li>', $data['html']);

	    	preg_match_all($patterns['list']['events'], $eventsString[0], $matches, PREG_SET_ORDER, 0);

	    	if (exists($matches)) {
	    		foreach($matches as $match) {
	    			if(exists($match[4])) {    				
	    				$events[] = getEventData($baseURL.$match[4], $id_distrito, $id_concelho);
	    			}
	    		}
	    	}

	    	if($eventsString[1]) {
	    		$reachedPastEvents = true;
	    	}

	    } else {
	    	$reachedPastEvents = true;
	    }

		$page += $perPage;
	}
	
    
    return $events;
}



//$events = getEventFromList('https://www.viralagenda.com/pt/lisboa/amadora?ajax=1&page=0&perpage=20&past=0');
//dd($events);

//dd(getEventData('https://www.viralagenda.com/pt/events/1341649/stand-up-city-club', 0, 0));

$sql = "SELECT dist.id AS id_distrito, dist.name AS distrito, conc.id AS id_concelho, conc.name AS concelho 
		FROM md_localidades AS conc 
		INNER JOIN md_localidades AS dist 
			ON dist.id_type = 1 
			AND conc.parent = dist.id 
		WHERE conc.id_type = 2";

$rows = \DB::results($sql);


$events = array();
foreach($rows as $row) {
	$municipalityEvents = getEventFromList($row['distrito'], $row['concelho'], $row['id_distrito'], $row['id_concelho']);
	$events = array_merge($events, $municipalityEvents);

	//print "\n\n". $row['distrito'] . ' | ' . $row['concelho'] ."\n";
	//var_dump($municipalityEvents);
	foreach($municipalityEvents as $event) {
		if (checkEventExists($event['scraped_url'], $id_event)) {
			updateEvent($id_event, $event);
		} else {
			insertEvent($event);
		}
	}
}

dd($events);

function checkEventExists($url, &$id_event = '') {
	$sql = "SELECT id
			FROM md_eventos
			WHERE url_scraped = '".\DB::escape_string($url)."'";

	$row = \DB::results($sql, true);

	if (exists($row['id'])) {
		$id_event = $row['id'];
		return true;
	}

	return false;
}


function insertEvent($row) {
	global $lang_id;

	$name = \DB::escape_string($row['title']);

	$id_distrito = $row['id_distrito'];
	$id_concelho = $row['id_concelho'];

	if(exists($row['gps']['lat']) && exists($row['gps']['lon'])) {
		$localidade = findLocalidadeByGPSCoords($row['gps']['lat'], $row['gps']['lon']);

		if (exists($localidade['freguesia'])) {
			$id_freguesia = findLocalidadeID($localidade['freguesia'], array("id_type" => 3, "parent" => $id_concelho));
		}

		if (exists($localidade['codigo_postal'])) {
			$zipCode = $localidade['codigo_postal'];
		}
	}
	
	$timeStamp = \Data\Date::currentTimeStamp();
	$sql = "INSERT INTO md_eventos SET
				dt_intro = '{$timeStamp}',
				dt_lastmod = '{$timeStamp}',
				active = 1,
				name = '{$name}'";

	if(exists($id_distrito)) {
		$sql .= ", id_distrito = $id_distrito";
	}
	if(exists($id_concelho)) {
		$sql .= ", id_concelho = $id_concelho";
	}
	if(exists($id_freguesia)) {
		$sql .= ", id_freguesia = $id_freguesia";
	}

	if (exists($row['location'])) {
		$address = $row['location'];
		if (exists($localidade['rua'])) {
			$address .= ', '.$localidade['rua'];
		}

		$sql .= ", address = '".\DB::escape_string($address)."'";
	}

	if (exists($zipCode)) {
		$sql .= ", zip_code = '".\DB::escape_string($zipCode)."'";
	}

	if (exists($row['gps']['lat']) && exists($row['gps']['lon'])) {
		$sql .= ", gps = ST_GeomFromText('POINT(".$row['gps']['lon']." ".$row['gps']['lat'].")')";
	}

	if (exists($row['scraped_url'])) {
		$sql .= ", url_scraped = '".\DB::escape_string($row['scraped_url'])."'";
	}

	if (exists($row['img'])) {
		$sql .= ", ext_img_url = '".\DB::escape_string($row['img'])."'";
	}

	if (exists($row['pricing'])) {
		$sql .= ", pricing = '".\DB::escape_string($row['pricing'])."'";
	}

	if (exists($row['start']['date'])) {
		$sql .= ", dt_start = '".\DB::escape_string($row['start']['date'])."'";
	}

	if (exists($row['end']['date'])) {
		$sql .= ", dt_end = '".\DB::escape_string($row['end']['date'])."'";
	}

	if (exists($row['start']['time'])) {
		$sql .= ", time_start = '".\DB::escape_string($row['start']['time']).":00'";
	}

	if (exists($row['end']['time'])) {
		$sql .= ", time_end = '".\DB::escape_string($row['end']['time']).":00'";
	}

	if(\DB::run($sql)) {
		$id_parent = DB::last_insert_id();

		print "ADDED EVENT ID: ".$id_parent.";\n\n";

		$timeStamp = \Data\Date::currentTimeStamp();
		$sql = "INSERT INTO md_eventos_lang SET
					dt_intro = '{$timeStamp}',
					dt_lastmod = '{$timeStamp}',
					id_lang = $lang_id,
					parent = $id_parent,
					title = '".$name."',
					active = 1";

		if (exists($row['text'])) {
			$sql .= ", description = '".\DB::escape_string($row['text'])."'";
		}

		\DB::run($sql);

		manageEventTypes($id_parent, $row['types']);
	}
}


function updateEvent($id_event, $row) {
	global $lang_id;

	$name = \DB::escape_string($row['title']);

	$id_distrito = $row['id_distrito'];
	$id_concelho = $row['id_concelho'];

	if(exists($row['gps']['lat']) && exists($row['gps']['lon'])) {
		$localidade = findLocalidadeByGPSCoords($row['gps']['lat'], $row['gps']['lon']);

		if (exists($localidade['freguesia'])) {
			$id_freguesia = findLocalidadeID($localidade['freguesia'], array("id_type" => 3, "parent" => $id_concelho));
		}

		if (exists($localidade['codigo_postal'])) {
			$zipCode = $localidade['codigo_postal'];
		}
	}
	
	$timeStamp = \Data\Date::currentTimeStamp();
	$sql = "UPDATE md_eventos SET
				dt_lastmod = '{$timeStamp}',
				active = 1,
				name = '{$name}'";

	if(exists($id_distrito)) {
		$sql .= ", id_distrito = $id_distrito";
	}
	if(exists($id_concelho)) {
		$sql .= ", id_concelho = $id_concelho";
	}
	if(exists($id_freguesia)) {
		$sql .= ", id_freguesia = $id_freguesia";
	}

	if (exists($row['location'])) {
		$address = $row['location'];
		if (exists($localidade['rua'])) {
			$address .= ', '.$localidade['rua'];
		}

		$sql .= ", address = '".\DB::escape_string($address)."'";
	}

	if (exists($zipCode)) {
		$sql .= ", zip_code = '".\DB::escape_string($zipCode)."'";
	}

	if (exists($row['gps']['lat']) && exists($row['gps']['lon'])) {
		$sql .= ", gps = ST_GeomFromText('POINT(".$row['gps']['lon']." ".$row['gps']['lat'].")')";
	}

	if (exists($row['scraped_url'])) {
		$sql .= ", url_scraped = '".\DB::escape_string($row['scraped_url'])."'";
	}

	if (exists($row['img'])) {
		$sql .= ", ext_img_url = '".\DB::escape_string($row['img'])."'";
	}

	if (exists($row['pricing'])) {
		$sql .= ", pricing = '".\DB::escape_string($row['pricing'])."'";
	}

	if (exists($row['start']['date'])) {
		$sql .= ", dt_start = '".\DB::escape_string($row['start']['date'])."'";
	}

	if (exists($row['end']['date'])) {
		$sql .= ", dt_end = '".\DB::escape_string($row['end']['date'])."'";
	}

	if (exists($row['start']['time'])) {
		$sql .= ", time_start = '".\DB::escape_string($row['start']['time']).":00'";
	}

	if (exists($row['end']['time'])) {
		$sql .= ", time_end = '".\DB::escape_string($row['end']['time']).":00'";
	}

	$sql .= " WHERE id = ".(int) $id_event;

	if(\DB::run($sql)) {
		$id_parent = (int) $id_event;

		print "UPDATED EVENT ID: ".$id_parent.";\n\n";

		$timeStamp = \Data\Date::currentTimeStamp();
		$sql = "UPDATE md_eventos_lang SET
					dt_lastmod = '{$timeStamp}',
					title = '".$name."',
					active = 1";

		if (exists($row['text'])) {
			$sql .= ", description = '".\DB::escape_string($row['text'])."'";
		}

		$sql .= " WHERE id_lang = $lang_id AND parent = $id_parent";

		\DB::run($sql);


		manageEventTypes($id_event, $row['types']);
	}
}

function manageEventTypes($id_event, $types) {
	$sql = "SELECT id_tipo FROM md_eventos2tipos WHERE id_evento = $id_event";
	$typesRow = \DB::results($sql);

	$typesAssoc = [];
	foreach($typesRow as $typeRow) {
		$typesAssoc[$typeRow['id_tipo']] = $typeRow['id_tipo'];
	}

	foreach($types as $type) {
		if (!exists($type['id'])) {
			continue;
		}

		if (isset($typesAssoc[$type['id']])) {
			//Ignore Already Inserted Types
			unset($typesAssoc[$type['id']]);
			continue;
		}

		//Add New Types
		$id_type = $type['id'];
		$timeStamp = \Data\Date::currentTimeStamp();
		$sql = "INSERT INTO md_eventos2tipos SET
					dt_intro = '{$timeStamp}',
					dt_lastmod = '{$timeStamp}',
					id_evento = $id_event,
					id_tipo = '".$id_type."',
					active = 1";
		\DB::run($sql);
	}

	//Remove Old Outdated Types
	if (!empty($typesAssoc)) {
		foreach($typesAssoc as $id_type => $type) {
			$timeStamp = \Data\Date::currentTimeStamp();
			$sql = "UPDATE md_eventos2tipos SET
						dt_delete = '{$timeStamp}',
						active = 0
					WHERE id_evento = $id_event,
						AND id_tipo = '".$id_type."'";
			\DB::run($sql);
		}
	}
}