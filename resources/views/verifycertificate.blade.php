<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BPC Online Certificate Verifier</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f8f9fa;
        }
        .verify-card {
            max-width: 500px;
            margin: 40px auto;
        }
        .badge-verified {
            background-color: #198754;
        }
        .badge-notfound {
            background-color: #dc3545;
        }
    </style>
</head>
<body>

<div class="container">

    <!-- Title -->
    <div class="text-center my-4">
        <h2 class="fw-bold">BPC Online Certificate Verifier</h2>
        <p class="text-muted">Verify the authenticity of issued certificates</p>
    </div>

    <!-- Search Form -->
    <div class="card shadow-sm verify-card">
        <div class="card-body">
            <form method="POST" action="{{ route('verifycertificate.submit') }}">
                @csrf

                <label class="form-label fw-semibold">Certificate ID</label>
                <input type="text"
                       name="certificateId"
                       class="form-control"
                       placeholder="Enter Certificate ID"
                       required>

                <div class="d-grid mt-3">
                    <button class="btn btn-primary">Verify Certificate</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Result -->
    @if($searched)
        <div class="card shadow-sm verify-card mt-4">
            <div class="card-body">

                @if($record)
                    <div class="text-center mb-3">
                        <span class="badge badge-verified px-3 py-2">✔ Certificate Verified</span>
                    </div>

                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <strong>Certificate ID:</strong> {{ $record->certificateId }}
                        </li>
                        <li class="list-group-item">
                            <strong>Issued For:</strong> {{ $record->issuedFor }}
                        </li>
                        <li class="list-group-item">
                            <strong>Issued To:</strong> {{ $record->issueTo }}
                        </li>
                        <li class="list-group-item">
                            <strong>Received By:</strong> {{ $record->receivedBy }}
                        </li>
                        <li class="list-group-item">
                            <strong>Issued Date:</strong> {{ $record->issueDate }}
                        </li>
                    </ul>
                @else
                    <div class="text-center">
                        <span class="badge badge-notfound px-3 py-2">❌ No Data Found</span>
                    </div>
                @endif

            </div>
        </div>
    @endif

</div>

</body>
</html>
