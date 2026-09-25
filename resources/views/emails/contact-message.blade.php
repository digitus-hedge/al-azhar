{{-- Email sent to the school when the Contact Us form is submitted (inline styles for mail clients) --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New website enquiry</title>
</head>
<body style="margin:0;padding:0;background:#f2f5f9;font-family:Arial,Helvetica,sans-serif;color:#1f2a44;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f2f5f9;padding:30px 12px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:600px;background:#ffffff;border-radius:12px;overflow:hidden;border:1px solid #e3e8f0;">

                    {{-- Header --}}
                    <tr>
                        <td style="background:#00539B;padding:24px 28px;">
                            <p style="margin:0;color:#cfe1f3;font-size:12px;letter-spacing:1.5px;text-transform:uppercase;">Al Azhar Central School · Website</p>
                            <h1 style="margin:6px 0 0;color:#ffffff;font-size:22px;line-height:1.3;">New Contact Form Enquiry</h1>
                        </td>
                    </tr>

                    {{-- Details --}}
                    <tr>
                        <td style="padding:26px 28px 8px;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="font-size:15px;">
                                @foreach ([
                                    'Name'     => e($c->name),
                                    'Email'    => '<a href="mailto:' . e($c->email) . '" style="color:#00539B;">' . e($c->email) . '</a>',
                                    'Phone'    => $c->phone ? '<a href="tel:' . e(preg_replace('/[^0-9+]/', '', $c->phone)) . '" style="color:#00539B;">' . e($c->phone) . '</a>' : '—',
                                    'Subject'  => e($c->subject),
                                    'Received' => e(optional($c->created_at)->timezone(config('app.timezone'))->format('d M Y, h:i A') ?? now()->format('d M Y, h:i A')),
                                ] as $label => $value)
                                    <tr>
                                        <td style="padding:9px 0;border-bottom:1px solid #eef1f6;width:110px;color:#6b7489;vertical-align:top;">{{ $label }}</td>
                                        <td style="padding:9px 0;border-bottom:1px solid #eef1f6;font-weight:bold;vertical-align:top;">{!! $value !!}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </td>
                    </tr>

                    {{-- Message --}}
                    <tr>
                        <td style="padding:18px 28px 6px;">
                            <p style="margin:0 0 8px;color:#6b7489;font-size:13px;text-transform:uppercase;letter-spacing:1px;">Message</p>
                            <div style="background:#f6f8fb;border-left:4px solid #00539B;border-radius:6px;padding:16px 18px;font-size:15px;line-height:1.7;">
                                {!! nl2br(e($c->message)) !!}
                            </div>
                        </td>
                    </tr>

                    {{-- Reply button --}}
                    <tr>
                        <td style="padding:22px 28px 28px;">
                            <a href="mailto:{{ $c->email }}?subject={{ rawurlencode('Re: ' . $c->subject) }}"
                               style="display:inline-block;background:#00539B;color:#ffffff;text-decoration:none;font-weight:bold;font-size:15px;padding:12px 26px;border-radius:30px;">
                                Reply to {{ $c->name }}
                            </a>
                            <p style="margin:14px 0 0;color:#8a93a6;font-size:13px;">
                                You can also just press "Reply": it goes to the visitor's email address.
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td style="background:#f6f8fb;padding:14px 28px;color:#8a93a6;font-size:12px;border-top:1px solid #e3e8f0;">
                            Sent automatically from the Contact Us page of the school website. The message is also saved in the admin panel.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>