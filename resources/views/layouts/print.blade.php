<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export</title>

    <style>
        body {
            color: #52525B;
            font-family: Arial, Helvetica, sans-serif;
        }

        h1 {
            color: #0f4069;
            line-height: 1;
            font-size: 3rem;
            margin-bottom: 0;
            font-family: 'DM Serif Text', serif;
        }

        p {
            font-size: 14px;
        }

        span {
            color: #df6c9f;
            display: block;
            font-weight: bold;
            margin-bottom: 2rem;
            font-family: Arial, Helvetica, sans-serif;
        }

        table {
            width: 100%;
            border: 1px solid #eee;
            border-collapse: collapse;
        }


        th,
        td {
            padding: 8px;
            font-size: 14px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        th {
            color: #fff;
            font-size: 14px;
            background-color: #0f4069;
            white-space: nowrap;
            font-family: Arial, Helvetica, sans-serif;
        }
    </style>
</head>

<body>
    {{ $slot }}
</body>

</html>
