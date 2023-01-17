<?php if (count($errors) > 0): ?>
	<div class="error">
		<?php foreach ($errors as $error) : ?>
			<script>alert('<?php echo $error ?>');</script>
		<?php endforeach ?>
	</div>
<?php	endif ?>
