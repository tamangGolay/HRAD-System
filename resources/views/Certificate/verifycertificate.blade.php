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

        /* .page-wrapper {
            min-height: calc(100vh - 220px); 
        } */

        @media (max-width: 576px) {
        .verify-card {
            margin: 20px 10px;
        }

        
            .certificate-wrapper {
            min-height: 80vh;
            margin-top: 20px;
            margin-bottom: 40px;

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
    width: 1200px !important;
    max-width: 1200px !important;
    padding: 10px 90px !important; /* same as your on-screen padding */
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
                    class="needs-validation" >
                    @csrf

                    <label class="form-label fw-semibold">Certificate ID</label>
                    <input type="text"
                        name="certificateId"
                        class="form-control"
                        placeholder="Enter Certificate ID"
                        required>
                      
                        @error('certificateId')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror


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

        @if($trainingDetails)

         <div class="text-end mb-3" style="max-width:1100px;margin:auto;">
            <!-- <button onclick="printCertificate()" class="btn btn-success me-2">
                Print
            </button> -->
            <button onclick="downloadCertificate()" class="btn btn-primary">
                Download PDF
            </button>
        </div>

       
@if($searched && $trainingDetails)
<div class="certificate-section" style="width: 100%;padding: 0; margin: 0;position: relative; z-index: 10;">
    <div style="width: 100%; margin: 0 auto;">
        @include($certificateView)
    </div>
</div>
@endif


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

     console.log("Scroll Height:", element.scrollHeight);
    console.log("Client Height:", element.clientHeight);
    console.log("Offset Height:", element.offsetHeight);

    // Temporarily freeze layout
    element.classList.add("pdf-mode");

    const rect = element.getBoundingClientRect();

    const opt = {
        margin: 0,
        filename: 'certificate.pdf',
        html2canvas: {
            scale: 2,
            useCORS: true,
            scrollY: 0
        },        
           jsPDF: {
            unit: 'px',
            format: [1200, 800], // exact width & height
            orientation: 'landscape'
        },
      pagebreak: { mode: [] } 

    };

    html2pdf().set(opt).from(element).save().then(() => {
        element.classList.remove("pdf-mode");
    });
}
</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

</body>
</html>
