  <style>
/* ===== Participation Certificate Styles ===== */

.cert-dzongkha-text {
    text-align: center;
    font-size: clamp(36px, 8.5vw, 52px);
    margin-bottom: 6px;
    line-height: 1.3;
    font-weight: 700;
    letter-spacing: 0.05em;
}

.cert-main-title {
    text-align: center;
    font-size: clamp(18px, 3.2vw, 28px);
    margin-bottom: 6px;
    line-height: 1.3;
    font-weight: 600;
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

.cert-logos img {
    width: 90px;
    height: 90px;
    object-fit: contain;
}

.cert-logo-left {
    position: absolute;
    top: 60px;
    left: 90px;
}

.cert-logo-right {
    position: absolute;
    top: 60px;
    right: 90px;
}

.corner {
    position: absolute;
    width: 110px;
    height: auto;
    z-index: 5;
}

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
    margin-top: 70px;
    text-align: center;
    font-size: clamp(12px, 1.8vw, 15px);
    color: #555;
    border-top: 1px solid #ccc;
    padding-top: 15px;
    opacity: 0.8;
}
.cert-serial {
        text-align: center;  
        margin-top: 40px;   /* space from content above */
        margin-bottom: 6px; /* space before the line */      
        font-size: clamp(12px, 1.6vw, 15px);
        font-style: italic;
    }

/* Responsive */
@media (max-width: 768px) {
    .cert-logo-left,
    .cert-logo-right {
        position: static;
    }

    .cert-logos {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }

    .cert-logos img {
        width: 60px;
        height: 60px;
    }

    .corner {
        width: 70px;
    }
     
}
</style>

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
                Certificate of Participation
            </div>

            <div class="cert-body">
                This is to certify that <strong>{{ $record->receivedBy }}</strong>
                bearing CID No. <strong>{{ $cidNo ?? 'N/A' }}</strong>
                has successfully completed training on
                <strong>{{ $record->issuedFor }}</strong>
                held at <strong>{{ $record->issueTo }}</strong>.

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