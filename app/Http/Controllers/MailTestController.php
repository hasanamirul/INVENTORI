<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailTestController extends Controller
{
    /**
     * Send a simple test email. Accessible only in local environment.
     * Usage: /test-email?to=you@example.com&subject=Hello&body=Hi
     */
    /**
     * Show a simple form to send a test email (local only).
     */
    public function showForm()
    {
        if (! app()->environment('local')) {
            abort(403, 'Test email page is allowed only in local environment.');
        }

        return view('dev.test-email');
    }

    /**
     * Send a test email. Accepts POST form or query params.
     */
    public function sendTest(Request $request)
    {
        if (! app()->environment('local')) {
            abort(403, 'Test email route is allowed only in local environment.');
        }

        $to = $request->input('to', $request->query('to', config('mail.from.address')));
        $subject = $request->input('subject', $request->query('subject', 'Test Email from Inventori'));
        $body = $request->input('body', $request->query('body', 'This is a test email from Inventori app.'));

        try {
            Mail::raw($body, function ($message) use ($to, $subject) {
                $message->to($to)->subject($subject);
            });
        } catch (\Throwable $e) {
            // Capture transport/auth errors and include them in the preview
            $preview = [
                'to' => $to,
                'subject' => $subject,
                'body' => $body,
                'error' => $e->getMessage(),
            ];

            if ($request->expectsJson() || $request->isMethod('get')) {
                return response()->json(array_merge(['status' => 'error'], $preview), 500);
            }

            return redirect()->back()->with('status', "Test email failed: see details below")->with('preview', $preview);
        }

        // Build a preview of the sent email (we already know to/subject/body)
        $preview = [
            'to' => $to,
            'subject' => $subject,
            'body' => $body,
        ];

        // If mailer is 'log', try to extract the most recent log snippet that references the subject
        $mailer = config('mail.default');
        if ($mailer === 'log') {
            $logPath = storage_path('logs/laravel.log');
            if (file_exists($logPath)) {
                $lines = @file($logPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [];
                // search backwards for a line that contains the subject or the 'Message' marker
                $foundIndex = null;
                for ($i = count($lines) - 1; $i >= 0; $i--) {
                    if (stripos($lines[$i], $subject) !== false || stripos($lines[$i], 'Message-ID') !== false || stripos($lines[$i], 'To:') !== false) {
                        $foundIndex = $i;
                        break;
                    }
                }
                if (! is_null($foundIndex)) {
                    $start = max(0, $foundIndex - 12);
                    $end = min(count($lines) - 1, $foundIndex + 12);
                    $snippet = array_slice($lines, $start, $end - $start + 1);
                    $preview['log_snippet'] = implode("\n", $snippet);
                } else {
                    // fall back to last 40 lines
                    $tail = array_slice($lines, -40);
                    $preview['log_snippet'] = implode("\n", $tail);
                }
            }
        }

        if ($request->expectsJson() || $request->isMethod('get')) {
            return response()->json(array_merge(['status' => 'ok'], $preview));
        }

        return redirect()->back()->with('status', "Test email sent to {$to}")->with('preview', $preview);
    }
}
