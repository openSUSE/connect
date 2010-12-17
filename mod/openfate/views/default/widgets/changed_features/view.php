<div class="contentWrapper">

    <?php
    $username = $_SESSION['user']->username;
    $host = "http://fatedmz.suse.de:9090/sxkeeper/feature/";
    $query = "/feature[partnercontext/organization='openSUSE.org' and productcontext[not(status/done or status/rejected or status/duplicate)] ]";
    $query = 'let $hits:= (for $i in ' . $query . 'order by $i/k:versioningsummary/k:lastmodifydate descending return $i) return subsequence($hits, 1, 10)';

    $url = $host . "?query=" . urlencode($query) . "&client=openfate";
    $headers = array(headers => array("x-username" => $username, "user-agent" => "openfate"));
    $feature_xml = http_parse_message(http_get($url, $headers))->body;

    $xml = new SimpleXMLElement($feature_xml);
    $result = $xml->xpath('//feature');
    ?>

    <?php
    foreach ($result as $node) {

        //error_log(print_r($result));
        $feature = simplexml_import_dom($node);
        $title = $feature->xpath('/feature/title');
        $id = $feature->xpath('/feature/@k:id');

        echo $feature->title . "<br/>";
    }
    ?>

</div>
