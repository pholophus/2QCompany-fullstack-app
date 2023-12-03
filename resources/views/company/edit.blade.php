@extends('layouts.app')

@section('content')

<div class="container">
    <form method="POST" action="{{ route('companies.update', ['company' => $company->id]) }}" enctype="multipart/form-data" id="companyForm">
        @csrf
        @method('put')

        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Edit Company</h4>
            </div>
            <div class="card-body">

                <div class="form-group mb-3">
                    <label for="name">Company Name</label>
                    <input type="text" name="name" class="form-control" id="name" value="{{$company->name}}" placeholder="Enter company name" required>
                    <div class="invalid-feedback"></div>
                </div>

                <div class="form-group mb-3">
                    <label for="website">Website</label>
                    <input type="text" name="website" class="form-control" id="website" value="{{$company->website}}" placeholder="Enter company website" required>
                    <div class="invalid-feedback"></div>
                </div>

                <div class="form-group mb-3">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" id="email" value="{{$company->email}}" placeholder="Enter company email" required>
                    <div class="invalid-feedback"></div>
                </div>

                <div class="form-group mb-3">
                    <label for="logo">Logo</label>
                    <div class="custom-file">
                        <input type="file" name="logo" class="custom-file-input" id="logo" onchange="previewFile()" required>
                        <label class="custom-file-label" for="logo" id="logo-name"></label>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>

                <div class="form-group">
                    <img id="filePreview" src="{{asset('storage/logos/' . $company->logo)}}" alt="File Preview" style="max-width: 100px; display: block;">
                </div>

            </div>

            <div class="card-footer">
                <button type="button" id="submitBtn" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {

        $('#submitBtn').on('click', function() {
            handleSubmit();
        });

        const handleSubmit = async () => {
            const isValid = await validateForm();
            // const isValid = true;

            if (isValid) {
                const form = $('#companyForm')[0];
                const formData = new FormData(form);

                $.ajax({
                    url: form.action,
                    method: form.method,
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        window.location.href = '{{ route("companies.index") }}';
                    },
                    error: function(error) {
                        console.error('Error submitting form:', error);
                        handleValidationErrors(error.responseJSON.errors);
                    }
                });
            }
        }

        const handleValidationErrors = (errors) => {
            $('.invalid-feedback').hide();
            let errorMessageAlert = "";

            for (const field in errors) {
                const errorMessage = errors[field]; // Take the first error for simplicity
                const errorElement = $(`#${field}`).siblings('.invalid-feedback');

                errorMessageAlert += `\u2022 ${errorMessage}<br>`;

                errorElement.text(errorMessage);
                errorElement.show(); // Show the error element if it was hidden
            }

            showAlert('Error ', errorMessageAlert , 'error');
        }

        const validateForm = async () => {
            const fileInput = $('#logo')[0].files[0];

            if (fileInput) {
                const img = new Image();
                img.src = window.URL.createObjectURL(fileInput);

                // Wrap the image loading in a promise
                await new Promise((resolve) => {
                    img.onload = resolve;
                });

                if (img.width < 100 || img.height < 100) {
                    showAlert('Warning', 'Image must be at least 100x100 pixels', 'warning');
                    return false; // Prevent form submission
                }
            }

            return validateOtherInputs();
        };



        const validateOtherInputs = () => {
            const name = $('#name').val();
            if (name.trim() === '') {
                showAlert('Warning', 'Company name is required', 'warning');
                return false; // Prevent form submission
            }

            const website = $('#website').val();
            if (website.trim() === '') {
                showAlert('Warning', 'Website name is required', 'warning');
                return false; // Prevent form submission
            }

            const email = $('#email').val();
            if (email.trim() === '') {
                showAlert('Warning', 'Email is required', 'warning');
                return false; // Prevent form submission
            }

            // If all validations pass, the form will be submitted
            return true;
        }

        $('#logo').on('change', function() {
            previewFile();
        });

        const previewFile = () => {
            const preview = $('#filePreview')[0];
            const fileInput = $('#logo')[0].files[0];
            $('#logo-name').text(fileInput.name);

            if (fileInput) {
                const reader = new FileReader();

                reader.onloadend = function() {
                    preview.src = reader.result;// Set the max width here
                };

                reader.readAsDataURL(fileInput);
            } else {
                preview.src = '';
                preview.style.display = 'none';
            }
        }

    });
</script>

@endsection