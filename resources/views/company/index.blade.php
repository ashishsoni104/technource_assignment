@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="card">
            <div class="card-header">{{ __('Company') }}</div><br/>
            <div class="col-md-12">
                <div class="row" align="right">
                    <div class="col-md-12">        
                        <a href="{{ route('company.create') }}" class="btn btn-primary">+ Add Company</a>
                    </div>
                </div><br/>
                <table class="table table-bordered" id="company_datatable">
                    <thead>
                        <tr>
                            <th>S.no</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Logo</th>
                            <th>website</th>
                            <th width="100px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
  $(function () {
    
    var table = $('#company_datatable').DataTable({
        lengthMenu: [[5,10, 25, 50, -1], [5,10, 25, 50, "All"]],
        processing: true,
        serverSide: true,
        ajax: "{{ route('company.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'logo_name', name: 'logo_name'},
            {data: 'website', name: 'website'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
    
  });
</script>
@endsection