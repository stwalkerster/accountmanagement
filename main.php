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

echo "<table>";
foreach( $info[0] as $key => $value)
{
	if(is_int($key)) continue;
	if($key == "count") continue;
	
	echo "<tr><td>".$attributes[$key]."</td><td>";
	if(is_array($value))
	{
		echo "<ul>";
		foreach($value as $val)
			echo "<li>$val</li>";
		echo "</ul>";
	}
	else echo $value;
	echo "</td></tr>";
}
echo "</table>";

ldap_close($ds);


include ("foot.html");