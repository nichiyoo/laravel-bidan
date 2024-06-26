<html>

<body
    style="background-color:#e2e1e0;font-family: Open Sans, sans-serif;font-size:100%;font-weight:400;line-height:1.4;color:#000;">
    <table
        style="max-width:670px;margin:50px auto 10px;background-color:#fff;padding:50px;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px;-webkit-box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24);-moz-box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24);box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24); border-top: solid 10px #0f4069;">
        <thead>
            <tr>
                <th style="text-align:left;">
                    <h1 style="font-size:24px;font-weight:bold;margin:0">{{ $app }}</h1>
                </th>
                <th style="text-align:right;font-weight:400;">{{ $today }}</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="height:35px;">
                </td>
            </tr>
            <tr>
                <td colspan="2" style="border: solid 1px #ddd; padding:10px 20px;">
                    <p style="font-size:14px;margin:0 0 6px 0;">
                        <span style="font-weight:bold;display:inline-block;min-width:150px">Status Janji</span>
                        <b style="color:#0f4069;font-weight:normal;margin:0">{{ $appointment->status }}</b>
                    </p>
                    <p style="font-size:14px;margin:0 0 6px 0;">
                        <span style="font-weight:bold;display:inline-block;min-width:146px">ID Janji</span>
                        {{ $appointment->id }}
                    </p>
                    <p style="font-size:14px;margin:0 0 0 0;">
                        <span style="font-weight:bold;display:inline-block;min-width:146px">Total Harga</span>
                        {{ $price }}
                    </p>
                </td>
            </tr>
            <tr>
                <td style="height:35px;">
                </td>
            </tr>
            <tr>
                <td style="width:50%;padding:20px;vertical-align:top">
                    <p style="margin:0 0 10px 0;padding:0;font-size:14px;">
                        <span style="display:block;font-weight:bold;font-size:13px">Nama</span>
                        {{ $user->name }}
                    </p>
                    <p style="margin:0 0 10px 0;padding:0;font-size:14px;">
                        <span style="display:block;font-weight:bold;font-size:13px;">Email</span>
                        {{ $user->email }}
                    </p>
                    <p style="margin:0 0 10px 0;padding:0;font-size:14px;">
                        <span style="display:block;font-weight:bold;font-size:13px;">Telefon</span>
                        {{ $patient->phone }}
                    </p>
                    <p style="margin:0 0 10px 0;padding:0;font-size:14px;">
                        <span style="display:block;font-weight:bold;font-size:13px;">Alamat</span>
                        {{ $patient->address }}
                    </p>
                </td>
            </tr>

            <tr>
                <td colspan="2" style="font-size:20px;padding:30px 15px 0 15px;">Layanan</td>
            </tr>
            <tr>
                <td colspan="2" style="padding:15px;">
                    <p style="font-size:14px;margin:0;padding:10px;border:solid 1px #ddd;font-weight:bold;">
                        <span style="display:block;font-size:13px;font-weight:normal;">
                            {{ $appointment->service->title }}
                        </span><br>
                        {{ $price }}<br>
                        <b style="font-size:12px;font-weight:300;">{{ $date }} - {{ $time }}</b>
                    </p>
                </td>
            </tr>
        </tbody>
        <tfooter>
            <tr>
                <td colspan="2" style="font-size:14px;padding:50px 15px 0 15px;">
                    <strong style="display:block;margin:0 0 10px 0;">Hormat Kami</strong>
                    {{ $app }}<br>
                    DKI Jakarta, Jalan DKI Jakarta, Jakarta, Indonesia<br>
                    <br>
                    <b>Email:</b> {{ $from }}<br>
                </td>
            </tr>
        </tfooter>
    </table>
</body>

</html>
