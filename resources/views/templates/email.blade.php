<!doctype html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'fa' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>{{ $title ?? config('app.name') }}</title>
</head>
<body style="margin:0;padding:0;background:#f3f4f6;font-family:Arial,Helvetica,sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f3f4f6;padding:24px 0;">
    <tr>
        <td align="center">
            <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:12px;overflow:hidden;">
                <tr>
                    <td style="padding:20px 24px;background:#111827;color:#fff;">
                        <h2 style="margin:0;font-size:18px;line-height:1.5;">
                            {{ $title ?? __('general.email_subject') }}
                        </h2>
                    </td>
                </tr>

                <tr>
                    <td style="padding:24px;color:#111827;">
                        <div style="font-size:14px;line-height:1.9;white-space:pre-line;">
                            {!! nl2br(e($description ?? $message ?? '')) !!}
                        </div>

                        @if(!empty($parameters) && is_array($parameters))
                            <div style="margin-top:18px;padding-top:18px;border-top:1px solid #e5e7eb;">
                                <p style="margin:0 0 8px 0;font-size:12px;color:#6b7280;">
                                    {{ __('general.email_params') }}
                                </p>
                                <ul style="margin:0;padding:0 18px;color:#374151;font-size:12px;line-height:1.7;">
                                    @foreach($parameters as $k => $v)
                                        <li><strong>{{ $k }}:</strong> {{ is_scalar($v) ? $v : json_encode($v) }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </td>
                </tr>

                <tr>
                    <td style="padding:16px 24px;background:#f9fafb;color:#6b7280;font-size:12px;">
                        {{ config('app.name') }} — {{ now()->format('Y/m/d H:i') }}
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
