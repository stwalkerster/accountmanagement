<?php
// basic sequence with LDAP is connect, bind, search, interpret search
// result, close connection

echo "<h3>LDAP Password Changer</h3>";
echo "Connecting to directory service...<br />";
$ds=ldap_connect("directory.helpmebot.org.uk");  // must be a valid LDAP server!

$username = "stwalkerster";
session_start();
$password = $_SESSION['pw'];

$dn = $_SESSION['dn'];

if ($ds) {
    ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);

    echo "Authenticating as $dn...<br />"; 
    $r=ldap_bind($ds,$dn,$password);     // this is an "anonymous" bind, typically
                           // read-only access
    if(!$r)
    {
	echo "Failed!";
	echo "<!-- ".ldap_error($ds)." -->";
	die();
    }

    echo "Searching for (uid=".$username.") ...";
    // Search surname entry
    $sr=ldap_search($ds, "dc=helpmebot,dc=org,dc=uk", "uid=" . $username);  

    $info = ldap_get_entries($ds, $sr);

    for ($i=0; $i<$info["count"]; $i++) {
        echo "dn is: " . $info[$i]["dn"] . "<br />";
        echo "first cn entry is: " . $info[$i]["cn"][0] . "<br />";
        echo "first email entry is: " . $info[$i]["mail"][0] . "<br /><hr />";
    }

    echo "Closing connection";
    ldap_close($ds);

} else {
    echo "<h4>Unable to connect to LDAP server</h4>";
}

