
<html>
<head>
<title>
	Translate
</title>
</head>
<body>

<form method="post" action="index.php">
	<input type="text" name="word">
	<input type="submit" value="cari">
</form>
</body>
</head>
<?php
$word = $_POST['word'];
$ch = curl_init();

// melakukan set url
curl_setopt($ch, CURLOPT_URL, "https://www.englishnepalidictionary.com/?q=$word");
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$result = curl_exec($ch);

preg_match_all("/<h3>(.*?)<\/h3>/", $result, $matches);
// melakukan grab url dan passing ke browser local
$final = $matches[1][0];

echo $final;
// menutup semua resource, free dan sistem resource
curl_close($ch);
