<div class="contentWrapper">

    <?php
    $username = $_SESSION['user']->username;
    $host = "http://fatedmz.suse.de:9090/sxkeeper/feature/";
    $query = "/feature[partnercontext/organization='openSUSE.org' and actor[person[userid='" . $username .
            "']] and productcontext[not(status/done or status/rejected or status/duplicate)] ]";
    $url = $host . "?query=" . urlencode($query) . "&client=openfate";
    $headers = array(headers => array("x-username" => $username, "user-agent" => "openfate"));
    $feature_xml = http_parse_message(http_get($url, $headers))->body;

    $xml = new SimpleXMLElement($feature_xml);
    $result = $xml->xpath('//title');
    ?>

    <?php
    while (list(, $node) = each($result)) {
        echo $node, "<br/>";
    }
    ?>

</div>
