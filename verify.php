<?php
header('Content-Type: text/html; charset=utf-8');

$fileCsr = $_FILES["csr"]["name"];
$fileKey = $_FILES["key"]["name"];
$fileCrt = $_FILES["crt"]["name"];

$csr = $_FILES["csr"]["tmp_name"];
$key = $_FILES["key"]["tmp_name"];
$crt = $_FILES["crt"]["tmp_name"];

if (!$csr || !$key || !$crt) {
    die("Files not specified. <a href='index.html'>Go back</a> and try again.");
}

$hashKey = exec("openssl pkey -in " . $key . " -pubout -outform pem | sha256sum ");
$hashCsr = exec("openssl req -in " . $csr . " -pubkey -noout -outform pem | sha256sum");
$hashCrt = exec("openssl x509 -in " . $crt . " -pubkey -noout -outform pem | sha256sum");

echo "<table>";
echo "<tr><td><strong>Signing Request:</strong></td><td>" . $fileCsr . "</td><td><strong>Hash:</strong></td><td>" . $hashCsr . "</td></tr>";
echo "<tr><td><strong>Private Key:</strong></td><td>" . $fileKey . "</td><td><strong>Hash:</strong></td><td>" . $hashKey . "</td></tr>";
echo "<tr><td><strong>Public Key:</strong></td><td>" . $fileCrt . " </td><td><strong>Hash:</strong></td><td>" . $hashCrt . "</td></tr>";
echo "</table>";

if ($hashCsr === $hashKey && $hashCsr === $hashCrt && $hashKey === $hashCrt && $hashCsr != '') {
    echo "<p style='color: green;'>Certificates match!</p>";
}
else {
    echo "<p style='color: red;'>Certificates do NOT match!</p>";
}

echo "<a href='index.html'>Go back</a>";
?>
