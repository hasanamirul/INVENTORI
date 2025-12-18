@extends('user.layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Test Email</div>
                <div class="card-body">
                    @if(session('status'))
                        <div class="alert alert-success">{{ session('status') }}</div>
                    @endif

                    <form method="POST" action="{{ route('test.email.send') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="to" class="form-label">To</label>
                            <input type="email" name="to" id="to" class="form-control" value="{{ old('to', config('mail.from.address')) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject</label>
                            <input type="text" name="subject" id="subject" class="form-control" value="{{ old('subject', 'Test Email from Inventori') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="body" class="form-label">Body</label>
                            <textarea name="body" id="body" rows="6" class="form-control">{{ old('body', 'This is a test email from Inventori app.') }}</textarea>
                        </div>

                        <button class="btn btn-primary">Send Test Email</button>
                    </form>
                    @if(session('preview'))
                        @php $p = session('preview'); @endphp
                        <hr>
                        <h5>Preview</h5>
                        <div class="mb-2"><strong>To:</strong> {{ $p['to'] ?? '' }}</div>
                        <div class="mb-2"><strong>Subject:</strong> {{ $p['subject'] ?? '' }}</div>
                        <div class="mb-2"><strong>Body:</strong>
                            <div class="border p-2 bg-light"><pre style="white-space:pre-wrap">{{ $p['body'] ?? '' }}</pre></div>
                        </div>
                        @if(!empty($p['log_snippet']))
                            <div class="mb-2 mt-3"><strong>Log Snippet (last matching lines):</strong>
                                <div class="border p-2 bg-dark text-white"><pre style="white-space:pre-wrap">{{ $p['log_snippet'] }}</pre></div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
