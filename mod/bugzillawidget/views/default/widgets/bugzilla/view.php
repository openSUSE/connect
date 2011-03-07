<div class="contentWrapper" style="margin-left: -16px;">
<?php
  $email = urlencode($_SERVER['HTTP_X_EMAIL']);
  $csv_url = "https://bugzilla.novell.com/buglist.cgi?bug_status=NEW&bug_status=ASSIGNED&bug_status=REOPENED&bug_status=NEEDINFO&email1=$email&emailassigned_to1=1&emailinfoprovider1=1&emailtype1=exact&query_format=advanced&title=Bug%20List&ctype=csv";
  $csv = explode("\n", http_parse_message(http_get($csv_url))->body);
  array_shift($csv);
  echo "<table>\n";
  echo "<tr><th>bnc#</th><th>summary</th></tr>\n";
  foreach ($csv as $line) {
    $d = str_getcsv($line);
    $bnc = $d[0];
    $url = 'https://bugzilla.novell.com/show_bug.cgi?id=' . $bnc;
    $summary = $d[7];
    if (strlen($summary) > 30) {
      $summary = substr_replace($summary, ' ...', 27);
    }
    echo "<tr><td><a href=\"$url\">$bnc</a></td><td><a href=\"$url\">$summary</a></td></tr>\n";
  }
  echo "</table>\n";
?>
</div>
