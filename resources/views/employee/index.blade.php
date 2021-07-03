@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="card">
            <div class="card-header">{{ __('Employee') }}</div><br/>
            <div class="col-md-12">
                <div class="row" align="right">
                    <div class="col-md-12">
                        <a href="{{ route('employee.create') }}" class="btn btn-primary pull-right" >+ Add Employee</a>
                    </div>
                </div><br/>
    
                <table class="table table-bordered" id="employee_datatable">
                    <thead>
                        <tr>
                            <th>S.no</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Company Name</th>
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
    
    var table = $('#employee_datatable').DataTable({
        lengthMenu: [[5,10, 25, 50, -1], [5,10, 25, 50, "All"]],
        processing: true,
        serverSide: true,
        ajax: "{{ route('employee.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'first_name', name: 'first_name'},
            {data: 'last_name', name: 'last_name'},
            {data: 'email', name: 'email'},
            {data: 'phone', name: 'phone'},
            {data: 'company_name', name: 'company_name'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
    
  });
</script>
@endsection