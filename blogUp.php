<?php
	//include "./header.php";
?>

<div class="container">
	<form role="form">
		<select id="sem" class="form-control">
			<script src="./js/semOptionGen.js"></script>
		</select>
		<select id="subCode" class="form-control">
			
		</select>
		<div class="input-group">
		  <input type="text" class="form-control">
		  <div class="input-group-btn">
			  <button type="button" class="btn btn-default btn-lg">
  <span class="glyphicon glyphicon-calender"></span><!--<div class="dropdown"></div>--></button>
		  </div>
		</div>
		<div class="input-group">
  			<span class="input-group-addon">@</span>
  			<input type="text" class="form-control" placeholder="Username" disabled="true">
		</div>
		<div class="input-group">
			<input type="text" class="form-control" placeholder="Enter Title">
		</div>
		<div class="input-group">
			<textarea class="form-control" rows="3" id="desc" placeholder="Enter Description of the Post"></textarea>
		</div>		
		<button type="button" class="btn btn-default">Post</button>
	</form>
</div>