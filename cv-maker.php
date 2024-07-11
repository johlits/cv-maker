<?php

// Example PHP code to generate PDF using pdflatex
$inputFileName = 'input.tex'; // Your LaTeX file
$outputFileName = 'output.pdf';

// Prepare LaTeX content
$latexContent = <<<EOT
\\documentclass{article}
\\begin{document}
Hello, LaTeX!
\\end{document}
EOT;

// Write content to input file
file_put_contents($inputFileName, $latexContent);

// Execute pdflatex command
exec("pdflatex -interaction=nonstopmode $inputFileName");

// Rename output file
rename('input.pdf', $outputFileName);

// Optionally, clean up
unlink($inputFileName);
unlink('input.log');
unlink('input.aux');

echo "PDF created: $outputFileName\n";
