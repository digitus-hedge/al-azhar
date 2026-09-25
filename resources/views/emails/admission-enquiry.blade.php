{{-- Email sent to the school when the Admission enquiry form is submitted (inline styles for mail clients) --}}
@php
    $digits = preg_replace('/\D/', '', (string) $a->parent_phone);
    $waNumber = strlen($digits) === 10 ? '91' . $digits : ltrim($digits, '0');   // Indian 10-digit → add 91
    $hostel = in_array($a->needs_hostel, [1, '1', true], true) ? 'Yes' : 'No';
    $session = method_exists(\App\Models\AdmissionEnquiry::class, 'currentSession')
        ? \App\Models\AdmissionEnquiry::currentSession() : null;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New admission enquiry</title>
</head>
<body style="margin:0;padding:0;background:#f2f5f9;font-family:Arial,Helvetica,sans-serif;color:#1f2a44;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f2f5f9;padding:30px 12px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:600px;background:#ffffff;border-radius:12px;overflow:hidden;border:1px solid #e3e8f0;">

                    {{-- Header --}}
                    <tr>
                        <td style="background:#00539B;padding:24px 28px;">
                            <p style="margin:0;color:#cfe1f3;font-size:12px;letter-spacing:1.5px;text-transform:uppercase;">
                                Al Azhar Central School · Admissions{{ $session ? ' ' . $session : '' }}
                            </p>
                            <h1 style="margin:6px 0 0;color:#ffffff;font-size:22px;line-height:1.3;">New Admission Enquiry</h1>
                        </td>
                    </tr>

                    {{-- Highlight: student + grade --}}
                    <tr>
                        <td style="padding:24px 28px 0;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#eef5fc;border-radius:10px;">
                                <tr>
                                    <td style="padding:16px 18px;">
                                        <p style="margin:0;color:#6b7489;font-size:12px;text-transform:uppercase;letter-spacing:1px;">Student</p>
                                        <p style="margin:4px 0 0;font-size:20px;font-weight:bold;color:#002F5F;">{{ $a->student_name }}</p>
                                    </td>
                                    <td align="right" style="padding:16px 18px;">
                                        <span style="display:inline-block;background:#00539B;color:#ffffff;font-size:14px;font-weight:bold;padding:7px 16px;border-radius:30px;">{{ $a->grade }}</span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    {{-- Details --}}
                    <tr>
                        <td style="padding:18px 28px 8px;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="font-size:15px;">
                                @foreach ([
                                    'Parent'   => e($a->parent_name),
                                    'Mobile / WhatsApp' => '<a href="tel:' . e(preg_replace('/[^0-9+]/', '', $a->parent_phone)) . '" style="color:#00539B;">' . e($a->parent_phone) . '</a>',
                                    'Email'    => $a->parent_email
                                        ? '<a href="mailto:' . e($a->parent_email) . '" style="color:#00539B;">' . e($a->parent_email) . '</a>'
                                        : '<span style="color:#8a93a6;font-weight:normal;">Not given</span>',
                                    'Grade'    => e($a->grade),
                                    'Hostel needed' => $hostel,
                                    'Received' => e(optional($a->created_at)->timezone(config('app.timezone'))->format('d M Y, h:i A') ?? now()->format('d M Y, h:i A')),
                                ] as $label => $value)
                                    <tr>
                                        <td style="padding:9px 0;border-bottom:1px solid #eef1f6;width:150px;color:#6b7489;vertical-align:top;">{{ $label }}</td>
                                        <td style="padding:9px 0;border-bottom:1px solid #eef1f6;font-weight:bold;vertical-align:top;">{!! $value !!}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </td>
                    </tr>

                    {{-- Message (optional) --}}
                    @if (filled($a->message))
                        <tr>
                            <td style="padding:18px 28px 6px;">
                                <p style="margin:0 0 8px;color:#6b7489;font-size:13px;text-transform:uppercase;letter-spacing:1px;">Message / Questions</p>
                                <div style="background:#f6f8fb;border-left:4px solid #00539B;border-radius:6px;padding:16px 18px;font-size:15px;line-height:1.7;">
                                    {!! nl2br(e($a->message)) !!}
                                </div>
                            </td>
                        </tr>
                    @endif

                    {{-- Action buttons --}}
                    <tr>
                        <td style="padding:22px 28px 28px;">
                            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $a->parent_phone) }}"
                               style="display:inline-block;background:#00539B;color:#ffffff;text-decoration:none;font-weight:bold;font-size:15px;padding:12px 24px;border-radius:30px;margin:0 8px 10px 0;">
                                Call Parent
                            </a>
                            @if ($waNumber)
                                <a href="https://wa.me/{{ $waNumber }}"
                                   style="display:inline-block;background:#25D366;color:#ffffff;text-decoration:none;font-weight:bold;font-size:15px;padding:12px 24px;border-radius:30px;margin:0 8px 10px 0;">
                                    WhatsApp
                                </a>
                            @endif
                            @if ($a->parent_email)
                                <a href="mailto:{{ $a->parent_email }}?subject={{ rawurlencode('Admission enquiry – ' . $a->student_name) }}"
                                   style="display:inline-block;background:#ffffff;color:#00539B;border:2px solid #00539B;text-decoration:none;font-weight:bold;font-size:15px;padding:10px 22px;border-radius:30px;margin:0 0 10px 0;">
                                    Email Parent
                                </a>
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <td style="background:#f6f8fb;padding:14px 28px;color:#8a93a6;font-size:12px;border-top:1px solid #e3e8f0;">
                            Sent automatically from the Admission page of the school website. The enquiry is also saved in the admin panel.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>