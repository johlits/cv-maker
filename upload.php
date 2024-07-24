<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['jsonFile']) && $_FILES['jsonFile']['error'] == 0) {
        $allowedExtensions = ['json'];
        $fileExtension = pathinfo($_FILES['jsonFile']['name'], PATHINFO_EXTENSION);

        // Check if the uploaded file has a JSON extension
        if (in_array($fileExtension, $allowedExtensions)) {
            $uploadDir = 'uploads/';
            $uploadFile = $uploadDir . basename($_FILES['jsonFile']['name']);

            // Create uploads directory if it doesn't exist
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            // Move the uploaded file to the server
            if (move_uploaded_file($_FILES['jsonFile']['tmp_name'], $uploadFile)) {
                // Read and parse the JSON file
                $jsonContent = file_get_contents($uploadFile);
                $jsonData = json_decode($jsonContent, true);

                if (json_last_error() === JSON_ERROR_NONE) {
                    // Function to convert JSON data to LaTeX format
                    function jsonToLatex($data)
                    {
                        $latex = "\\documentclass{article}\n\\begin{document}\n";
                        $latex .= "\\section*{" . $data['name'] . "}\n";
                        $latex .= "\\subsection*{Contact Information}\n";
                        $latex .= "Email: " . $data['contactInformation']['email'] . "\\\\\n";
                        $latex .= "Phone: " . $data['contactInformation']['phone'] . "\\\\\n";
                        $latex .= "Address: " . $data['contactInformation']['address']['street'] . ", " . $data['contactInformation']['address']['city'] . ", " . $data['contactInformation']['address']['state'] . " " . $data['contactInformation']['address']['zip'] . ", " . $data['contactInformation']['address']['country'] . "\n";
                        $latex .= "\\subsection*{Summary}\n" . $data['summary'] . "\n";
                        $latex .= "\\subsection*{Education}\n";
                        foreach ($data['education'] as $edu) {
                            $latex .= $edu['degree'] . ", " . $edu['institution'] . ", " . $edu['graduationYear'] . "\\\\\n";
                        }
                        $latex .= "\\subsection*{Work Experience}\n";
                        foreach ($data['workExperience'] as $work) {
                            $latex .= "\\textbf{" . $work['jobTitle'] . " at " . $work['company'] . "}\n";
                            $latex .= "\\begin{itemize}\n";
                            foreach ($work['responsibilities'] as $resp) {
                                $latex .= "\\item " . $resp . "\n";
                            }
                            $latex .= "\\end{itemize}\n";
                        }
                        $latex .= "\\subsection*{Skills}\n";
                        $latex .= "\\begin{itemize}\n";
                        foreach ($data['skills'] as $skill) {
                            $latex .= "\\item " . $skill . "\n";
                        }
                        $latex .= "\\end{itemize}\n";
                        $latex .= "\\subsection*{Certifications}\n";
                        foreach ($data['certifications'] as $cert) {
                            $latex .= $cert['name'] . ", " . $cert['institution'] . ", " . $cert['year'] . "\\\\\n";
                        }
                        $latex .= "\\subsection*{Projects}\n";
                        foreach ($data['projects'] as $proj) {
                            $latex .= "\\textbf{" . $proj['name'] . "}\n";
                            $latex .= $proj['description'] . "\\\\\n";
                            $latex .= "Technologies: " . implode(", ", $proj['technologies']) . "\n";
                        }
                        $latex .= "\\subsection*{Languages}\n";
                        foreach ($data['languages'] as $lang) {
                            $latex .= $lang['language'] . ": " . $lang['proficiency'] . "\\\\\n";
                        }
                        $latex .= "\\end{document}\n";
                        return $latex;
                    }

                    // Convert JSON data to LaTeX
                    $latexContent = jsonToLatex($jsonData);
                    $inputFileName = 'resume.tex'; // LaTeX file name
                    $outputFileName = 'resume.pdf'; // Output PDF file name

                    // Write LaTeX content to file
                    file_put_contents($inputFileName, $latexContent);

                    // Execute pdflatex command to generate PDF and capture output
                    $command = "pdflatex -interaction=nonstopmode $inputFileName";
                    exec($command . " 2>&1", $output, $return_var);

                    // Output the results
                    if ($return_var == 0) {
                        // Successfully created PDF
                        echo "PDF created: $outputFileName\n";
                    } else {
                        // Error creating PDF
                        echo "Error creating PDF.\n";
                        echo "Command output:\n";
                        echo implode("\n", $output);
                    }

                    // Optionally, clean up temporary files
                    unlink($inputFileName);
                    unlink('resume.log');
                    unlink('resume.aux');

                } else {
                    echo "Error parsing JSON: " . json_last_error_msg();
                }
            } else {
                echo "Failed to move uploaded file.";
            }
        } else {
            echo "Invalid file type. Only JSON files are allowed.";
        }
    } else {
        echo "No file uploaded or upload error.";
    }
}
?>