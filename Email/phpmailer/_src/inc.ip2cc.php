<?php

function getISO3() {
  // Get the user's ip address
  $ipaddr = getenv("REMOTE_ADDR");
  $ipdec = sprintf("%010u", ip2long($ipaddr));

  // Open the csv file for reading
  $handle = fopen("_src/IpToCountry.csv", "r");

  // Load array with start ips
  $row = 1;
  while (($buffer = fgets($handle, 4096)) !== FALSE) {
    $array[$row] = $buffer;
    $row++;
  }

  // Locate the row with our ip using bisection
  $row_lower = '0';
  $row_upper = $row;
  while (($row_upper - $row_lower) > 1) {
    $row_midpt = (int) (($row_upper + $row_lower) / 2);
    $buffer = $array[$row_midpt];
    $start_ip = sprintf("%010u", substr($buffer, 1, strpos($buffer, ",") - 1));
    if ($ipdec >= $start_ip) {
      $row_lower = $row_midpt;
    } else {
      $row_upper = $row_midpt;
    }
  }

  // Read the row with our ip
  $buffer = $array[$row_lower];
  $buffer = str_replace("\"", "", $buffer);
  $ipdata = explode(",", $buffer);

  // Close the csv file
  fclose($handle);

  // return the country code
  return strtoupper($ipdata[5]);
}

?>
