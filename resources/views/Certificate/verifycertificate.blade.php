<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BPC Online Certificate Verifier</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@300;400;700&display=swap" rel="stylesheet">

    <style>
        body {
            background: #ffffff;
            font-family: 'Merriweather', serif;
            color: #212529;
        }
        /* Typography system */
        h1, h2, h3 {
            font-weight: 700;
        }

        h3 {
            font-size: 28px;
        }

        p {
            font-size: 15px;
        }

        label {
            font-size: 15px;
            font-weight: 500;
        }

        input, button {
            font-size: 16px;
        }
        
        .bpc-header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background: #ffffff;
            border-bottom: 3px solid #198754;
            padding: 24px 0 24px;
            z-index: 1000; /* keeps it above content */
        }

        .page-wrapper {
            padding-top: 180px; /* adjust to header height */
        }

        .bpc-header img {
            max-height: 110px;
            width: auto;
        }
        
        .verify-card {
            max-width: 1100px;   /* SAME as certificate-wrapper */
            width: 100%;
            margin: 40px auto;
        }
       .alert-success {
            background-color: #e9f7ef;
            border-color: #b7dfc6;
            color: #0f5132;
        }

        .alert-warning {
            background-color: #fff3cd;
            border-color: #ffeeba;
            color: #664d03;
        }

        .btn-bpc {
            background-color: #198754;
            border-color: #198754;
            color: #fff;
        }

        .btn-bpc:hover {
            background-color: #2fbf71;
            border-color: #2fbf71;
        }

        .btn-reset {
            background-color: #e0a800;
            border-color: #e0a800;
            color: #fff;
        }

        .btn-reset:hover {
            background-color: #ffc107;
            border-color: #ffc107;
        }

        .cert-dzongkha-text {
            text-align: center;
            font-size: clamp(36px, 8.5vw, 52px);
            margin-bottom: 6px;
            line-height: 1.3;
            font-weight: 700; /* Dzongkha a bit lighter if you want */
            letter-spacing: 0.05em;
        }

        .cert-main-title {
            text-align: center;
            font-size: clamp(18px, 3.2vw, 28px);
            margin-bottom: 6px;
            line-height: 1.3;
            font-weight: 600; /* English a bit bolder */
        }

        .certificate-wrapper {
            max-width: 1100px;
            width: 100%;
            margin: 40px auto;
            padding: clamp(20px, 5vw, 60px);
            background: #fff;
            font-family: "Times New Roman", serif;
            border: 6px solid #f1c232;
            outline: 4px solid #e69138;
            outline-offset: -12px;
            box-sizing: border-box;
            position: relative; 
        }

        /* Logo container not needed to position, but keeps things tidy */
        .cert-logos img {
            width: 90px;      /* same box size */
            height: 90px;
            object-fit: contain; /* keeps aspect ratio */
        }

        /* Left logo */
        .cert-logo-left {
            position: absolute;
            top: 60px;
            left: 90px;
        }

        /* Right logo */
        .cert-logo-right {
            position: absolute;
            top: 60px;
            right: 90px;
        }

        @media (max-width: 768px) {
        .cert-logo-left,
        .cert-logo-right {
            position: static;   /* VERY IMPORTANT */
        }

        .cert-logos {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .cert-logos img {
            width: 60px;
            height: 60px;
            object-fit: contain;
        }
        }

        /* base corner style */
        .corner {
            position: absolute;
            width: 110px;   /* adjust if needed */
            height: auto;
            z-index: 5;
        }

        /* place each corner */
        .corner-top-left {
            top: 18px;
            left: 18px;
        }

        .corner-top-right {
            top: 18px;
            right: 18px;
        }

        .corner-bottom-left {
            bottom: 18px;
            left: 18px;
        }

        .corner-bottom-right {
            bottom: 18px;
            right: 18px;
        }

        /* responsive */
        @media (max-width: 768px) {
            .corner {
                width: 70px;
            }
        }
        .cert-header {
            text-align: center;
            line-height: 1.4;
            font-size: clamp(14px, 2vw, 18px);
        }

        .cert-title {
            text-align: center;
            font-size: clamp(20px, 3vw, 30px);
            font-weight: bold;
            text-decoration: underline;
            margin: 20px 0;
        }

        .cert-sub-small {
            font-size: clamp(10px, 1.4vw, 12px);
            line-height: 1.3;
            font-weight: bold;
        }

        .cert-italic {
            font-style: italic;
            letter-spacing: 0.3px;
            font-weight: bold;
        }

        .cert-body {
            margin-top: 30px;
            font-size: clamp(15px, 2.2vw, 20px);
            text-align: center;
            line-height: 1.7;
        }

        .cert-date {
            text-align: center;
            margin-top: 25px;
            font-size: clamp(14px, 2vw, 18px);
            font-weight: bold;
        }

        .cert-footer {
            margin-top: 0px;
            text-align: center;
            font-size: clamp(12px, 1.8vw, 15px);
            color: #555;
            border-top: 1px solid #ccc;
            padding-top: 15px;
            opacity: 0.8;
        }

        .bpc-footer {
            background: #ffffff;
            padding: 18px 0;
            margin-top: 60px;
            font-size: 14px;
        }

        .bpc-footer p {
            line-height: 1.4;
        }

        html, body {
            height: 100%;
        }

        .page-wrapper {
            min-height: calc(100vh - 220px); /* header + footer space */
        }

        @media (max-width: 576px) {
        .verify-card {
            margin: 20px 10px;
        }

        .certificate-wrapper {
            margin: 20px 10px;
        }
    }

        .result-alert {
        max-width: 1100px;   /* same as search + certificate */
        width: 100%;
        margin: 20px auto;
    }

        @media (max-width: 576px) {
        .result-alert {
            margin: 20px 10px;
        }
    }

    @media print {

    body * {
        visibility: hidden;
    }

    #certificateArea, #certificateArea * {
        visibility: visible;
    }

    #certificateArea {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        max-width: 1100px;
        margin: 0 auto;
        padding: 40px;
        transform: none !important;
    }

    .bpc-header,
    .verify-card,
    .btn,
    footer {
        display: none !important;
    }
}


    /* PDF mode (used only when downloading) */
    .pdf-mode {
        width: 1100px !important;
        max-width: 1100px !important;
        padding: 60px !important;
    }

    .pdf-mode .corner {
        width: 110px !important;
    }

    .pdf-mode .cert-logos img {
        width: 90px !important;
        height: 90px !important;
    }

    .cert-serial {
        text-align: center;
        margin-top: 40px;   /* space from content above */
        margin-bottom: 6px; /* space before the line */
        font-size: clamp(12px, 1.6vw, 15px);
        font-style: italic;
    }

    </style>

