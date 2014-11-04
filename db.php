<?php
if(!file_exists('token.txt')) {
    die('You must call set_token before you can update the database');
}

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://slack.com/api/users.list?token=' . file_get_contents('token.txt')); 

curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, '3');
$content = trim(curl_exec($ch));
$info = curl_getinfo($ch);
$file = fopen("users.txt","w");
fwrite($file,$content);
fclose($file);
curl_close($ch);


$users = json_decode($content);

if($users->error) {
    die('An error occurred with the user request. Please double check the token that you have used (result: ' . $users->error . ')');
}
foreach($users->members as $user) {
    $ch = curl_init($user->profile->image_48);
    $fp = fopen('users/'.$user->name.'.png', 'wb');
    curl_setopt($ch, CURLOPT_FILE, $fp);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_exec($ch);
    curl_close($ch);
    fclose($fp);
}

echo 'Update complete!';
