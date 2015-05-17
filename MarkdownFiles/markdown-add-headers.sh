#!/bin/bash

for i in ./*.md; do perl markdown.pl --html4tags $i > ../Website/${i%.*}.php; done;

for f in ../Website/*.php; do echo "<?php include('includes/header.php'); ?>" > tmpfile; echo "" >> tmpfile; cat "$f" >> tmpfile; mv tmpfile "$f"; done

for f in ../Website/*.php; do echo "" >> "$f"; echo "<?php include('includes/footer.php'); ?>" >> "$f"; done