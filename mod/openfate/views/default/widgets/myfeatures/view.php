<div class="contentWrapper">

    <?php
    global $feature_host;

    $username = 'digitaltomm'; //$_SESSION['user']->username;
    $query = "/feature[partnercontext/organization='openSUSE.org' and actor[person[userid='" . $username .
            "']] and productcontext[not(status/done or status/rejected or status/duplicate)] ]";
    $query = 'let $hits:= (for $i in ' . $query . 'order by $i/k:versioningsummary/k:lastmodifydate descending return $i) return subsequence($hits, 1, 10)';
    $url = $feature_host . "?query=" . urlencode($query) . "&client=openfate";
    $headers = array(headers => array("x-username" => $username, "user-agent" => "openfate"));
    $feature_xml = http_parse_message(http_get($url, $headers))->body;

    $xml = new SimpleXMLElement($feature_xml);
    $result = $xml->xpath('//feature');
    ?>

    <?php
    foreach ($result as $node) {
        $feature = simplexml_import_dom($node);
        $attributes = $feature->attributes("http://inttools.suse.de/sxkeeper/schema/keeper");
        $feature_id = $attributes['id'];
        //error_log( var_dump( $attributes['id'] ) ) ;
        echo "#<a href='https://features.opensuse.org/" . $feature_id . "'>" . $feature_id .  "</a> " . $feature->title . "<br/>";
    }
    ?>

</div>
