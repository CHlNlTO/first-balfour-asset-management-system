{{-- resources/views/emails/asset-assignment.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Asset Assignment</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header {
            background-color: #0047AB;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .content {
            padding: 30px;
        }

        .logo {
            margin-bottom: 20px;
            text-align: center;
        }

        .footer {
            background-color: #f5f5f5;
            text-align: center;
            padding: 15px;
            font-size: 12px;
            color: #666;
        }

        h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }

        h2 {
            font-size: 18px;
            color: #0047AB;
            margin-top: 25px;
            margin-bottom: 15px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }

        a {
            color: white;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .button {
            display: inline-block;
            background-color: #0047AB;
            color: white;
            text-decoration: none;
            padding: 12px 25px;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 25px;
            text-align: center;
        }

        .asset-details {
            background-color: #f9f9f9;
            border-radius: 5px;
            padding: 15px;
            margin-top: 20px;
        }

        .asset-row {
            display: flex;
            margin-bottom: 10px;
        }

        .asset-label {
            flex: 1;
            font-weight: bold;
            color: #555;
        }

        .asset-value {
            flex: 2;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>New Asset Assignment</h1>
        </div>

        <div class="content">
            <div class="logo">
                <h2>First Balfour, Inc.</h2>
            </div>

            <p>Hello {{ $assignment->employee->first_name }},</p>

            <p>You have been assigned a new asset that requires your approval. Please review the details below and log
                in to the application to approve this assignment.</p>

            <div class="asset-details">
                <h2>Asset Details</h2>

                <div class="asset-row">
                    <div class="asset-label">Asset Type:&nbsp;</div>
                    <div class="asset-value">{{ ucfirst($assignment->asset->asset_type) }}</div>
                </div>

                <div class="asset-row">
                    <div class="asset-label">Asset Name:&nbsp;</div>
                    <div class="asset-value">{{ $assignment->asset->model->brand->name }}
                        {{ $assignment->asset->model->name }}</div>
                </div>

                @if ($assignment->asset->tag_number)
                    <div class="asset-row">
                        <div class="asset-label">Tag Number:&nbsp;</div>
                        <div class="asset-value">{{ $assignment->asset->tag_number }}</div>
                    </div>
                @endif

                @if ($assignment->asset->asset_type === 'hardware' && $assignment->asset->hardware)
                    <div class="asset-row">
                        <div class="asset-label">Serial Number:&nbsp;</div>
                        <div class="asset-value">{{ $assignment->asset->hardware->serial_number ?? 'N/A' }}</div>
                    </div>
                    <div class="asset-row">
                        <div class="asset-label">Specifications:&nbsp;</div>
                        <div class="asset-value">{{ $assignment->asset->hardware->specifications ?? 'N/A' }}</div>
                    </div>
                @elseif($assignment->asset->asset_type === 'software' && $assignment->asset->software)
                    <div class="asset-row">
                        <div class="asset-label">Version:&nbsp;</div>
                        <div class="asset-value">{{ $assignment->asset->software->version ?? 'N/A' }}</div>
                    </div>
                @elseif($assignment->asset->asset_type === 'peripherals' && $assignment->asset->peripherals)
                    <div class="asset-row">
                        <div class="asset-label">Serial Number:&nbsp;</div>
                        <div class="asset-value">{{ $assignment->asset->peripherals->serial_number ?? 'N/A' }}</div>
                    </div>
                    <div class="asset-row">
                        <div class="asset-label">Specifications:&nbsp;</div>
                        <div class="asset-value">{{ $assignment->asset->peripherals->specifications ?? 'N/A' }}</div>
                    </div>
                @endif

                <div class="asset-row">
                    <div class="asset-label">Assignment Date:&nbsp;</div>
                    <div class="asset-value">{{ \Carbon\Carbon::parse($assignment->start_date)->format('M d, Y') }}
                    </div>
                </div>
            </div>

            <div style="text-align: center; margin-top: 30px;">
                <a href="{{ $appUrl }}" class="button">Log in to Approve</a>
            </div>

            <p style="margin-top: 25px;">If you have any questions regarding this assignment, please contact your IT
                department.</p>

            <p>Thank you,<br>
                First Balfour, Inc. IT Department</p>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} First Balfour, Inc. All rights reserved.</p>
            <p>This is an automated message. Please do not reply to this email.</p>
        </div>
    </div>
</body>

</html>
