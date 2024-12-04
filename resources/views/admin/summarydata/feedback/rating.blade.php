<x-app-layout title="Dashboard Admin">
    <style>
        .table-container::-webkit-scrollbar {
            display: none;
        }

        .table-container {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
    <div class="card my-4">
        <div class="card-header" style="background: #e9500e; color: #ffffff;">
            List Summary Employee Feedback For Team {{ Auth::guard('admin')->user()->department }}
        </div>
        <div class="card-body">
            <x-alert />
            <div class="table-responsive">
                <div class="table-container" style="overflow: hidden; max-height: 500px; overflow-y: scroll;">
                    <table class="table table-bordered" id="dataTable">
                        <thead style="background: #e9500e; color: #ffffff;">
                            <tr>
                                <th>No</th>
                                <th>NIP</th>
                                <th>Name</th>
                                <th>Department</th>
                                <th>Division</th>
                                <th>Score</th>
                                <th>Feedback</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($employeeFeedbacks as $employee)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $employee->employee->nip }}</td>
                                    <td>{{ $employee->employee->name }}</td>
                                    <td>{{ $employee->employee->division }}</td>
                                    <td>{{ $employee->employee->department }}</td>
                                    <td>{{ $employee->rating }}</td>
                                    <td>{{ $employee->feedback }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
