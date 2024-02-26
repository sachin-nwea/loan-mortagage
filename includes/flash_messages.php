<?php
if(isset($_SESSION['success']))
{

echo '<div class="alert alert-success alert-dismissable" id="success">
   		<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
    		<strong>Success! </strong>'. $_SESSION['success'].'
  	  </div>
  	  <script type="text/javascript">
  	  setTimeout(function(){
                 $("#success").remove();
              }, 5000); 
      </script>
  	  ';
  unset($_SESSION['success']);
}

if(isset($_SESSION['failure']))
{
echo '<div class="alert alert-danger alert-dismissable" id="failure">
   		<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
    		<strong>Oops! </strong>'. $_SESSION['failure'].'
  	  </div>
  	  <script type="text/javascript">
  	  setTimeout(function(){
             $("#failure").remove();
      }, 5000); 
      </script>';
  unset($_SESSION['failure']);
}

if(isset($_SESSION['info']))
{
echo '<div class="alert alert-info alert-dismissable" id="info">
   		<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
    		'. $_SESSION['info'].'
  	  </div>
  	  <script type="text/javascript">
  	  setTimeout(function(){
                 $("#info").remove();
              }, 5000); 
      </script>';
  unset($_SESSION['info']);
}
 ?>