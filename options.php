<?php
	//include './header.php';
	include './header-includes.php';
?>

	<div id="marksheet">
		<button class="btn btn-primary" data-toggle="modal" data-target=".Marksheet">Marksheet</button>
		<div class="modal fade Marksheet" tabindex="0" role="dialog" aria-labelledby="marksheet" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<?php include './marksheet.php'; ?>
				</div>
			</div>
		</div>
	</div>
	<div id="coursesBlog">
		<button class="btn btn-primary" data-toggle="modal" data-target=".Courses">Courses</button>
		<div class="modal fade Courses" tabindex="1" role="dialog" aria-labelledby="coursesBlog" aria-hidden="true">
		  <div class="modal-dialog modal-lg">
			<div class="modal-content">
			  <?php include './courses.php?sem=8'; ?>
			</div>
		  </div>
		</div>
	</div>
	<div id="chat">
		<a href="https://webchat.freenode.net/?channels=#cse_bppimt" target="_blank" >
			<button class="btn btn-primary" >Discuss Online</button>
		</a>
	</div>
	<div id="attendance">
		<button class="btn btn-primary" data-toggle="modal" data-target=".Attendance">Attendance</button>
		<div class="modal fade Attenance" tabindex="2" role="dialog" aria-labelledby="attendance" aria-hidden="true">
		  <div class="modal-dialog modal-lg">
			<div class="modal-content">
			  <?php include './Sandbox/attendance.php'; ?>
			</div>
		  </div>
		</div>
	</div>
	<div id="profile">
		<button class="btn btn-primary" data-toggle="modal" data-target=".Profile">Profile</button>
		<div class="modal fade Profile" tabindex="3" role="dialog" aria-labelledby="attendance" aria-hidden="true">
		  <div class="modal-dialog modal-lg">
			<div class="modal-content">
			  <?php include './profile.php'; ?>
			</div>
		  </div>
		</div>
	</div>
