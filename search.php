<?php

$db = file_get_contents('users.txt');
$users = json_decode($db);
$xml = simplexml_load_string("<items></items>");

$user_ct = 0;
foreach($users->members as $id => $user) {
    if(strpos(strtolower($user->name), strtolower($argv[1])) > -1 || strpos(strtolower($user->real_name), strtolower($argv[1])) > -1) {
        $xml->item[$user_ct]->title = '@' . $user->name;
        $xml->item[$user_ct]->subtitle = $user->real_name;
        $xml->item[$user_ct]->icon = 'users/' . $user->name . '.png';
        $xml->item[$user_ct]['valid'] = 'yes';
        $xml->item[$user_ct]['uid'] = 'hi';
        $xml->item[$user_ct]['arg'] = $user->name;
        $user_ct++;
    }
}

echo $xml->asXml();
