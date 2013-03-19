<?php  $Logged_User=$_SESSION['user'];?>

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
        
    </head>
    
    <body>

    	<div class="section" id="page"> <!-- Defining the #page section with the section tag -->
    
            <div class="header"> <!-- Defining the header section of the page with the appropriate tag -->

                <h1>Ashena Game</h1>
                <h3>Ashena world of warcraft game server</h3>
                
                <div class="nav clear"> <!-- The nav link semantically marks your main site navigation -->
				<?php 
				if(isset($Logged_User['username'])):?>
                    <ul>
                        <li><a href="error_login.php">خروج</a></li>
                        <li><a href="#"><?=$Logged_User['username']?> - ریال <span class="err"><?=$Logged_User['credit']?></span> اعتبار</a></li>
          
                    </ul>
				<?php endif;?>
                </div>
            
            </div>
            
            <div class="section" id="articles"> <!-- A new section with the articles -->

				<!-- Article 1 start -->

                <div class="line"></div>  <!-- Dividing line -->
                
                <div class="article" id="article1"> <!-- The new article tag. The id is supplied so it can be scrolled into view. -->
                    <h2> وضعیت تقاضا </h2>
                    
                    <div class="line"></div>
                    
                    <div class="articleBody clear" id="page_contents">
					<?php 
					
					if($this->err_list!='')
						foreach($this->err_list as $row)
							if(!empty($row))
								echo '<div class="err">'.$row.'</div>';
					if($this->warn_list!='')	
						foreach($this->warn_list as $row)
							if(!empty($row))
								echo '<div class="warn">'.$row.'</div>';
					if($this->note_list!='')
						foreach($this->note_list as $row)
							if(!empty($row))
								echo '<div class="note">'.$row.'</div>';
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
        
        <!-- JavaScript Includes -->
        
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
        <script type="text/javascript" src="js/jquery.scrollTo-1.4.2/jquery.scrollTo-min.js"></script>
        <script type="text/javascript" src="js/script.js"></script>
    </body>
</html>
