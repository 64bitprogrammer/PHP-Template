<?php
/* reads country id from register.php
and then sets the data for state control */
require_once("connect.php");


if(!empty($_POST["Country_ID"]))
{

	// handles 0 states
	$result = mysqli_query($conn,"select Country_Name,hasStates from countries where Country_ID = ". $_POST["Country_ID"] ." ");
	$row = mysqli_fetch_assoc($result);
	if($row['hasStates']==1){
		$query ="SELECT State_ID ,State_Name FROM states WHERE Country_ID = '" . $_POST["Country_ID"] . "' order by State_Name";
		$state_results = mysqli_query($conn,$query);
		?>
		<option value="">Select State</option>
		<?php
		foreach($state_results as $state) {
			?>
			<option <?php if(isset($_POST['State_ID']))if($_POST['State_ID']==$state['State_ID']) echo 'selected="selected"';?> value="<?= $state['State_ID']; ?>"><?= utf8_encode($state['State_Name']); ?></option>
			<?php
		}
	}
	else{

		?>
		<option <?="selected"?> value="<?= $_POST["Country_ID"] ?>"><?= utf8_encode($row['Country_Name']); ?></option>
		<?php
	}
}
else
{
	echo " error ";
}
?>
