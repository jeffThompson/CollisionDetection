<!doctype html>
<html profile="http://www.w3.org/2005/10/profile">
<head>

	<meta charset="UTF-8">
	<link rel="icon" type="image/png" href="http://www.jeffreythompson.org/graphics/favicon.png">
	<title>Collision Detection</title>

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
		$sketch_path = 'CodeExamples/' . $sketch_name . '/web-export/';
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
			$('pre').addClass('prettyprint');

			$('h1').each(function() {
				var t = $(this).text();
				t = t.replace('/', '/<wbr>');
				t = t.replace('-', '-<wbr>');
				$(this).html(t);
			});

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
		});
	</script>
</head>

<body>
	<div id="wrapper">
		<header><p>
			<span id="prev">
				<?php
					if ( strcmp($prev, '') !== 0 ) {
						echo '<a href="' . $prev . '.php">&larr;</a>';
					}
					else {
						echo '&nbsp;';
					}
				?>
			</span>

			<?php
				if ( strcmp($filename, 'table-of-contents') == 0 ) {
					echo '<span id="title"><a href="index.php">Collision Detection</a></span>';
				}
				else {
					echo '<span id="title"><a href="table_of_contents.php">Collision Detection</a></span>';
				}
			?>
			<span id="next">
				<?php
					if ( strcmp($next, '') !== 0 ) {
						echo '<a href="' . $next . '.php">&rarr;</a>';
					}
					else {
						echo '&nbsp;';
					}
				?>
			</span>
			<div class="clear"></div>
		</p></header>

		<?php
			# show interactive example for specific pages only
			$no_example = array('license', 'table_of_contents', 'what_you_should_already_know', 'where_are_the_other_triangle_examples', 'thanks');
			if (strpos($filename, 'challenges') === false && in_array($filename, $no_example) === false) {
				echo '<canvas id="' . $sketch_name . '" data-processing-sources="' . $sketch_path . $sketch_name . '.pde" width="600" height="400">';
				echo '<p style="text-align:center">[ your browser does not support the canvas tag ]</p>';
				echo '</canvas>';
			}
		?>
