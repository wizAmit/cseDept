<form method="post" enctype="multipart/form-data" class="form-signin">
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
						placeholder="Enter UID Aadhar Number">
				</div>
				<div>
					<label id="fullName">Full Name: </label>
				</div>
				<div>
					<label>Father's Name: </label>
					<input id="father" type="text" required placeholder="Father's Name">
				</div><br />
				<div>
					<label>Mother's Name: </label>
					<input id="mother" type="text" required placeholder="Mother's Name">
				</div>
				<div>
					<fieldset>

						<legend>X Details</legend>

						<div>

							<label>Aggregate Percentage: </label>
								<input type="number" required min="40.00" max="100" pattern="\d+(\.\d\d)" 
									title="Your Secondary Aggregate Percentage." id="Xpercent" placeholder="Aggregate Xth percentage.">

						</div>

						<div>

							<label>Board: </label>
							<input type="text" required title="Your X Board." id="Xboard" placeholder="Xth Board">

						</div>

						<div>

							<label>Year of Passing: </label>
							<input type="year" required id="XpassingYr" placeholder="Year of passing Xth">

						</div>

					</fieldset>

					<fieldset>

						<legend>XII / +2 Details</legend>

						<div>

							<label>Aggregate Percentage: </label>
							<input type="number" required min="40.00" max="100" pattern="\d+(\.\d\d)" 
								title="Your Senior Secondary Aggregate Percentage." id="XIIpercent" placeholder="Aggregate XIIth Percentage">

						</div>

						<div>

							<label>Board: </label>
							<input type="text" required title="Your XII Board." id="XIIboard" placeholder="XIIth Board">

						</div>

						<div>
							<label>Year of Passing: </label>
							<input type="date" required id="XIIpassingYr" placeholder="Year of Passing XII">

						</div>

					</fieldset>

					<div>

						<label>Entrance Exam: </label>
						<select>
							<option name="entranceExam" value="AIEEE">AIEEE</option>
							<option name="entranceExam" value="WBJEE">WBJEE</option>
						</select>

						<label>Rank Obtained: </label>
						<input type="number" min="0" step="1" required title="Rank obtained in the same." placeholder="Rank Obtained" id="rank">
					</div>
					<div>
						<button id="submit" onsubmit="update()" value="Update">Update</button>
					</div>
				</div>
			</div>
		</fieldset>
	</section>
</form>
<script src="./resources/library/jquery-1.11.0.min.js">
	$(document).ready(function(){
		$("#submit").onclick(function(){
			//check();
			
		});
	});

</script>