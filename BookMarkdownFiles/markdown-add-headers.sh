#!/bin/bash

for i in ./*.md; do perl markdown.pl --html4tags $i > ../BookHTMLFiles/${i%.*}.php; done;

for f in ../BookHTMLFiles/*.php; do echo "<?php include('includes/header.php'); ?>" > tmpfile; echo "" >> tmpfile; cat "$f" >> tmpfile; mv tmpfile "$f"; done

for f in ../BookHTMLFiles/*.php; do echo "" >> "$f"; echo "<?php include('includes/footer.php'); ?>" >> "$f"; done