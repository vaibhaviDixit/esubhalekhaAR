<?php
locked(['user', 'host', 'manager', 'admin']);
require('views/partials/dashboard/head.php');
require('views/partials/dashboard/sidebar.php');


$story = json_decode($weddingData['story'], true);


?>

<head>

<style type="text/css">
	.form-check-input:checked {
 		background-color: var(--color-primary-1) !important;
 		border-color: var(--color-primary-1) !important;
	}
</style>

</head>
<!--Main Start-->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

	<form method="post" name="updateWedding" class="form-wedding">

		<?php
		if (isset($_POST['btn-submit'])) {


			if(isset($_REQUEST['display'])){
				$_REQUEST['display'] = 'true';
			}else{
				$_REQUEST['display'] = 'false';
			}

			$updateWedding = $wedding->update($_REQUEST['id'], $_REQUEST['lang'], $_REQUEST);

			if ($updateWedding['error']) {
				?>
				<div class="alert alert-danger">
					<?php
					foreach ($updateWedding['errorMsgs'] as $msg) {
						if (count($msg))
							echo $msg[0] . "<br>";
					}
					?>
				</div>
				<?php
			} else
				redirect("wedding/" . $_REQUEST['id'] . "/" . $_REQUEST['lang'] . "/theme");

		}

		?>
		<h1 class="h2">Our Story</h1>
		<div class="row">

			<input type="text" hidden name="basic-details">
			<!-- How we met -->
			<div class="mb-3 col-8">
				<label for="howWeMet" class="form-label">How We Met</label>
				<textarea class="form-control" id="howWeMet" name="howWeMet"
					placeholder="Enter how Bride & Groom met for the first time"
					rows="3"><?= $_REQUEST['howWeMet'] ?? str_replace("<br>", "\r\n", $story['howWeMet']) ?></textarea>
			</div>

			<!-- When we met -->
			<div class="mb-3 col-4">
				<label for="whenWeMet" class="form-label">When We Met</label>
				<select id="whenWeMet" name="whenWeMet" class="form-control">
					<option hidden>Select Year</option>
					<?php
					for ($i = 1990; $i <= date('Y'); $i++):
						?>
						<option value="<?= $i ?>" <?php if ($story['whenWeMet'] == $i)
							echo "selected" ?>>
							<?= $i ?>
						</option>
						<?php
					endfor;
					?>
				</select>
			</div>

			<!-- Engagement -->
			<div class="mb-3 col-8">
				<label for="engagement" class="form-label">Engagement</label>
				<textarea class="form-control" id="engagement" name="engagement"
					placeholder="Enter how Bride & Groom got engaged"
					rows="3"><?= $_REQUEST['engagement'] ?? str_replace("<br>", "\r\n", $story['engagement']) ?></textarea>
			</div>

			<!-- Engagement Year -->
			<div class="mb-3 col-4">
				<label for="engagementYear" class="form-label">Engagement Year</label>
				<select id="engagementYear" name="engagementYear" class="form-control">
					<option hidden>Select Year</option>
					<?php
					for ($i = 1990; $i <= date('Y'); $i++):
						?>
						<option value="<?= $i ?>" <?php if ($story['engagementYear'] == $i)
							echo "selected" ?>>
							<?= $i ?>
						</option>
						<?php
					endfor;
					?>
				</select>
			</div>

			<!-- Memorable Moments -->
			<div class="mb-3 col-8">
				<label for="memorableMoments" class="form-label">Memorable Moments</label>
				<textarea class="form-control" id="memorableMoments" name="memorableMoments"
					placeholder="Add any sweet memorable moments you like to share"
					rows="3"><?= $_REQUEST['memorableMoments'] ?? str_replace("<br>", "\r\n", $story['memorableMoments']) ?></textarea>
			</div>

			<!-- show toggle -->
			<div class="mb-3 col-4 form-check form-switch" style="padding-left: 1em !important;">
                 
				<label for="display" class="form-check-label d-block"> Display </label>
				<input class="form-check-input" type="checkbox" role="switch" id="display" name="display" <?php if($story['display'] == 'true'){ echo "checked"; } ?> style="margin-left: 0 !important;">

			</div>

		</div>


		<!-- Submit Button -->
		<button type="submit" name="btn-submit" class="btn btn-primary">Save & Next</button>
	</form>

	</div>

	<script>
		let weddings = []
		<?php
		foreach ($weddings as $wedding) {
			echo "weddings.push('" . $wedding['weddingID'] . "')\n";
		}
		?>

	</script>
</main>



<!--Main End-->

<?php require('views/partials/dashboard/scripts.php') ?>