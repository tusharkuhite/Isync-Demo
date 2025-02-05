<meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex gap-3 top-input-space">
            <h5 class="space">
                Create Modules <span class="total"></span>
            </h5>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body table-responsive">
                        <table class="table table-bordered">
                            <tbody class="table-border-bottom-0">
                                @foreach ($data as $table => $schema)
                                    <tr>
                                        <td style="font-weight: bold;">{{ ucwords($schema) }}</td>
                                        <td><a href="javascript:;" class="create" data-name="{{$schema}}">Create Module</a></td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                        <div class="text-center">
                            <div class="spinner-border m-5 text-warning" role="status" class="text-center" id="ajax-loader"
                                style="display:none;">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Table Columns</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="table-listing">
                        <!-- Table listing will be dynamically injected here -->
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>Column Name</th>
                                    <th>Listing</th>
                                    <th>Add</th>
                                </tr>
                            </thead>
                            <tbody id="table-content">
                                <!-- Dynamic content will populate here -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a  id="create_modules" href="javascript:;" class="btn btn-primary">Confirm</a>
                </div>
            </div>
        </div>
    </div>
    
      <!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap 5 JavaScript Bundle (includes Popper.js) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" ></script>

    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 8px;
            border: 1px solid #ccc;
        }

        .checkbox-inline {
            display: flex;
            align-items: center;
        }

        .checkbox-inline input[type="checkbox"] {
            margin-right: 5px;
        }
        .draggable {
            background-color: #66bbd8;
            margin: 10px;
            cursor: pointer;
            display: inline-block;
        }
        .dropzone {
            width: 200px;
            height: 200px;
            background-color: lightgrey;
            border: 2px dashed #000;
            margin: 20px;
            padding: 10px;
            display: inline-block;
            vertical-align: top;
        }
    </style>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).on('click', '.create', function() {
        var table = $(this).data('name'); // Example: Table name passed as data
        $("#exampleModalLabel").text(`Table: ${table.toUpperCase()}`);
        $("#create_modules").val(table);
        // Example AJAX call to fetch data
        $.ajax({
            url: "{{ route('superadmin.get.table_fields') }}",
            type: 'POST',
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            data: { table: table },
            success: function(response) {
                var html = '';
                $.each(response, function(index, value) {
                    html += `
                        <tr>
                            <td style="text-align:left">${value.COLUMN_NAME}</td>
                            <td ><label for="Listing${index}"><input id="Listing${index}" data-column="${value.COLUMN_NAME}" class="Listing" data-page="Listing"  type="checkbox" /></label></td>
                            <td><label for="Add${index}"><input id="Add${index}" data-column="${value.COLUMN_NAME}" class="Add" data-page="Add" type="checkbox" /></label></td>
                        </tr>`;
                });
                $('#table-content').html(html);
                var myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
                myModal.show();
            }
        });
    });
    
   
    
    $(document).on('click', '#create_modules', function() {
        let data = {}; 
        data.module = $(this).val();
        data.listing = []; 
        data.add = []; 

        $('.Listing:checked').each(function() {
            data.listing.push($(this).attr('data-column'));
        });

        $('.Add:checked').each(function() {
            data.add.push($(this).attr('data-column'));
        });

        $.ajax({
            url: "{{ route('superadmin.create') }}",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: data,
            success: function(response) {
                console.log(response);
            }
        });
    });

</script>

    