</head>
<body>
    <div class="bpc-header">
        <div class="container text-center">
            <img src="{{ asset('assets/images/bpc-header.png') }}"
        alt="Bhutan Power Corporation Limited">
        </div>
    </div>

    <div class="page-wrapper">
    <div class="container">

        <!-- Title -->
        <div class="text-center my-4">
            <h3 class="fw-semibold text-success">Online Certificate Verifier</h3>
            <p class="text-muted">Verify the authenticity of issued certificates</p>
        </div>

        <div class="card shadow-sm verify-card">
            <div class="card-body">
                <form method="POST"
                    action="{{ route('verifycertificate.submit') }}"
                    novalidate
                    class="needs-validation">
                    @csrf

                    <label class="form-label fw-semibold">Certificate ID</label>
                    <input type="text"
                        name="certificateId"
                        class="form-control"
                        placeholder="Enter Certificate ID"
                        required>
                    <div class="invalid-feedback">
                        Certificate ID is required!
                    </div>

                    <div class="d-flex gap-2 mt-3">
                    <button type="submit" class="btn btn-bpc flex-fill">
                        Search
                    </button>

                <a href="{{ route('verifycertificate.page') }}" class="btn btn-reset flex-fill">
                        Reset
                    </a>
                </div>


                </form>
            </div>
        </div>
    </div>

    <!-- Result -->
        @if($searched)

        @if($record)

        <div class="text-end mb-3" style="max-width:1100px;margin:auto;">
            <button onclick="printCertificate()" class="btn btn-success me-2">
                Print
            </button>
            <button onclick="downloadCertificate()" class="btn btn-primary">
                Download PDF
            </button>
        </div>


        <div class="certificate-wrapper" id="certificateArea">
            <div class="cert-logos">
            <img src="{{ asset('assets/images/logo-1.png') }}" class="cert-logo-left" alt="Left Logo">
            <img src="{{ asset('assets/images/logo-2.png') }}" class="cert-logo-right" alt="Right Logo">
        </div>

        <img src="{{ asset('assets/images/corner-1.png') }}" class="corner corner-top-left">
        <img src="{{ asset('assets/images/corner-2.png') }}" class="corner corner-top-right">
        <img src="{{ asset('assets/images/corner-3.png') }}" class="corner corner-bottom-left">
        <img src="{{ asset('assets/images/corner-4.png') }}" class="corner corner-bottom-right">



            <div class="cert-dzongkha-text"> 
                ༄༅། །འབྲུག་གློག་མེ་ལས་འཛིན།།
            </div>
            <div class="cert-header">
                <div class="cert-main-title">
                    Bhutan Power Corporation Limited
                </div>
                <div class="cert-sub-small">
                    <span class="cert-italic">  
                        (An ISO 9001:2015, ISO 14001:2015 & ISO45001:2018 Certified Company)
                    </span><br>
                    (Registered Office: Thimphu)<br>
                    Thimphu: Bhutan
                </div>
            </div>

            <div class="cert-title">
                {{ $certificateTitle }}
            </div>


            <div class="cert-body">
                This is to certify that 
                <strong>{{ $record->receivedBy }}</strong> 
                (<strong>{{ $record->issueTo }}</strong>)
                bearing CID No. <strong>{{ $cidNo ?? 'N/A' }}</strong>
                has successfully completed training on
                <strong>{{ $record->issuedFor }}</strong>
                from 
                <strong>
                    {{ \Carbon\Carbon::parse($record->startDate)->format('d') }}
                    -
                    {{ \Carbon\Carbon::parse($record->endDate)->format('d F, Y') }}
                </strong>
                held at 
                <strong>{{ $record->venue }}</strong>.
            </div>


            <div class="cert-date">
                ISSUED ON: {{ \Carbon\Carbon::parse($record->issueDate)->format('d/m/Y') }}
            </div>

            <div class="cert-serial">
                Certificate Serial No: 
                <strong>{{ $record->certificateId }}</strong>
            </div>

            <div class="cert-footer">
                This is a system generated certificate and does not require a physical signature.
            </div>

        </div>

        @else
            <div class="alert alert-warning text-center mt-3 result-alert">
                No certificate record found for the entered Certificate ID.
            </div>

        @endif

    @endif


</div>

<footer class="bpc-footer">
    <div class="container text-center">
        <p class="mb-0 fw-semibold">
            <span id="currentYear"></span> Bhutan Power Corporation Limited
        </p>
        <p class="mb-0 small text-muted">
            All rights reserved | Online Certificate Verifier
        </p>
    </div>
</footer>


<script>
(() => {
    'use strict';

    const forms = document.querySelectorAll('.needs-validation');

    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
})();
</script>

<script>
    document.getElementById("currentYear").textContent = new Date().getFullYear();
</script>

<script>
function printCertificate() {
    window.print();
}
</script>


<script>
function downloadCertificate() {
    const element = document.getElementById("certificateArea");

    // Temporarily freeze layout
    element.classList.add("pdf-mode");

    const rect = element.getBoundingClientRect();

    const opt = {
        margin: 0,
        filename: 'certificate.pdf',
        html2canvas: {
            scale: 3,
            useCORS: true,
            scrollY: 0
        },
        jsPDF: {
            unit: 'px',
            format: [rect.width, rect.height],
            orientation: 'landscape'
        }
    };

    html2pdf().set(opt).from(element).save().then(() => {
        element.classList.remove("pdf-mode");
    });
}
</script>




<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>



</body>
</html>
