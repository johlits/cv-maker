<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload JSON File and Logos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        form {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        label {
            display: block;
            margin-bottom: 10px;
        }
        input[type="file"] {
            margin-bottom: 20px;
        }
        button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Upload JSON File and Logos</h1>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <label for="jsonFile">Choose JSON file:</label>
        <input type="file" id="jsonFile" name="jsonFile" accept=".json" required>
        
        <label for="logos">Upload logos (optional):</label>
        <input type="file" id="logos" name="logos[]" multiple accept="image/*">
        
        <button type="submit">Upload</button>
    </form>
</body>
</html>
