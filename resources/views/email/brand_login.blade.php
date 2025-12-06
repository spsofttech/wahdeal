<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Login Details</title>
</head>

<body style="margin: 0; padding: 0; background-color: #f5f5f5; font-family: Arial, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f5f5f5; padding:20px 0;">
        <tr>
            <td align="center">

                <table width="500" cellpadding="0" cellspacing="0"
                    style="background:#ffffff; border-radius:6px; padding:20px; text-align:center;">

                    <tr>
                        <td>
                            <h2 style="margin:0; font-size:22px; color:#333333;">
                                Login Details
                            </h2>
                            <p style="font-size:14px; color:#555; margin-top:10px;">
                                Below are your login credentials for the dashboard.
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:15px 0;">
                            <p style="font-size:18px; margin:5px 0; font-weight:bold; color:#d9534f;">
                                Email: {{ $toEmail }}
                            </p>
                            <p style="font-size:18px; margin:5px 0; font-weight:bold; color:#0275d8;">
                                Password: {{ $password }}
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <p style="font-size:13px; color:#555; margin-top:15px;">
                                Keep this information confidential.
                                You can change your password after logging in.
                            </p>
                        </td>
                    </tr>



                </table>

            </td>
        </tr>
    </table>

</body>

</html>