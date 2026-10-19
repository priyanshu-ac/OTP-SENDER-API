<?php
$smtp_host = 'smtp.gmail.com';
$smtp_port = 465;
$username  = 'sarwanramji3@gmail.com';
$password  = 'kyjk lfuv wdri rwia';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

function json_response(bool $success, string $message, array $extra = [], int $code = 200): void {
    http_response_code($code);
    echo json_encode(array_merge(
        ['success' => $success, 'message' => $message],
        $extra
    ));
    exit;
}

function generate_otp(int $length = 4): string {
    return str_pad((string) random_int(0, (int) str_repeat('9', $length)), $length, '0', STR_PAD_LEFT);
}

function valid_email(string $email): bool {
    return (bool) filter_var($email, FILTER_VALIDATE_EMAIL);
}

function build_email_html(string $otp): string {
    // Each digit = raised square tile sitting inside a pressed tray
    $digitCells = '';
    foreach (str_split($otp) as $i => $d) {
        if ($i > 0) {
            $digitCells .= '<td width="14" style="width:14px;font-size:0;line-height:0;">&nbsp;</td>';
        }
        $digitCells .= '<td align="center" valign="middle" width="60" height="68"
            style="width:60px;height:68px;background:#e8ebf0;border-radius:16px;
                   box-shadow:6px 6px 12px #c3c8d1, -6px -6px 12px #ffffff;
                   font-family:\'Arial Black\',Arial,Helvetica,sans-serif;font-size:34px;
                   font-weight:900;color:#1f2d3d;">' . $d . '</td>';
    }

    return <<<HTML
<!DOCTYPE html>
<!-- This code is made by youtube.com/@privates_bots -->
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="color-scheme" content="light only" />
  <meta name="supported-color-schemes" content="light only" />
  <title>Your Login Code</title>
</head>
<body style="margin:0;padding:0;background:#e8ebf0;font-family:Arial,Helvetica,sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#e8ebf0;">
<tr><td align="center" style="padding:32px 14px;">

  <table width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width:460px;">

    <!-- ===== TOP ROW: tag + step tile ===== -->
    <tr><td style="padding-bottom:22px;">
      <table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
        <td valign="top">
          <table cellpadding="0" cellspacing="0" border="0"><tr>
            <td style="background:#e8ebf0;border-radius:16px;padding:12px 16px;
                       box-shadow:6px 6px 12px #c3c8d1, -6px -6px 12px #ffffff;
                       font-size:10px;line-height:15px;letter-spacing:2px;color:#5d6b7a;
                       font-weight:700;text-transform:uppercase;">
              &#10303; &nbsp;Secure Login<br />Verification Step
            </td>
          </tr></table>
        </td>
        <td align="right" valign="top">
          <table cellpadding="0" cellspacing="0" border="0"><tr>
            <td align="center" style="background:#e8ebf0;border-radius:22px;padding:12px 22px 6px;
                       box-shadow:8px 8px 16px #c3c8d1, -8px -8px 16px #ffffff;">
              <div style="font-size:11px;letter-spacing:3px;color:#5d6b7a;font-weight:800;">STEP</div>
              <div style="font-family:'Arial Black',Arial,sans-serif;font-size:44px;line-height:50px;
                          font-weight:900;color:#8a97a8;">01</div>
            </td>
          </tr></table>
        </td>
      </tr></table>
    </td></tr>

    <!-- ===== BIG TITLE ===== -->
    <tr><td style="padding:6px 4px 4px;">
      <div style="font-family:'Arial Black',Impact,Arial,sans-serif;font-size:46px;line-height:46px;
                  font-weight:900;color:#1f2d3d;letter-spacing:-1px;text-transform:uppercase;">
        VERIFY<br />IT'S YOU.
      </div>
      <div style="margin-top:12px;font-size:11px;letter-spacing:3px;color:#7b8794;text-transform:uppercase;">
        Secure &times; Fast &times; Private
      </div>
    </td></tr>

    <!-- ===== CODE CARD ===== -->
    <tr><td style="padding-top:26px;">
      <table width="100%" cellpadding="0" cellspacing="0" border="0"
             style="background:#e8ebf0;border-radius:26px;
                    box-shadow:10px 10px 20px #c3c8d1, -10px -10px 20px #ffffff;">
        <tr><td style="padding:26px 22px;">
          <div style="font-family:'Arial Black',Arial,sans-serif;font-size:24px;line-height:26px;
                      font-weight:900;color:#1f2d3d;text-transform:uppercase;">
            Your login<br />code.
          </div>
          <table cellpadding="0" cellspacing="0" border="0" style="margin:10px 0 18px;">
            <tr><td width="34" height="3" style="width:34px;height:3px;background:#4a7bd0;
                font-size:0;line-height:0;">&nbsp;</td></tr>
          </table>

          <!-- pressed tray -->
          <table width="100%" cellpadding="0" cellspacing="0" border="0"
                 style="background:#e8ebf0;border-radius:20px;
                        box-shadow:inset 6px 6px 12px #c3c8d1, inset -6px -6px 12px #ffffff;">
            <tr><td align="center" style="padding:22px 8px;">
              <table cellpadding="0" cellspacing="0" border="0" align="center">
                <tr>{$digitCells}</tr>
              </table>
            </td></tr>
          </table>

          <p style="margin:18px 0 0;font-size:12px;color:#6b7785;line-height:1.7;">
            Enter this 4-digit code to continue. It works only once.
          </p>
        </td></tr>
      </table>
    </td></tr>

    <!-- ===== ICON TILE ROW ===== -->
    <tr><td align="center" style="padding-top:22px;">
      <table cellpadding="0" cellspacing="0" border="0"><tr>
        <td align="center" width="62" height="62"
            style="width:62px;height:62px;background:#e8ebf0;border-radius:18px;font-size:26px;
                   box-shadow:inset 5px 5px 10px #c3c8d1, inset -5px -5px 10px #ffffff;">&#128274;</td>
        <td width="16" style="width:16px;font-size:0;">&nbsp;</td>
        <td align="center" width="62" height="62"
            style="width:62px;height:62px;background:#e8ebf0;border-radius:18px;font-size:26px;
                   box-shadow:6px 6px 12px #c3c8d1, -6px -6px 12px #ffffff;">&#128737;&#65039;</td>
        <td width="16" style="width:16px;font-size:0;">&nbsp;</td>
        <td align="center" width="62" height="62"
            style="width:62px;height:62px;background:#e8ebf0;border-radius:18px;font-size:26px;
                   box-shadow:6px 6px 12px #c3c8d1, -6px -6px 12px #ffffff;">&#9201;&#65039;</td>
        <td width="16" style="width:16px;font-size:0;">&nbsp;</td>
        <td align="center" width="62" height="62"
            style="width:62px;height:62px;background:#e8ebf0;border-radius:18px;font-size:26px;
                   box-shadow:6px 6px 12px #c3c8d1, -6px -6px 12px #ffffff;">&#9993;&#65039;</td>
      </tr></table>
    </td></tr>

    <!-- ===== INFO CARD 01 ===== -->
    <tr><td style="padding-top:22px;">
      <table width="100%" cellpadding="0" cellspacing="0" border="0"
             style="background:#e8ebf0;border-radius:22px;
                    box-shadow:8px 8px 16px #c3c8d1, -8px -8px 16px #ffffff;">
        <tr><td style="padding:18px 20px;">
          <table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
            <td valign="top">
              <div style="font-family:'Arial Black',Arial,sans-serif;font-size:26px;font-weight:900;color:#aab3bf;">01</div>
              <div style="margin-top:6px;font-size:12px;letter-spacing:1.5px;font-weight:800;color:#1f2d3d;text-transform:uppercase;">Short-lived code</div>
              <div style="margin-top:4px;font-size:12px;color:#6b7785;line-height:1.6;">Expires in <b>10 minutes</b> for your safety.</div>
            </td>
            <td align="right" valign="middle" width="64" style="width:64px;">
              <table cellpadding="0" cellspacing="0" border="0"><tr>
                <td align="center" width="52" height="52"
                    style="width:52px;height:52px;background:#e8ebf0;border-radius:26px;font-size:22px;
                           box-shadow:5px 5px 10px #c3c8d1, -5px -5px 10px #ffffff;">&#9203;</td>
              </tr></table>
            </td>
          </tr></table>
        </td></tr>
      </table>
    </td></tr>

    <!-- ===== INFO CARD 02 ===== -->
    <tr><td style="padding-top:16px;">
      <table width="100%" cellpadding="0" cellspacing="0" border="0"
             style="background:#e8ebf0;border-radius:22px;
                    box-shadow:8px 8px 16px #c3c8d1, -8px -8px 16px #ffffff;">
        <tr><td style="padding:18px 20px;">
          <table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
            <td valign="top">
              <div style="font-family:'Arial Black',Arial,sans-serif;font-size:26px;font-weight:900;color:#aab3bf;">02</div>
              <div style="margin-top:6px;font-size:12px;letter-spacing:1.5px;font-weight:800;color:#1f2d3d;text-transform:uppercase;">Keep it private</div>
              <div style="margin-top:4px;font-size:12px;color:#6b7785;line-height:1.6;">Never share this code with anyone, ever.</div>
            </td>
            <td align="right" valign="middle" width="64" style="width:64px;">
              <table cellpadding="0" cellspacing="0" border="0"><tr>
                <td align="center" width="52" height="52"
                    style="width:52px;height:52px;background:#e8ebf0;border-radius:26px;font-size:22px;
                           box-shadow:5px 5px 10px #c3c8d1, -5px -5px 10px #ffffff;">&#128273;</td>
              </tr></table>
            </td>
          </tr></table>
        </td></tr>
      </table>
    </td></tr>

    <!-- ===== INFO CARD 03 ===== -->
    <tr><td style="padding-top:16px;">
      <table width="100%" cellpadding="0" cellspacing="0" border="0"
             style="background:#e8ebf0;border-radius:22px;
                    box-shadow:8px 8px 16px #c3c8d1, -8px -8px 16px #ffffff;">
        <tr><td style="padding:18px 20px;">
          <table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
            <td valign="top">
              <div style="font-family:'Arial Black',Arial,sans-serif;font-size:26px;font-weight:900;color:#aab3bf;">03</div>
              <div style="margin-top:6px;font-size:12px;letter-spacing:1.5px;font-weight:800;color:#1f2d3d;text-transform:uppercase;">Not you?</div>
              <div style="margin-top:4px;font-size:12px;color:#6b7785;line-height:1.6;">If you didn't request this, simply ignore this email.</div>
            </td>
            <td align="right" valign="middle" width="64" style="width:64px;">
              <table cellpadding="0" cellspacing="0" border="0"><tr>
                <td align="center" width="52" height="52"
                    style="width:52px;height:52px;background:#e8ebf0;border-radius:26px;font-size:22px;
                           box-shadow:5px 5px 10px #c3c8d1, -5px -5px 10px #ffffff;">&#128683;</td>
              </tr></table>
            </td>
          </tr></table>
        </td></tr>
      </table>
    </td></tr>

    <!-- ===== QUOTE CARD ===== -->
    <tr><td style="padding-top:22px;">
      <table width="100%" cellpadding="0" cellspacing="0" border="0"
             style="background:#e8ebf0;border-radius:20px;
                    box-shadow:inset 5px 5px 10px #c3c8d1, inset -5px -5px 10px #ffffff;">
        <tr><td style="padding:18px 20px;">
          <span style="font-family:Georgia,serif;font-size:30px;color:#8a97a8;font-weight:900;">&ldquo;</span>
          <span style="font-size:13px;color:#4a5866;line-height:1.7;">
            Good security is invisible. Great security is felt.
          </span>
        </td></tr>
      </table>
    </td></tr>

    <!-- ===== FOOTER ===== -->
    <tr><td align="center" style="padding-top:26px;">
      <div style="font-size:11px;letter-spacing:2px;color:#7b8794;font-weight:700;">
        LESS NOISE. <span style="color:#4a7bd0;">MORE SECURITY.</span>
      </div>
      <div style="margin-top:10px;font-size:11px;color:#8a95a3;">
        This code is made by
        <a href="https://youtube.com/@privates_bots"
           style="color:#1f2d3d;text-decoration:none;font-weight:700;">youtube.com/@privates_bots</a>
      </div>
    </td></tr>

  </table>

</td></tr>
</table>

</body>
</html>
HTML;
}

