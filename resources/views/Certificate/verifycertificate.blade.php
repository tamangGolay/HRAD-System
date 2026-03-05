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

        :root {
            --certificate-frame-max: 1200px;
        }

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
            padding-top: 150px; /* adjust to header height */
        }

        .bpc-header img {
            max-height: 110px;
            width: auto;
        }
        
        .verify-card {
            max-width: var(--certificate-frame-max);
            width: 100%;
            margin: 25px auto;
        }

        .content-frame {
            max-width: var(--certificate-frame-max);
            width: 100%;
            margin: 0 auto;
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

        @media (max-width: 576px) {
        .verify-card {
            margin: 20px 10px;
        }
            .certificate-wrapper {
            min-height: 80vh;
            margin-top: 20px;
            margin-bottom: 40px;

        }

        @media (max-width: 768px) {

            .verify-card {
                margin: 20px auto;
                padding: 0 10px;
            }

            .content-frame {
                padding: 0 10px;
            }

        }
    }
        .result-alert {
        max-width: var(--certificate-frame-max);
        width: 100%;
        margin: 20px auto;
    }

        @media (max-width: 576px) {
        .result-alert {
            margin: 20px 10px;
        }
    }

    .pdf-mode {
         width: 1200px !important;
        max-width: 1200px !important;
        margin: 0 auto !important;
        padding: 0 !important;     /* ⭐ MUST be zero */
        box-sizing: border-box !important;
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
                    class="needs-validation" >
                    @csrf

                    <label class="form-label fw-semibold">Certificate ID</label>
                    <input type="text"
                        name="certificateId"
                        class="form-control"
                        placeholder="Enter Certificate ID or Employee ID for verification"
                        value="{{ old('certificateId', $searchInput ?? '') }}"
                        required>
                      
                        @error('certificateId')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror


                    <div class="invalid-feedback">
                        Certificate or Employee ID is required!
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

    <!-- Result -->
    @if(isset($searched) && $searched)
        @if(is_null($trainingDetails) && is_null($allCertificates))
            <div class="alert alert-warning text-center mt-3 result-alert">
                No certificate record found for the entered Certificate or Employee ID.
            </div>
        @endif

        {{-- SINGLE --}}
        @if(!is_null($trainingDetails) && !is_null($certificateView))

            <div class="content-frame d-flex justify-content-end mb-3">
                <button onclick="downloadSingleCertificate('certificateArea')" class="btn btn-primary">
                    Download PDF
                </button>
            </div>

            <div id="certificateArea" class="content-frame">
                @include($certificateView, ['trainingDetails' => $trainingDetails])
            </div>

        @endif


        {{-- MULTIPLE PAGINATED --}}
        @if(!is_null($allCertificates) && $allCertificates->count() > 0)

        <div class="mt-4">

            <!-- ⭐ SINGLE CONTROL BAR (ONLY ONCE) -->
            <div class="d-flex justify-content-between align-items-center mb-3 content-frame">

                <!-- LEFT: Pagination -->
                <div class="d-flex align-items-center gap-2">
                    <button id="prevCert" class="btn btn-danger btn-sm">Previous</button>

                    <span id="certCounter">
                        1 / {{ $allCertificates->count() }}
                    </span>

                    <button id="nextCert" class="btn btn-success btn-sm">Next</button>
                </div>

                <!-- RIGHT: Download -->
                <button id="downloadBtn" class="btn btn-primary">
                    Download PDF
                </button>

            </div>

            <!-- ⭐ ALL CERTIFICATES -->
            @foreach($allCertificates as $index => $certificate)

                @php
                    $view = match ($certificate->cerType ?? '') {
                        'Appreciation' => 'certificate.types.Appreciation',
                        'Completion'   => 'certificate.types.Completion',
                        'Participation'  => 'certificate.types.Participation',
                        default        => null,
                    };
                    $certId = 'certificateArea_' . $index;
                @endphp

                @if($view)
                    <div class="certificate-slide content-frame"
                        data-cert-id="{{ $certId }}"
                        style="{{ $index == 0 ? '' : 'display:none;' }}">

                        <div id="{{ $certId }}">
                            @include($view, ['trainingDetails' => $certificate])
                        </div>

                    </div>
                @endif

            @endforeach

        </div>

        @endif
    @endif

</div>
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

@if($trainingDetails)
<script>
    const certificateId = "{{ $trainingDetails->certificateId }}";
</script>
@endif

<!-- validation script -->
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

<!-- Auto Footer Year Script -->
<script>
    document.getElementById("currentYear").textContent = new Date().getFullYear();
</script>


<!-- Downloading PDF -->
<script>
function downloadSingleCertificate(elementId) {

    const element = document.getElementById(elementId);

    if (!element) {
        alert("Certificate not found!");
        return;
    }

    const opt = {
        margin: 0,
        filename: `BPC_Certificate_${certificateId}.pdf`,
        image: { type: 'jpeg', quality: 1 },
        html2canvas: {
            scale: 3,
            useCORS: true,
            scrollY: 0
        },
        jsPDF: {
            unit: 'px',
            format: [1200, 800],
            orientation: 'landscape'
        }
    };

    html2pdf().set(opt).from(element).save();
}
</script>

<!-- Pagination Script -->
<script>
document.addEventListener("DOMContentLoaded", function () {

    const slides = document.querySelectorAll(".certificate-slide");
    if (!slides.length) return;

    let current = 0;

    const prevBtn = document.getElementById("prevCert");
    const nextBtn = document.getElementById("nextCert");
    const counter = document.getElementById("certCounter");
    const downloadBtn = document.getElementById("downloadBtn");

    function showSlide(index) {
        slides.forEach(s => s.style.display = "none");
        slides[index].style.display = "block";

        counter.textContent = (index + 1) + " / " + slides.length;

        // Update download button to current certificate
        const certId = slides[index].dataset.certId;
        downloadBtn.onclick = () => downloadSingleCertificate(certId);
    }

    prevBtn.onclick = () => {
        current = (current - 1 + slides.length) % slides.length;
        showSlide(current);
    };

    nextBtn.onclick = () => {
        current = (current + 1) % slides.length;
        showSlide(current);
    };

    // Initialize
    showSlide(0);
});
</script>



<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

</body>
</html>
