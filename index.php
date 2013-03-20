<?php

require "lib/sec.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
    
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        
        <title>Ashena Game</title>
        
        <link rel="stylesheet" type="text/css" href="css/styles.css" />
               
        <!--[if IE]>
        
        <style type="text/css">
        .clear {
          zoom: 1;
          display: block;
        }
        </style>

        
        <![endif]-->
         <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
    </head>
    
    <body>

    	<div class="section" id="page"> <!-- Defining the #page section with the section tag -->
    
            <div class="header"> <!-- Defining the header section of the page with the appropriate tag -->

                <h1>Ashena Game</h1>
                <h3>Ashenagame payment system version 2.2</h3>
                
                <div class="nav clear"> <!-- The nav link semantically marks your main site navigation -->
                    <ul>
                        <li><a href="error_login.php">خروج</a></li>
                        <li><a href="#"><?=$Logged_User['username']?> - اعتبار <span class="<?php if($Logged_User['credit']>0)echo 'green';else echo 'red';?>"><?=number_format($Logged_User['credit']);?></span> ریال</a></li>
          
                    </ul>
                </div>
            
            </div>
            
            <div class="section" id="articles"> <!-- A new section with the articles -->

				<!-- Article 1 start -->

                <div class="line"></div>  <!-- Dividing line -->
                
                <div class="article" id="article1"> <!-- The new article tag. The id is supplied so it can be scrolled into view. -->
                    <h2> عملیات 
					<?=$Logged_User['service_name'];?>
					</h2>
                    
                    <div class="line"></div>
                    
                    <div class="articleBody clear" id="page_contents">
				  
					<?php 
					
					if($err->err_list!='')
						foreach($err->err_list as $row)
							if(!empty($row))
								echo '<div class="err">'.$row.'</div>';
					if($err->warn_list!='')	
						foreach($err->warn_list as $row)
							if(!empty($row))
								echo '<div class="warn">'.$row.'</div>';
					if($err->note_list!='')
						foreach($err->note_list as $row)
							if(!empty($row))
								echo '<div class="note">'.$row.'</div>';
				 
					 include "include/".$Logged_User['step']."_task.php";
					  
					?>
					
					
					
                    </div>
                </div>
                
				<!-- Article 1 end -->

 


            </div>

        <div class="footer"> <!-- Marking the footer section -->

          <div class="line"></div>
           
           <p>Copyright 2013 - ashenagame.ir</p> <!-- Change the copyright notice -->
           
           <a href="#" class="up">Go UP</a>
           <a href="http://rahawebdesign.com" class="by">By Rahawebdesign</a>
           

        </div>
            
		</div> <!-- Closing the #page section -->
        
 
        
       
              <!--  <script type="text/javascript" src="js/jquery.scrollTo-1.4.2/jquery.scrollTo-min.js"></script>
        <script type="text/javascript" src="js/script.js"></script> -->
    </body>
</html>
