<style>
/* ===== Certificate Layout ===== */

  .certificate-wrapper {
    width: 100%;
    max-width: 1200px;
    min-height: 800px;
    /* height: 800px; */
    margin: 0 auto;
    /* padding: 20px 100px; */
    
    padding: 10px 90px; 
    box-sizing: border-box;
    display: flex;
    flex-direction: column;
    justify-content: center;   /* vertical center only */

    background: url("{{ asset('assets/images/background.png') }}") no-repeat center center;
    background-size: contain;
}


/* ===== Header Section ===== */
.cert-header {
    text-align: center;
}

.cert-main-title {
    font-size: 28px;
    font-weight: 700;
}

.cert-sub-small {
    font-size: 13px;
    line-height: 1.4;
}

.cert-italic {
    font-style: italic;
}

/* ===== Title ===== */
.cert-title {
    text-align: center;
    font-size: 30px;
    font-weight: bold;
    text-decoration: underline;
    margin: 20px 0;
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



</style>

<div class="certificate-wrapper" id="certificateArea">

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

    <div class="cert-title">
        Certificate of Completion
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
        ISSUED ON: {{ \Carbon\Carbon::parse($trainingDetails->issueDate)->format('d/m/Y') }}
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
        Visit www.bpc.bt/verifycertificate to verify with certificate id as : <strong>{{ $trainingDetails->certificateId }}</strong>
    </div>

    
</div>
