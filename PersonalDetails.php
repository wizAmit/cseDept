<?php
	//include 'header-includes.php';
?>
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
<form method="post" enctype="multipart/form-data" class="form-signin" id="personalDetail" action="./updateStudent.php">
	<section>
		<fieldset>
			<legend>Personal Information</legend>
			<div>
				<div>
					<label id="clgRoll" >College Roll No.: </label>
				</div>
				<div>
					<label>UID Aadhar Number: </label>
					<input type="number" id="uid" pattern="\d{12}" 
						title="Enter your Aadhar Number. If you've not yet received/apllied, please do so. Untill then leave this blank. :)" 
						placeholder="Enter UID Aadhar Number" min="100000000000" name="UID">
				</div>
				<div>
					<label id="fullName">Full Name: </label>
				</div>
				<div>
					<label>Father's Name: </label>
					<input id="father" type="text" required placeholder="Father's Name" name="FatherName">
				</div><br />
				<div>
					<label>Mother's Name: </label>
					<input id="mother" type="text" required placeholder="Mother's Name" name="MotherName">
				</div>
				<div>
					<fieldset>

						<legend>X Details</legend>

						<div>

							<label>Aggregate Percentage: </label>
								<input type="number" required min="40.00" max="100" pattern="\d+(\.\d\d)" 
									title="Your Secondary Aggregate Percentage." id="Xpercent" placeholder="Aggregate Xth percentage." name="X">

						</div>

						<div>

							<label>Board: </label>
							<input type="text" required title="Your X Board." id="Xboard" placeholder="Xth Board" name="Board_X">

						</div>

						<div>

							<label>Year of Passing: </label>
							<input type="year" required id="XpassingYr" placeholder="Year of passing Xth" name="Year_X">

						</div>

					</fieldset>

					<fieldset>

						<legend>XII / +2 Details</legend>

						<div>

							<label>Aggregate Percentage: </label>
							<input type="number" required min="40.00" max="100" pattern="\d+(\.\d\d)" 
								title="Your Senior Secondary Aggregate Percentage." id="XIIpercent" placeholder="Aggregate XIIth Percentage" name="XII">

						</div>

						<div>

							<label>Board: </label>
							<input type="text" required title="Your XII Board." id="Board_XII" placeholder="XIIth Board" name="XIIboard">

						</div>

						<div>
							<label>Year of Passing: </label>
							<input type="date" required id="XIIpassingYr" placeholder="Year of Passing XII" name="Year_XII">

						</div>

					</fieldset>

					<div>

						<label>Entrance Exam: </label>
						<select>
							<option name="EntranceExam" value="AIEEE">AIEEE</option>
							<option name="EntranceExam" value="WBJEE">WBJEE</option>
						</select>

						<label>Rank Obtained: </label>
						<input type="number" min="0" step="1" required title="Rank obtained in the same." placeholder="Rank Obtained" id="rank" name="Rank">
					</div>
					<div>
						<button id="submit" value="Update">Update</button>
					</div>
				</div>
			</div>
		</fieldset>
	</section>
</form>
<script>
	fillForm();
</script>