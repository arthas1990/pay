<?php
 
$ipaddress=("5.9.95.34");
       echo "Your Input was : <b><font color=red face=arial>$input</font></b><br>";  
             
       $ipadd=gethostbyname ($input);


       list($ip1,$ip2,$ip3,$ip4)=explode('.',$ipadd);

       for ($a=0;$a<256;$a++)
       {
             $scanip="$ip1.$ip2.$ip3.$a";
             $newhostname=gethostbyaddr($scanip);  
             echo "$scanip ---> <a href=\"http://$newhostname\">$newhostname</a><br>";
       }
 
?>