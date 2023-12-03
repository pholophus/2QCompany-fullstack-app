@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <div class="jumbotron text-center">
        <h1 class="display-4">TwoQCompanies</h1>
        <p class="lead">Preliminary Test</p>
    </div>

    <!-- Add button container -->
    <div class="mb-4 text-right">
        <a href="{{route('companies.create')}}" id="addButton" class="btn btn-primary">Add Company</a>
    </div>

    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Logo</th>
                <th>Name</th>
                <th>Email</th>
                <th width="100px">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

    <div class="modal fade" id="deleteCompanyModal" tabindex="-1" aria-labelledby="deleteCompanyLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteCompanyLabel">Delete Company</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    This action will delete the company. Click the confirm button to continue.
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary confirm-delete-btn">Confirm</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    let companyId;

    $(document).ready(function() {
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('companies.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'image',
                    name: 'image'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: true
                },
            ]
        });
    });

    $('.data-table').on('click', '.delete-btn', function () {
        var companyId = $(this).data('id');

        $('#deleteCompanyModal').modal('show');

        // // Handle delete button click in the modal
        $('#deleteCompanyModal').find('.confirm-delete-btn').on('click', function () {
            console.log("comapny id process ", companyId)
            // Make an AJAX request to delete the item
            $.ajax({
                url: '/companies/' + companyId,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}',
                    "id": companyId
                },
                success: function (response) {
                    // Refresh DataTable after successful deletion
                    $('.data-table').DataTable().ajax.reload();
                    // Close the delete modal
                    $('#deleteCompanyModal').modal('hide');
                },
                error: function (error) {
                    // Handle errors
                    console.log(error);
                }
            });
        });
    });
</script>

@endsection