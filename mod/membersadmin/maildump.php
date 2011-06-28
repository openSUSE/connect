<?php
    require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
    require_once('maildump_func.php');

    admin_gatekeeper();
    set_context('admin');

    header('Content-type: text/plain; charset=utf-8');
    header('Content-Disposition: attachment; filename="maildump.txt"');

    connect_maildump_func();
?>
