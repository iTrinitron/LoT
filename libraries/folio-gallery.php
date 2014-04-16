<?php 
// error_reporting (E_ALL ^ E_NOTICE);
// photo gallery settings
$mainFolder    = 'albums';   // folder where your albums are located - relative to root
$albumsPerPage = '12';       // number of albums per page
$itemsPerPage  = '30';       // number of images per page    
$thumb_width   = '487';      // width of thumbnails
$thumbPic_width = '179';
//$thumb_height  = '135';       // height of thumbnails
$extensions    = array(".jpg",".png",".gif",".JPG",".PNG",".GIF"); // allowed extensions in photo gallery


// create thumbnails from images
function make_thumb($folder,$src,$dest,$thumb_width) {

	$source_image = imagecreatefromjpeg($folder.'/'.$src);
	$width = imagesx($source_image);
	$height = imagesy($source_image);
	
	$thumb_height = floor($height*($thumb_width/$width));
	
	$virtual_image = imagecreatetruecolor($thumb_width,$thumb_height);
	
	imagecopyresampled($virtual_image,$source_image,0,0,0,0,$thumb_width,$thumb_height,$width,$height);
	
	imagejpeg($virtual_image,$dest,100);
	
}

// display pagination
function print_pagination($numPages,$urlVars,$currentPage) {
        
   if ($numPages > 1) {
      
	   echo 'Page '. $currentPage .' of '. $numPages;
	   echo '&nbsp;&nbsp;&nbsp;';
   
       if ($currentPage > 1) {
	       $prevPage = $currentPage - 1;
	       echo '<a href="?page=pictures&'. $urlVars .'p='. $prevPage.'">&laquo;&laquo;</a> ';
	   }	   
	   
	   for( $e=0; $e < $numPages; $e++ ) {
           $p = $e + 1;
       
	       if ($p == $currentPage) {	    
		       $class = 'current-paginate';
	       } else {
	           $class = 'paginate';
	       } 
	       

		       echo '<a class="'. $class .'" href="?page=pictures&'. $urlVars .'p='. $p .'">'. $p .'</a>';
		  	  
	   }
	   
	   if ($currentPage != $numPages) {
           $nextPage = $currentPage + 1;	
		   echo ' <a href="?page=pictures&'. $urlVars .'p='. $nextPage.'">&raquo;&raquo;</a>';
	   }	  	 
   }
}


if (!isset($_GET['album'])) {

    // display list of albums
    $folders = scandir($mainFolder, 0);
	$ignore  = array('.', '..', 'thumbs');
		  
	$albums = array();
	$captions = array();
	$random_pics = array();
	  
    foreach($folders as $album) {
         
	    if(!in_array($album, $ignore)) {    
			 
		   array_push( $albums, $album );
			 
		   $caption = substr($album,0,30);
		   array_push( $captions, $caption );
			 
		   $rand_dirs = glob($mainFolder.'/'.$album.'/thumbs/*.*', GLOB_NOSORT);
           $rand_pic  = $rand_dirs[array_rand($rand_dirs)];
		   array_push( $random_pics, $rand_pic );
		  
		 }
		  
	 }

  
     if( count($albums) == 0 ) {
  
        echo 'There are currently no albums.';     
  
     } else {
  
		$numPages = ceil( count($albums) / $albumsPerPage );

        if(isset($_GET['p'])) {
      
	        $currentPage = $_GET['p'];
            if($currentPage > $numPages) {
               $currentPage = $numPages;
            }

         } else {
            $currentPage=1;
         } 
 
         $start = ( $currentPage * $albumsPerPage ) - $albumsPerPage;
	  /*
	     echo '<div class="titlebar">
                 <div class="float-left" style="width: 100%; text-align: center;"><span class="title">Albums</div>
              </div>';*/
	  
         echo '<div class="clear"></div>';
	  	  			 
	     for( $i=$start; $i<$start + $albumsPerPage; $i++ ) {
	  
	        if( isset($albums[$i]) ) {
			 		 			 
			    echo '<a href="?page=pictures&pictures&album='. urlencode($albums[$i]) .'">
					    <div class="thumb-album shadow">
						  <div class="thumb-wrapper">
			                <img src="'. $random_pics[$i] .'" width="'.$thumb_width.'" alt="" />
					      </div>
						  <div class="caption">'. $captions[$i] .'</div>
					    </div>
					  </a>	';
		     }		  	  
	      }
	  
	      echo '<div class="clear"></div>';
  
          echo '<div align="center" class="paginate-wrapper">';
        	 
                 $urlVars = "";
                 print_pagination($numPages,$urlVars,$currentPage);
  
          echo '</div>';	   
   
     }
   

} else {

     // display photos in album
     $src_folder = $mainFolder.'/'.$_GET['album'];
     $src_files  = scandir($src_folder);

     $files = array();
     foreach($src_files as $file) {
        
		$ext = strrchr($file, '.');
        if(in_array($ext, $extensions)) {
          
		   array_push( $files, $file );
		  
		   
		   if (!is_dir($src_folder.'/thumbs')) {
              mkdir($src_folder.'/thumbs');
              chmod($src_folder.'/thumbs', 0777);
              //chown($src_folder.'/thumbs', 'apache'); 
           }
		   
		   $thumb = $src_folder.'/thumbs/'.$file;
           if (!file_exists($thumb)) {
              make_thumb($src_folder,$file,$thumb,$thumb_width); 
          
		   }
        
		 }
      
	  }
 

   if ( count($files) == 0 ) {

      echo 'There are no photos in this album!';
   
   } else {
   
      $numPages = ceil( count($files) / $itemsPerPage );

      if(isset($_GET['p'])) {
      
	     $currentPage = $_GET['p'];
         if($currentPage > $numPages) {
            $currentPage = $numPages;
         }

      } else {
         $currentPage=1;
      } 

   $start = ( $currentPage * $itemsPerPage ) - $itemsPerPage;

   echo '<div class="titlebar">
           <div class="float-left"><span class="title">'. $_GET['album'] .'</span> - <a href="?page=pictures">View All Albums</a></div>
         </div>';	  
   echo '<div class="clear"></div>';


   for( $i=$start; $i<$start + $itemsPerPage; $i++ ) {
		  
		  if( isset($files[$i]) && is_file( $src_folder .'/'. $files[$i] ) ) { 
	   
	        echo '<div class="thumb shadow">
	                <div class="thumb-wrapper">
					<a href="'. $src_folder .'/'. $files[$i] .'" class="albumpix" rel="albumpix">
				      <img src="'. $src_folder .'/thumbs/'. $files[$i] .'" width="'.$thumbPic_width.'" alt="" />
				    </a>
					</div>  
			      </div>'; 
      
	      } else {
		  
		    if( isset($files[$i]) ) {
			  echo $files[$i];
		    }
		   
		  }
     
    }
	   

     echo '<div class="clear"></div>';
  
     echo '<div align="center" class="paginate-wrapper">';
        	 
        $urlVars = "album=".urlencode($_GET['album'])."&amp;";
        print_pagination($numPages,$urlVars,$currentPage);
  
     echo '</div>';
	 
	 
   } // end else	 

}
?>