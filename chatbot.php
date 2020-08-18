<?php /***** DAILY NFL SCHEDULE *****/

include ("includes/header-includes.php"); //db, functions, libraries

/***** USER INPUT *****/

$input_text = "how many blocks did shawn kemp average from 1998-2001?"; 
//swats leaders 2012
//how many steals did Gary Payton have in 1996
//how many points did michael jordan score?
//how many points did michael jordan score in 1992?
//brooklyn nets swats specialist 2013
//how many blocks did shawn kemp average from 1998-2001?
//Who had the most turnovers on the 1997 bulls?
//who was the top scorer in 1963?
//who grabbed the most rebounds in 1963?
//how many boards did the leader have in 2010?
//how many assists did Lebron James have on the cavs?
//how many points did carmelo anthony score on the knicks?

/**********************/

$url = 'https://api.dialogflow.com/v1/query?v=20150910&contexts=shop&lang=en&query='. $input_text .'&sessionId=12345&timezone=America/Los_Angeles';
$authorization_token = '[ENTER_DIALOGFLOW_AUTH_TOKEN]';

$nba_query = new DialogFlowCrawl;
$nba_query->set_filtered_input_text($input_text);
$nba_query->set_dialogflow_url();
$nba_query->set_file_contents_curl();

$nba_query_arr = $nba_query->get_json_decode();

echo "<h2>". $nba_query_arr[result][resolvedQuery] ."</h2>";

//date range
$date_period = explode ( "/" , $nba_query_arr[result][parameters]["date-period"] );
$date_period1 = substr($date_period[0],0,4);
$date_period2 = substr($date_period[1],0,4);

//name
if(!empty($nba_query_arr[result][parameters]["given-name"]) || !empty($nba_query_arr[result][parameters]["last-name"])) {
	$player_name = $nba_query_arr[result][parameters]["given-name"] ." ". $nba_query_arr[result][parameters]["last-name"];
}

//NBA Stats
$nba_player_stats = strtoupper($nba_query_arr[result][parameters][nba_player_stats]);

//team abbreviation
$nba_team_abbr = $nba_query_arr[result][parameters][nba_team_name];

$nba_threshold = $nba_query_arr[result][parameters][threshold_descriptor];
if($nba_threshold == "worst") {
	$order = 'ASC';
} else {
	$order = 'DESC';
}

//Select player from database
//SQL Statement
$sql_input_arr = array(
    "date_period1" => $date_period1,
    "date_period2" => $date_period2,
    "nba_team_abbr" => $nba_team_abbr,
    "player_name" => $player_name
    );

//Team - Where
if(!empty($nba_team_abbr)) {
	$sql_where_team = "AND TEAM = :nba_team_abbr";
}
//Player - Where
if(!empty($player_name)) {
	$sql_where_player_name = "AND NAME LIKE '". $player_name ."'";
}
//Date - Where
if(!empty($date_period1) && !empty($date_period1)) {
	$sql_where_date = "AND SEASON >= :date_period1 AND SEASON <= :date_period2";
}

//Select all players from a team
$sql = "SELECT *
        FROM nba_bball_reference_players_avg_stats
        WHERE STAT_CATEGORY = 'Per Game Table'
        	$sql_where_date
        	$sql_where_team
        	$sql_where_player_name
        ORDER BY SEASON DESC, $nba_player_stats $order
        LIMIT 10";

$rows = pdo_select_list($sql, $sql_input_arr);
if($rows) {
    foreach ($rows as $row) {

        $query_results[] = array(
            "player_id" => $row[PLAYER_ID],
            "name" => $row[NAME],
            "season" => $row[SEASON],
            "team" => $row[TEAM],
            "$nba_player_stats" => $row[$nba_player_stats]
        );

    }
}

//echo "<h2>Query Results</h2>";
//echo "$sql";
//echo "<hr>";

//Player Description
$top_player = $query_results[0];
$readable_team_stats = str_replace("_", " ", strtolower($nba_player_stats));
echo $top_player[name] ." averaged ". $top_player[$nba_player_stats] ." ". $readable_team_stats ." in ". $top_player[season] .".";

echo "<br><br>";

echo "<table border='1'>";
echo "<tr>
		<th>player_id</th>
		<th>name</th>
		<th>year</th>
		<th>team</th>
		<th>$nba_player_stats</th>
	</tr>";
foreach($query_results as $data_arr) {
	echo "<tr>
			<td>". $data_arr[player_id] ."</td>
			<td>". $data_arr[name] ."</td>
			<td>". $data_arr[season] ."</td>
			<td>". $data_arr[team] ."</td>
			<td>". $data_arr[$nba_player_stats] ."</td>
		</tr>";
}
echo "</table>";


?>