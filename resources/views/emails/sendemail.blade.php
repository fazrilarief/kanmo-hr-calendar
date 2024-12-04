<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kanmo - New Question</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <h4>Dear HRD</h4>
        <h4>berikut ada list pertanyaan baru di chat bot dengan detail:</h4>
        <div style="margin-left: 30px;">
            <h4>Employee Name: {{ $data['name'] }}</h4>
            <h4>Employee Nip: {{ $data['nip'] }}</h4>
            <h4>New Question: {{ $data['question'] }}</h4>
        </div>
        <h4>Thanks,</h4>
        <h4>Regards</h4>
        <h4>Kevas Kanmo Group.</h4>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>
