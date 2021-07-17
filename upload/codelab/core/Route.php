<?php
if (isset($_GET['route'])) {
    $route = explode("/", filter_var(rtrim($_GET["route"], "/"), FILTER_SANITIZE_URL));
    DEFINE('CL_ROUTE_TABLE', $route);
} else {
    DEFINE('CL_ROUTE_TABLE', []);
}
