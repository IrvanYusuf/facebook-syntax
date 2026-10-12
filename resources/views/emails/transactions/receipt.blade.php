<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Receipt</title>
</head>

<body
    style="margin: 0; padding: 0; background-color: #f4f6f8; font-family: Arial, Helvetica, sans-serif; color: #1f2937;">

    <table width="100%" cellpadding="0" cellspacing="0" role="presentation"
        style="background-color: #f4f6f8; padding: 32px 12px;">
        <tr>
            <td align="center">

                <table width="600" cellpadding="0" cellspacing="0" role="presentation"
                    style="max-width: 600px; width: 100%; background-color: #ffffff; border-radius: 12px; overflow: hidden;">

                    {{-- Header --}}
                    <tr>
                        <td style="background-color: #005444; padding: 28px 32px; text-align: center;">
                            <h1 style="margin: 0; color: #ffffff; font-size: 24px;">
                                Transaction Receipt
                            </h1>
                            <p style="margin: 8px 0 0; color: #d1fae5; font-size: 14px;">
                                Thank you for your purchase!
                            </p>
                        </td>
                    </tr>

                    {{-- Content --}}
                    <tr>
                        <td style="padding: 32px;">

                            <p style="margin: 0 0 12px; font-size: 16px;">
                                Hello {{ $transaction->customer->name ?? 'Customer' }},
                            </p>

                            <p style="margin: 0 0 24px; color: #6b7280; font-size: 14px; line-height: 1.7;">
                                Your transaction has been recorded successfully.
                                Here are the details of your purchase.
                            </p>

                            {{-- Transaction Information --}}
                            <table width="100%" cellpadding="0" cellspacing="0" role="presentation"
                                style="background-color: #f9fafb; border-radius: 8px; margin-bottom: 24px;">
                                <tr>
                                    <td style="padding: 16px;">
                                        <p style="margin: 0 0 6px; color: #6b7280; font-size: 12px;">
                                            INVOICE NUMBER
                                        </p>
                                        <p style="margin: 0; font-size: 16px; font-weight: bold;">
                                            {{ $transaction->invoice_number }}
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 0 16px 16px;">
                                        <p style="margin: 0 0 6px; color: #6b7280; font-size: 12px;">
                                            TRANSACTION DATE
                                        </p>
                                        <p style="margin: 0; font-size: 14px;">
                                            {{ $transaction->transaction_date?->format('d M Y, H:i') ?? '-' }}
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 0 16px 16px;">
                                        <p style="margin: 0 0 6px; color: #6b7280; font-size: 12px;">
                                            STATUS
                                        </p>
                                        <span
                                            style="display: inline-block; padding: 6px 12px; border-radius: 20px; background-color: #dcfce7; color: #166534; font-size: 12px; font-weight: bold;">
                                            {{ strtoupper($transaction->status) }}
                                        </span>
                                    </td>
                                </tr>
                            </table>

                            {{-- Items --}}
                            <h2 style="margin: 0 0 16px; font-size: 18px;">
                                Order Summary
                            </h2>

                            <table width="100%" cellpadding="0" cellspacing="0" role="presentation"
                                style="border-collapse: collapse; margin-bottom: 24px;">
                                <thead>
                                    <tr>
                                        <th align="left"
                                            style="padding: 12px 8px; border-bottom: 2px solid #e5e7eb; color: #6b7280; font-size: 12px;">
                                            PRODUCT
                                        </th>
                                        <th align="center"
                                            style="padding: 12px 4px; border-bottom: 2px solid #e5e7eb; color: #6b7280; font-size: 12px;">
                                            QTY
                                        </th>
                                        <th align="right"
                                            style="padding: 12px 8px; border-bottom: 2px solid #e5e7eb; color: #6b7280; font-size: 12px;">
                                            SUBTOTAL
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transaction->items as $item)
                                        <tr>
                                            <td
                                                style="padding: 14px 8px; border-bottom: 1px solid #e5e7eb; font-size: 13px;">
                                                <strong>{{ $item->product->name ?? 'Product unavailable' }}</strong>
                                                <br>
                                                <span style="color: #6b7280; font-size: 12px;">
                                                    Rp {{ number_format((float) $item->unit_price, 0, ',', '.') }} /
                                                    item
                                                </span>
                                            </td>
                                            <td align="center"
                                                style="padding: 14px 4px; border-bottom: 1px solid #e5e7eb; font-size: 13px;">
                                                {{ $item->quantity }}
                                            </td>
                                            <td align="right"
                                                style="padding: 14px 8px; border-bottom: 1px solid #e5e7eb; font-size: 13px; white-space: nowrap;">
                                                Rp
                                                {{ number_format((float) $item->unit_price * $item->quantity, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            {{-- Total --}}
                            <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                <tr>
                                    <td style="padding: 16px 0; border-top: 2px solid #e5e7eb;">
                                        <p style="margin: 0; font-size: 16px; font-weight: bold;">
                                            Total Amount
                                        </p>
                                    </td>
                                    <td align="right"
                                        style="padding: 16px 0; border-top: 2px solid #e5e7eb; white-space: nowrap;">
                                        <p style="margin: 0; color: #005444; font-size: 20px; font-weight: bold;">
                                            Rp {{ number_format((float) $transaction->total, 0, ',', '.') }}
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin: 24px 0 0; color: #6b7280; font-size: 13px; line-height: 1.7;">
                                Please keep this email as your transaction receipt.
                                If you have any questions, feel free to contact our support team.
                            </p>

                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td
                            style="padding: 24px 32px; background-color: #f9fafb; text-align: center; border-top: 1px solid #e5e7eb;">
                            <p style="margin: 0 0 6px; color: #374151; font-size: 13px; font-weight: bold;">
                                Thank you for choosing us!
                            </p>
                            <p style="margin: 0; color: #9ca3af; font-size: 12px;">
                                This is an automated email. Please do not reply directly.
                            </p>
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>
