<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your OTP Code - AuthenticityHub MCMC</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color: #f4f6f9; padding: 40px 0;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 12px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08); overflow: hidden;">

                    
                    <tr>
                        <td style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%); padding: 30px 40px; text-align: center;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 24px; font-weight: 700; letter-spacing: 1px;">
                                🔒 AuthenticityHub MCMC
                            </h1>
                            <p style="color: #a0b4d4; margin: 8px 0 0; font-size: 13px; letter-spacing: 0.5px;">
                                Secure Administrator Authentication
                            </p>
                        </td>
                    </tr>

                    
                    <tr>
                        <td style="padding: 40px;">
                            <p style="color: #333333; font-size: 16px; margin: 0 0 8px;">
                                Hello, <strong><?php echo e($adminName); ?></strong>
                            </p>
                            <p style="color: #555555; font-size: 14px; line-height: 1.6; margin: 0 0 28px;">
                                A login attempt was detected for your administrator account. To complete the verification process, please use the One-Time Password (OTP) below:
                            </p>

                            
                            <div style="text-align: center; margin: 0 0 28px;">
                                <div style="display: inline-block; background: linear-gradient(135deg, #e8f0fe 0%, #d4e4fc 100%); border: 2px dashed #3b82f6; border-radius: 12px; padding: 20px 40px;">
                                    <span style="font-size: 36px; font-weight: 700; letter-spacing: 12px; color: #1e40af; font-family: 'Courier New', Courier, monospace;">
                                        <?php echo e($otpCode); ?>

                                    </span>
                                </div>
                            </div>

                            
                            <div style="background-color: #fff8e1; border-left: 4px solid #ffa000; border-radius: 0 8px 8px 0; padding: 14px 18px; margin: 0 0 28px;">
                                <p style="color: #e65100; font-size: 13px; margin: 0; font-weight: 600;">
                                    ⏳ This code will expire in 5 minutes.
                                </p>
                                <p style="color: #bf360c; font-size: 12px; margin: 4px 0 0;">
                                    Do not share this code with anyone. AuthenticityHub staff will never ask for your OTP.
                                </p>
                            </div>

                            
                            <div style="background-color: #fce4ec; border-left: 4px solid #e53935; border-radius: 0 8px 8px 0; padding: 14px 18px; margin: 0 0 20px;">
                                <p style="color: #b71c1c; font-size: 13px; margin: 0; font-weight: 600;">
                                    🚨 Didn't request this code?
                                </p>
                                <p style="color: #c62828; font-size: 12px; margin: 4px 0 0;">
                                    If you did not attempt to log in, your account credentials may be compromised. Please change your password immediately and contact the system administrator.
                                </p>
                            </div>
                        </td>
                    </tr>

                    
                    <tr>
                        <td style="background-color: #f8f9fa; padding: 24px 40px; border-top: 1px solid #e9ecef; text-align: center;">
                            <p style="color: #6c757d; font-size: 12px; margin: 0 0 4px;">
                                This is an automated message from <strong>AuthenticityHub MCMC</strong>.
                            </p>
                            <p style="color: #adb5bd; font-size: 11px; margin: 0;">
                                Malaysian Communications and Multimedia Commission (MCMC) &bull; Secure Systems Division
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
<?php /**PATH C:\Users\khale\Desktop\mcmc\myApp\resources\views/emails/admin-otp.blade.php ENDPATH**/ ?>