<style>
/* ===== Certificate Layout ===== */

  .certificate-wrapper {
    width: 1200px;
    height: 800px;   
    margin: 0 auto; 
    padding: 120px 90px 60px 90px; 
    box-sizing: border-box;
    display: block;
    background: url("{{ asset('assets/images/background3.png') }}") no-repeat center center;
    background-size: 100% 100%;
    zoom: var(--cert-zoom);
}


/* ===== Header Section ===== */
.cert-header {
    text-align: center;
}

.cert-main-title {
    font-size: clamp(18px, 2.2vw, 28px);
    font-weight: 700;
    line-height: 1.2;
}

.cert-sub-small {
    font-size: clamp(10px, 1.05vw, 13px);
    line-height: 1.4;
}

.cert-italic {
    font-style: italic;
}

/* ===== Title ===== */

.cert-title-wrapper {
    text-align: center;
    margin: 20px 0;
}
.cert-title {
    /* text-align: center; */
    font-size: 30px;
    font-weight: bold;    
    display: inline-block;
    border-bottom: 2px solid black;
    padding-bottom: 2px; 
}

/* ===== Body ===== */
.cert-body {
    text-align: center;
    font-size: 20px;
    line-height: 1.8;
    padding: 0 40px;
}

/* ===== Date ===== */
.cert-date {
    text-align: center;
    font-size: 16px;
    font-weight: bold;
    margin-top: 30px;
}

/* ===== Signature Section ===== */
.cert-signature-section {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    padding: 0 60px;
}

.cert-sign-box {
    text-align: center;
    width: 250px;
}

.cert-sign-box img {
    width: 150px;
    margin-bottom: 5px;
}

.cert-sign-name {
    font-weight: bold;
    border-top: 1px solid #000;
    padding-top: 5px;
    margin-top: 5px;
}

.cert-sign-designation {
    font-size: 14px;
}

/* ===== Serial ===== */
.cert-serial {
    text-align: center;
    font-size: 13px;
    margin-top: 10px;
}

.certificate-scale-wrapper {
    --cert-scale: 1;
    --cert-zoom: 1;
    width: 100%;
    max-width: 100%;
    margin: 0 auto;
    overflow: hidden;
    display: block;
    padding: 0;
    box-sizing: border-box;
    min-height: 800px;
}

@supports not (zoom: 1) {
    .certificate-wrapper {
        transform-origin: top center;
        transform: scale(var(--cert-scale));
    }
}

</style>

<div class="certificate-scale-wrapper">
<div class="certificate-wrapper">

    <div class="cert-header">
        <div class="cert-main-title">
            Bhutan Power Corporation Limited
        </div>
        <div class="cert-sub-small">
            <span class="cert-italic">(An ISO 9001:2015, ISO 14001:2015 & ISO45001:2018 Certified Company)</span><br>
            (Registered Office: Thimphu)<br>
            Thimphu: Bhutan
        </div>
    </div>

    

     <div class="cert-title-wrapper">
         <span class="cert-title">Certificate of Completion</span>
    </div>

    <div class="cert-body">
        This is to certify that 
        <strong>
        {{ $trainingDetails->title }}{{ $trainingDetails->name }}
        </strong>
        bearing CID No. <strong>{{ $trainingDetails->CID }}</strong>
        has successfully completed training on
        <strong>{{ ucfirst(strtolower($trainingDetails->trainingName)) }}</strong>.         
        <br>
            The training was conducted from
        <strong>
            {{ \Carbon\Carbon::parse($trainingDetails->startDate)->format('d/m/Y') }}
             to 
            {{ \Carbon\Carbon::parse($trainingDetails->endDate)->format('d/m/Y') }}
        </strong>
         <br>
        at the         
        <strong>{{ $trainingDetails->place }}</strong>.
    </div>

    

    <div class="cert-date">
    Issued on <strong>
        {{ \Carbon\Carbon::parse($trainingDetails->issueDate)->format('jS \d\a\y \o\f \t\h\e \m\o\n\t\h \o\f F, Y') }}
    </strong>
    </div>

    <div class="cert-signature-section">

    <!-- Left Signature -->
            <div class="cert-sign-box">
            @php
                $signer1Name = $trainingDetails->signer1Name ?? '';
                // Convert name to lowercase, remove spaces, and append 'sign.png'
                $signer1Image = $signer1Name 
                                ? 'assets/images/' . strtolower(str_replace(' ', '', $signer1Name)) . 'sign.png'
                                : 'assets/images/default-sign.png'; // fallback
            @endphp

            <img src="{{ asset($signer1Image) }}" alt="Signature 1"> 
            <div class="cert-sign-name">
                {{ $signer1Name }}
            </div>
            <div class="cert-sign-designation">
                {{ $trainingDetails->signer1Designation ?? '' }}
            </div>
        </div>

    <!-- Right Signature -->
    <div class="cert-sign-box">

        @php
            $signer2Name = $trainingDetails->signer2Name ?? '';
            $signer2Image = $signer2Name 
                            ? 'assets/images/' . strtolower(str_replace(' ', '', $signer2Name)) . 'sign.png'
                            : 'assets/images/default-sign.png'; // fallback
        @endphp

        <img src="{{ asset($signer2Image) }}" alt="Signature 2">
        <div class="cert-sign-name">
            {{ $signer2Name }}
        </div>
        <div class="cert-sign-designation">
            {{ $trainingDetails->signer2Designation ?? '' }}
        </div>
    </div>

</div>

<div class="cert-serial">
        Visit https://hris.bpc.bt/verifycertificate to verify with certificate id as : <strong>{{ $trainingDetails->certificateId }}</strong>
    </div>

    
</div>
</div>