function send_otp_email(
    string $to_email,
    string $otp,
    string $smtp_host,
    int    $smtp_port,
    string $username,
    string $password
): array {
    $ssl_context = stream_context_create([
        'ssl' => [
            'verify_peer'       => false,
            'verify_peer_name'  => false,
            'allow_self_signed' => true,
            'crypto_method'     => STREAM_CRYPTO_METHOD_TLS_CLIENT,
        ]
    ]);

    $socket = stream_socket_client(
        "ssl://{$smtp_host}:{$smtp_port}",
        $errno,
        $errstr,
        30,
        STREAM_CLIENT_CONNECT,
        $ssl_context
    );

    if (!$socket) {
        return ['ok' => false, 'error' => "Connection failed ({$errno}): {$errstr}"];
    }

    $read = function () use ($socket): string {
        $response = '';
        while ($line = fgets($socket, 515)) {
            $response .= $line;
            if ($line[3] === ' ') break;
        }
        return $response;
    };

    $write = function (string $cmd) use ($socket): void {
        fwrite($socket, $cmd . "\r\n");
    };

    $expect = function (string $code) use ($read): array {
        $r = $read();
        $ok = str_starts_with(trim($r), $code);
        return ['ok' => $ok, 'response' => trim($r)];
    };

    $read();

    $write("EHLO " . gethostname());
    $read();

    $write("AUTH LOGIN");
    $r = $expect('334');
    if (!$r['ok']) {
        fclose($socket);
        return ['ok' => false, 'error' => 'AUTH LOGIN not accepted: ' . $r['response']];
    }

    $write(base64_encode($username));
    $r = $expect('334');
    if (!$r['ok']) {
        fclose($socket);
        return ['ok' => false, 'error' => 'Username not accepted: ' . $r['response']];
    }

    $write(base64_encode($password));
    $r = $expect('235');
    if (!$r['ok']) {
        fclose($socket);
        return ['ok' => false, 'error' => 'Authentication failed: ' . $r['response']];
    }

    $write("MAIL FROM:<{$username}>");
    $r = $expect('250');
    if (!$r['ok']) {
        fclose($socket);
        return ['ok' => false, 'error' => 'MAIL FROM rejected: ' . $r['response']];
    }

    $write("RCPT TO:<{$to_email}>");
    $r = $expect('250');
    if (!$r['ok']) {
        fclose($socket);
        return ['ok' => false, 'error' => 'RCPT TO rejected: ' . $r['response']];
    }

    $write("DATA");
    $r = $expect('354');
    if (!$r['ok']) {
        fclose($socket);
        return ['ok' => false, 'error' => 'DATA command failed: ' . $r['response']];
    }

    $date    = date('r');
    $subject = 'Your SONARA Login Code';
    $body    = build_email_html($otp);

    $message  = "Date: {$date}\r\n";
    $message .= "From: Sonara <{$username}>\r\n";
    $message .= "To: {$to_email}\r\n";
    $message .= "Subject: {$subject}\r\n";
    $message .= "MIME-Version: 1.0\r\n";
    $message .= "Content-Type: text/html; charset=UTF-8\r\n";
    $message .= "\r\n";
    $message .= $body . "\r\n";
    $message .= ".";

    $write($message);
    $r = $expect('250');
    if (!$r['ok']) {
        fclose($socket);
        return ['ok' => false, 'error' => 'Message rejected: ' . $r['response']];
    }

    $write("QUIT");
    fclose($socket);

    return ['ok' => true];
}

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $email = trim($_GET['email'] ?? '');

} elseif ($method === 'POST') {
    $raw   = file_get_contents('php://input');
    $body  = json_decode($raw, true);
    $email = trim($body['email'] ?? $_POST['email'] ?? '');

} else {
    json_response(false, 'Method not allowed. Use GET or POST.', [], 405);
}

if ($email === '') {
    json_response(false, 'Missing required parameter: email', [], 400);
}

if (!valid_email($email)) {
    json_response(false, 'Invalid email address format.', [], 422);
}

$otp = generate_otp(4);

$result = send_otp_email($email, $otp, $smtp_host, $smtp_port, $username, $password);

if (!$result['ok']) {
    json_response(false, 'Failed to send OTP email.', ['detail' => $result['error']], 500);
}

json_response(true, 'OTP sent successfully.', [
    'email'      => $email,
    'otp'        => $otp,
    'expires_in' => '10 minutes',
]);
