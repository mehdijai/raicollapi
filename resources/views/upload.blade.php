<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>RaïColl</title>
</head>

<body>
    <h1>RaïColl - Upload</h1>

    <form method="POST" action="/api/upload" enctype="multipart/form-data">*
        <fieldset>
            <label for="name">
                Name
            </label>
            <input type="text" name="name" id="name" required>
        </fieldset>
        <fieldset>
            <label for="file">
                File
            </label>
            <input type="file" name="file" id="file" accept="audio/*" required>
        </fieldset>
        <button>Submit</button>
    </form>
</body>

</html>
