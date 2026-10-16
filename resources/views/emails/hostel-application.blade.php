<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Hostel Application</title>
</head>
<body style="margin:0;padding:25px;background:#f2f5f9;font-family:Arial,sans-serif;color:#1f2a44;">

    <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
        <tr>
            <td align="center">
                <table width="100%" cellpadding="0" cellspacing="0" role="presentation"
                    style="max-width:650px;background:#ffffff;border:1px solid #e3e8f0;border-radius:12px;">

                    <tr>
                        <td style="background:#00539B;padding:25px;color:#ffffff;">
                            <h2 style="margin:0 0 8px;">Al Azhar Central School</h2>
                            <p style="margin:0;color:#dcecff;">New Hostel Application Received</p>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:25px;">
                            <p style="font-size:15px;line-height:1.6;">
                                A new hostel application has been submitted through the school website.
                                Please review the details below.
                            </p>

                            <h3 style="color:#00539B;border-bottom:1px solid #e3e8f0;padding-bottom:10px;">
                                Application Details
                            </h3>

                            <table width="100%" cellpadding="10" cellspacing="0"
                                style="border-collapse:collapse;font-size:14px;">

                                @foreach ($application->getAttributes() as $key => $value)
                                    @continue(in_array($key, [
                                        'id',
                                        'class_name_snapshot',
                                        'created_at',
                                        'updated_at',
                                        'deleted_at',
                                        'ip_address',
                                    ], true))

                                    @continue($value === null || $value === '')

                                    <tr>
                                        <td style="border-bottom:1px solid #eef1f6;color:#6b7489;width:40%;vertical-align:top;">
                                            {{ \Illuminate\Support\Str::headline($key) }}
                                        </td>
                                        <td style="border-bottom:1px solid #eef1f6;font-weight:bold;vertical-align:top;">
                                            @if (is_array($value))
                                                {{ implode(', ', $value) }}
                                            @else
                                                {{ $value }}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

                            </table>

                            <p style="margin:25px 0 0;color:#6b7489;font-size:12px;">
                                This email was automatically generated from the Hostel Application form.
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td style="background:#f6f8fb;padding:15px 25px;color:#8a93a6;font-size:12px;">
                            Al Azhar Central School · Hostel Admissions
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>
</html>