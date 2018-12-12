<!doctype html>
<html profile="http://www.w3.org/2005/10/profile">
<head>

	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="http://www.jeffreythompson.org/graphics/favicon.png">
	<title>Collision Detection</title>

	<!-- dublin core -->
	<meta name="dc.title" CONTENT="Collision Detection">
	<meta name="dc.creator" CONTENT="Jeff Thompson">
	<meta name="dc.date" CONTENT="2018-12-11">
	<meta name="dc.type" CONTENT="Interactive Resource">
	<meta name="dc.format" CONTENT="HTML">
	<meta name="dc.language" CONTENT="en-US">
	<meta name="dc.rights" CONTENT="https://creativecommons.org/licenses/by-nc-sa/4.0/">

	<!-- social media cards -->
	<meta property="og:title" content="Collision Detection">
	<meta property="og:description" content="An online book about collision detection using Processing.">
	<meta property="og:type" content="website">
	<meta property="og:image" content="http://www.jeffreythompson.org/collision-detection/images/social-thumbnail.jpg">
	<meta property="og:url" content="http://www.jeffreythompson.org/collision-detection">
	<meta name="twitter:card" content="An online book about collision detection using Processing.">
	<meta property="og:site_name" content="Collision Detection">

	<?php
		$order = array( 'index', 'table_of_contents', 'license', 'what_you_should_already_know', 'point-point', 'point-circle', 'circle-circle', 'section_1_challenges', 'point-rect', 'rect-rect', 'circle-rect', 'section_2_challenges', 'line-point', 'line-circle', 'line-line', 'line-rect', 'section_3_challenges', 'poly-point', 'poly-circle', 'poly-rect', 'poly-line', 'poly-poly', 'section_4_challenges', 'tri-point', 'where_are_the_other_triangle_examples', 'section_5_challenges', 'object_oriented_collision', 'thanks' );

		# get current filename
		$filename = basename($_SERVER['PHP_SELF'], '.php');

		# what's next? what's previous?
		$position = 0;
		for ($i=0; $i<count($order); $i++) {
			if ( strcmp($filename, $order[$i]) == 0 ) {
				$position = $i;
				break;
			}
		}
		$next = $order[$position+1];
		$prev = $order[$position-1];

		# an on-screen friendly version
		if ( strcmp($prev, 'index') == 0 ) {
			$prev_onscreen = 'Introduction';
		}
		else if ( strcmp($prev , 'where_are_the_other_triangle_examples') == 0 ) {
			$prev_onscreen = 'Where Are The Other Triangle Examples?';
		}
		else {
			$prev_onscreen = str_replace('-', ' ', $prev);
			$prev_onscreen = str_replace('rect', 'rectangle', $prev_onscreen);
			$prev_onscreen = str_replace('poly', 'Polygon', $prev_onscreen);
			$prev_onscreen = str_replace('tri', 'Triangle', $prev_onscreen);
			$prev_onscreen = ucwords($prev_onscreen);
			$prev_onscreen = str_replace(' ', '/', $prev_onscreen);
			$prev_onscreen = str_replace('_', ' ', $prev_onscreen);
			$prev_onscreen = ucwords($prev_onscreen);
		}

		if ( strcmp($next, 'index') == 0 ) {
			$next_onscreen = 'Introduction';
		}
		else if ( strcmp($next , 'where_are_the_other_triangle_examples') == 0 ) {
			$next_onscreen = 'Where Are The Other Triangle Examples?';
		}
		else {
			$next_onscreen = str_replace('-', ' ', $next);
			$next_onscreen = str_replace('rect', 'rectangle', $next_onscreen);
			$next_onscreen = str_replace('poly', 'Polygon', $next_onscreen);
			$next_onscreen = str_replace('tri', 'Triangle', $next_onscreen);
			$next_onscreen = ucwords($next_onscreen);
			$next_onscreen = str_replace(' ', '/', $next_onscreen);
			$next_onscreen = str_replace('_', ' ', $next_onscreen);
			$next_onscreen = ucwords($next_onscreen);
		}

		# auto-generate sketch name
		if ( strcmp($filename, 'index') == 0 ) {
			$sketch_name = 'Introduction';
		}
		else {
			$sketch_name = str_replace('-', ' ', $filename);
			$sketch_name = str_replace('_', ' ', $filename);
			$sketch_name = ucwords($sketch_name);
			$sketch_name = str_replace(' ', '', $sketch_name);
		}

		// $sketch_path = 'pde/';
		$sketch_path = 'code/' . $sketch_name . '/web-export/' . $sketch_name . '.pde';
	?>

	<!-- FONTS AND CSS -->
	<link href='http://fonts.googleapis.com/css?family=Raleway:400,600,800' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Lora:400,400italic,700,700italic' rel='stylesheet' type='text/css'>
	<link href="css/stylesheet.css" rel="stylesheet" type="text/css">

	<!-- CODE PRETTIFY -->
	<!-- via: https://github.com/google/code-prettify -->
	<script src="js/run_prettify.js"></script>

	<!-- PROCESSING.JS -->
	<!--[if lt IE 9]>
			<script type="text/javascript">alert("Your browser does not support the canvas tag!");</script>
	<![endif]-->
	<script src="js/processing.js" type="text/javascript"></script>
	<script>
		function getProcessingSketchId() {
			return '<?php echo $current_file; ?>';
		}
	</script>

	<!-- JQUERY FANCY ADDITIONS -->
	<!-- add code class, hover text, etc -->
	<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
	<script>

		$(document).ready(function() {

			// prettyprint the code, pls
			$('pre').addClass('prettyprint lang-java');

			// add word-breaks to anything with a / or - in it
			$('h1').each(function() {
				var t = $(this).text();
				t = t.replace('/', '/<wbr>');
				t = t.replace('-', '-<wbr>');
				$(this).html(t);
			});

			// set formatting
			resizeCommands();
		});

		// when the window gets resized, do some stuff to keep everything
		// looking pretty
		$(window).resize( function() {
			resizeCommands();
		});

		// things to do when the page is loaded or window resized
		function resizeCommands() {
			// large-screen stuff...
			if ($(window).width() > 600) {

				// long headline on intro page
				// $('#introHeadline').html('INTRODUCTION');

				// menu hover stuff on larger screens
				// (does weird formatting on larger screens)
				// hover over title to show "Table of Contents"
				$('#title a').hover(
					function() {
						$('#title a').text('Table of Contents');
					},
					function() {
						$('#title a').text('Collision Detection');	// set back when moving out
					}
				);

				// set prev/next titles
				$('#prev a').hover(
					function() {
						$('#title a').text('Prev: <?php echo $prev_onscreen; ?>');
					},
					function() {
						$('#title a').text('Collision Detection');
					}
				);
				$('#next a').hover(
					function() {
						$('#title a').text('Next: <?php echo $next_onscreen; ?>');
					},
					function() {
						$('#title a').text('Collision Detection');
					}
				);
			}

			// small-screen stuff
			else {
				// short headline on intro page
				// $('#introHeadline').html('INTRO');
			}
		}
	</script>

	<!-- ANALYTICS -->
	<script type="text/javascript">
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', 'UA-11906563-1']);
		_gaq.push(['_trackPageview']);
		(function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();
	</script>
</head>

<body>
	<div id="wrapper">
		
		<?php
			if (strcmp($filename, 'index') !== 0) {
				echo '<header><p>';
				echo '<span id="prev">';
				if ( strcmp($prev, '') !== 0 ) {
					echo '<a href="' . $prev . '.php">&larr;</a>';
				}
				else {
					echo '&nbsp;';
				}
				echo '</span>';

				echo '<span id="title">';
				if ( strcmp($filename, 'table-of-contents') == 0 ) {
					echo '<a href="index.php">Collision Detection</a>';
				}
				else {
					echo '<a href="table_of_contents.php">Collision Detection</a>';
				}
				echo '</span>';

				echo '<span id="next">';
				if ( strcmp($next, '') !== 0 ) {
					echo '<a href="' . $next . '.php">&rarr;</a>';
				}
				else {
					echo '&nbsp;';
				}
				echo '</span>';
				echo '<div class="clear"></div>';
				echo '</p></header>';
			}
		?>

		<?php
			# show interactive example for specific pages only
			$no_example = array('license', 'table_of_contents', 'what_you_should_already_know', 'where_are_the_other_triangle_examples', 'thanks');
			if (strpos($filename, 'challenges') === false && in_array($filename, $no_example) === false) {
				echo '<canvas id="' . $sketch_name . '" data-processing-sources="' . $sketch_path . '">';
				echo '<p style="text-align:center">[ your browser does not support the canvas tag ]</p>';
				echo '</canvas>';
			}
		?>
