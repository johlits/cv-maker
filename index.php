<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload JSON File</title>
</head>
<body>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <label for="file">Choose JSON file:</label>
        <input type="file" name="jsonFile" id="jsonFile" accept=".json">
        <input type="submit" name="submit" value="Upload">
    </form>
</body>
</html>