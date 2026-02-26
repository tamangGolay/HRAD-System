<style>
.welfarerefund{
  font-family: "Times New Roman", Times, serif;
  font-size: 25px;
}
.textfont{
  font-family: Arial, Helvetica, sans-serif;
  font-size: 15px;
}
.preserveLines{
  white-space:normal;
}
</style>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="card">

        <div class="welfarerefund card-header bg-green d-flex justify-content-center">
          <strong>Upload Certificate</strong>
        </div>

        <div class="textfont card-body">

          {{-- Success --}}
          @if(session('success'))
            <div class="alert alert-success">
              {{ session('success') }}
            </div>
          @endif

          {{-- Errors --}}
          @if($errors->any())
            <div class="alert alert-danger">
              <ul class="mb-0">
                @foreach($errors->all() as $err)
                  <li>{{ $err }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <form method="POST"
                action="{{ route('certificate.bulkUpload') }}" enctype="multipart/form-data" accept-charset="UTF-8"> @csrf

            <input type="hidden" class="form-control" value="{{ Auth::user()->empId }}" name="authuser" id="empId">
            <input type="hidden" name="token" id="tokenid" value="{{ csrf_token()}}">

            <div class="textfont form-group row">
              <label class="col-md-2 col-form-label text-md-right">
                &nbsp;&nbsp;&nbsp;Upload Certificate:
              </label>

              <div class="col-md-9">
                <input type="file"
                       name="csv_upload"
                       class="form-control"
                       accept=".csv"
                       required>
<!-- 
                <small class="text-muted d-block mt-2">
                  Excel header must be: <b>eid</b>, <b>trainingId</b>, <b>cerType</b><br>
                  Example rows:
                  <span class="d-block">30000360, 101, Participation</span>
                  <span class="d-block">30000361, 101, Completion</span>
                </small> --> 
<small class="text-muted  d-block mt-2">
  <b>sample for file upload</b><br>
</small>

<div class="mt-2" style="max-width: 500px;">
  <table style="border-collapse: collapse; width: 100%; font-family: Calibri, sans-serif; font-size: 14px;">
    <thead>
      <tr>
        <th style="border: 1px solid #000; padding: 6px;">eid</th>
        <th style="border: 1px solid #000; padding: 6px;">trainingId</th>
        <th style="border: 1px solid #000; padding: 6px;">cerType</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td style="border: 1px solid #000; padding: 6px;">30000360</td>
        <td style="border: 1px solid #000; padding: 6px;">101</td>
        <td style="border: 1px solid #000; padding: 6px;">Participation</td>
      </tr>
      <tr>
        <td style="border: 1px solid #000; padding: 6px;">30000361</td>
        <td style="border: 1px solid #000; padding: 6px;">101</td>
        <td style="border: 1px solid #000; padding: 6px;">Completion</td>
      </tr>
    </tbody>
  </table>
</div>
              </div>
            </div>

            <div class="textfont form-group row">
              <label class="col-md-2 col-form-label text-md-right">
                &nbsp;&nbsp;&nbsp;Notes:
              </label>
              <div class="col-md-9">
                <textarea rows="2"
                          class="form-control preserveLines"
                          name="notes"
                          placeholder="Optional notes...">{{ old('notes') }}</textarea>
              </div>
            </div>

            <div class="form-group row mb-0">
              <div class="col text-right col-form-label col-md-right col-sm-4 col-md-6 col-lg-6">
                <button type="submit" id="notesBtn" class="btn btn-success btn-lg">
                  Upload Certificate
                </button>
              </div>
            </div>
            <br>
            <p  class=text-center style="color:blue"> upload file in .csv format </p>
          </form>

        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
  // Prevent double submit 
  $('form').submit(function () {
    if ($.validator && !$(this).valid()) return;

    var form = $(this);
    $(this).find('input[type="submit"], button[type="submit"]').each(function () {
      $(this).clone(false).removeAttr('id').prop('disabled', true).insertBefore($(this));
      $(this).hide();
      form.prepend($(this));
    });
  });
</script>
