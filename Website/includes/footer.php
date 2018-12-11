
	<!-- link to the next page -->
	<?php
		# don't list on the thank you page, tho
		if (strcmp($filename, 'thanks') !== 0) {
			echo '<a href="' . $next . '.php"><p class="nextPage">NEXT: ' . $next_onscreen . '</p></a>';
		}
	?>

	<footer>
		<p>[ <a href="index.php">intro</a>, <a href="https://github.com/jeffThompson/CollisionDetection">source</a>, <a href="https://github.com/jeffThompson/CollisionDetection/issues">issues</a> ]</p>

		<p class="license"><a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/4.0/">
			<img id="license" alt="Creative Commons License" style="border-width:0" src="https://i.creativecommons.org/l/by-nc-sa/4.0/88x31.png">
		</a></p>
	</footer>

	</div> <!-- end footer -->

<!-- nice smart quotes, via: http://smartquotesjs.com -->
<script src="js/smartquotes.min.js"></script>

</body>
</html>