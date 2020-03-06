<?php ob_start(); ?>
		<footer>
			<script type="text/javascript" src="<?php echo $jsadmin ?>jquery-3.4.1.min.js"></script>
			<script type="text/javascript" src="<?php echo $jsadmin ?>jquery-ui.min.js"></script>
			<script type="text/javascript" src="<?php echo $jsadmin ?>jquery.selectBoxIt.min.js"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
			<script type="text/javascript" src="<?php echo $jsadmin ?>bootstrap.min.js"></script>
			<script type="text/javascript" src="<?php echo $jsadmin ?>my-front-script.js"></script>
		</footer>
	</body>
</html>
<?php ob_end_flush(); ?>