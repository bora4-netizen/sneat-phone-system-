@extends('layouts.app')
@push('styles')
@endpush

@section('content')
<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-fluid flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <form id="formAccountSettings" method="POST" action="{{ route('customers.store', withLang()) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card mb-4">
                        <h5 class="card-header">{{__('customer.register_title')}}</h5>
                        <!-- Account -->
                        @include('customers.includes.__form')
                        @include('customers.includes.__company-form')
                        @include('customers.includes.__guarantor-form')
                        <!-- /Account -->
                        <div class="card-body">
                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary me-2">{{__('button.save')}}</button>
                                <button type="reset" class="btn btn-outline-secondary">{{__('button.cancel')}}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- / Content -->
</div>
<!-- Content wrapper -->
@endsection
@push('script')
    <script>
        $(document).ready(function() {

        $('#customer_type').change(function() {
            var selectedOption = $(this).val();
            if (selectedOption === '2') {
                $('#loanInfo').show();
                $('#guarantorInfo').show();
                $('#storedDocs').show();

            } else {
                $('#loanInfo').hide();
                $('#guarantorInfo').hide();
                $('#storedDocs').hide();
            }
        });
        // Add an event listener to the "confirm" checkbox
        $('#confirm').change(function() {
            if ($(this).is(':checked')) {
                // If the checkbox is checked, enable the submit button
                $('.deactivate-account').prop('disabled', false);
            } else {
                // If the checkbox is not checked, disable the submit button
                $('.deactivate-account').prop('disabled', true);
            }
        });
        $("#upload").on("change", function(e){
            var file = e.target.files[0];
            var mediabase64data;
            getBase64(file).then(
                mediabase64data => $('#uploadedAvatar').attr('src', mediabase64data)
            );
        });
        $('.account-image-reset').click(function(){
            var mediaUserdata = $('.mediaUserdata').val();
            $('#uploadedAvatar').attr('src', mediaUserdata);
        });

        $('#brand').change(function() {
            var brandID = $(this).val();
            $('#series').prop("disabled", false);
            if (brandID !== '') {
                $.ajax({
                    type: 'GET',
                    url: '/en/series/brand/' + brandID,
                    dataType: 'json',
                    success: function(data) {
                        // Clear and populate select2 with new data
                        var series = $('#series');
                        series.empty();
                        series.append('<option>Select an option</option>');
                        if (data.length > 0) {
                            $.each(data, function(key, value) {
                                series.append('<option value="' + value.id + '">' + value.name + '</option>');
                            });
                        }
                    }
                });
            } else {
                // Reset select2 when nothing is selected in select1
                $('#series').empty().append('<option value="">Select an option</option>');
                $('#series').prop("disabled", true);
            }
        });
    });
    function getBase64(file) {
              return new Promise((resolve, reject) => {
                  const reader = new FileReader();
                  reader.readAsDataURL(file);
                  reader.onload = () => resolve(reader.result);
                  reader.onerror = error => reject(error);
              });
          }


    </script>
@endpush
