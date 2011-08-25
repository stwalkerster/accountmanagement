<?php
include ("head.html");
$ds=ldap_connect("directory.helpmebot.org.uk");
ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
	
print_r($_POST);

$rdnstart = "uid=";
$rdnend = ",ou=People,";
$basedn = "dc=helpmebot,dc=org,dc=uk";

$username = $_POST['uid'];

$dn = $username;

if(!isset($_POST['rdn']))
{
	$dn = $rdnstart . $dn . $rdnend . $basedn;
}

$r=ldap_bind($ds,$dn,$_POST['pw']);

if(!$r)
{
	echo "Failed to authenticate with directory: ".ldap_error($ds);
	include ("foot.html");
	die();
}

$sr=ldap_search($ds, $basedn, "uid=" . $username);  
$info = ldap_get_entries($ds, $sr);

    for ($i=0; $i<$info["count"]; $i++) {
        echo "dn is: " . $info[$i]["dn"] . "<br />";
        echo "first cn entry is: " . $info[$i]["cn"][0] . "<br />";
        echo "first email entry is: " . $info[$i]["mail"][0] . "<br /><hr />";
    }

ldap_close($ds);


include ("foot.html");