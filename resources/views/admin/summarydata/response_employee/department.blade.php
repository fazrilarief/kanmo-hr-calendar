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
            List Division "{{ $divisions }}"
        </div>
        <div class="card-body">
            <x-alert />
            <div class="table-responsive">
                <div class="table-container" style="overflow: hidden; max-height: 500px; overflow-y: scroll;">
                    <table class="table table-bordered" id="dataTable">
                        <thead style="background: #e9500e; color: #ffffff;">
                            <tr>
                                <th>No</th>
                                <th>Department</th>
                                <th>Total Employee Department</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                                $grandTotalEmployeeResponseDepartment = 0;
                            @endphp
                            @foreach ($departments as $department)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>
                                        <a
                                            href="{{ route('admin.summary.response_employee.detail', [
                                                'source' => $department->source,
                                                'division' => $department->division,
                                                'department' => $department->department,
                                            ]) }}">
                                            {{ $department->department }}
                                        </a>
                                    </td>
                                    <td>{{ $department->TotalEmployeeResponseDepartment }}</td>
                                </tr>
                                @php
                                    $grandTotalEmployeeResponseDepartment += $department->TotalEmployeeResponseDepartment;
                                @endphp
                            @endforeach
                        </tbody>
                        <tfoot style="background: #e9500e; color: #ffffff;">
                            <tr>
                                <td colspan="2" class="text-right">Grand Total</td>
                                <td>{{ $grandTotalEmployeeResponseDepartment }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
