<?php
include ("head.html");
$ds=ldap_connect("directory.helpmebot.org.uk");
ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
	
//print_r($_POST);

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

require_once("inetorgperson.php");

$entry = $info[0];
echo "<table>";

echo "<tr><td>".$attributes['dn']."</td><td><ul><li>".$entry['dn']."</li></ul></td></tr>";

for($i = 0; $i < $entry['count'];$i++)
{
	$attrname = $entry[$i];
	echo "<tr><td>".($attributes[$attrname]==""?$attrname:$attributes[$attrname])."</td><td><ul>";
	
	for($j = 0; $j < $entry[$attrname]['count']; $j++)
	{
		echo "<li>".$entry[$attrname][$j]."</li>";
	}
	echo "</ul></td></tr>";
}

echo "</table>";

ldap_close($ds);


include ("foot.html");