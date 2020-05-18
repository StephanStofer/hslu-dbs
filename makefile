PARAMS=--toc -N --pdf-engine=pdflatex -V documentclass=scrartcl -V papersize=a4 -V lang=de -V linkcolor=blue
FONTS=-V mainfont="Baskerville" -V sansfont="Didot" -V monofont="Arial"
DATE=-V date="`date +'%d.%m.%Y'`"

dbs-exercises.pdf: sw*/*.md
	pandoc -s $(PARAMS) $(FONTS) $(DATE) sw*/*.md -o dbs-exercises.pdf
