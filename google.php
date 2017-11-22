<?php

//
// Slamet Sugandi <packercyber@gmail.com>
header("Content-type:application/json");
$curl = curl_init(); 
$url = "https://www.jadwalsholat.org/adzan/monthly.php?id=193";
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_HEADER, 0);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

// https://ecs7.tokopedia.net/img/attachment/2017/2/17/95/95_66f3de21-3af8-4a46-b893-5d49a66e2312.jpg
// <td><b>Tanggal</b></td>
$result = curl_exec($curl);
$error = curl_error($curl) and die(json_encode(["error" => $error], 128));
curl_close($curl);
// melakukan explode pada terakhir tanggal 
$a = explode('<b>Isya</b>', $result);
// melakukan explode pada tr class header
$a = explode('<tr class="table_header">', $a[1], 2);
$jadwal = [];

foreach (explode("\n", $a[0]) as $val) {
	$b = explode('" align="center"><td><b>', $val) and
		(count($b)>1) and (function(&$jadwal) use ($b) {
			$b = explode('</b></td><td>', $b[1]);
			$waktu = explode('</td><td>', $b[1]);
			$jadwal[$b[0]] = [
				"subuh" => $waktu[0],
				"dzuhur" => $waktu[1],
				"ashar" => $waktu[2],
				"magrib" => $waktu[3],
				"isya" => substr($waktu[4], 0, 5),
			];
		})($jadwal);
}
print($a = json_encode($jadwal, 128));
file_put_contents("jadwal_".time().".json", $result, LOCK_EX);
