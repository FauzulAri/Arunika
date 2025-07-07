<?php
$data = [
    "order_id" => "ORD-20250707155538-9800-1751918145966"
];
$ch = curl_init("http://localhost/Arunika/controller/midtrans_notification.php");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json'
]);
$result = curl_exec($ch);
curl_close($ch);
echo $result;
