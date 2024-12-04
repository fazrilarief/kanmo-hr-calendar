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
                                <th>Total Employee Response Department</th>
                                <th>Total Employee Without Response Department</th>
                                <th>Total Department Percentage</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                                $grandTotalEmployeeDepartment = 0;
                                $grandTotalEmployeeResponseDepartment = 0;
                                $grandTotalEmployeeWithoutResponseDepartment = 0;
                            @endphp
                            @foreach ($departments as $department)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $department->department }}</td>
                                    <td>{{ $department->TotalEmployeeDepartment }}</td>
                                    <td>
                                        <a
                                            href="{{ route('admin.summary.employee.response.division', ['source' => $department->source, 'division' => $department->division, 'department' => $department->department]) }}">
                                            {{ $department->TotalEmployeeResponseDepartment }}
                                        </a>
                                    </td>
                                    <td>
                                        <a
                                            href="{{ route('admin.summary.employee.not.response.division', ['source' => $department->source, 'division' => $department->division, 'department' => $department->department]) }}">
                                            {{ $department->TotalEmployeeWithoutResponseDepartment }}
                                        </a>
                                    </td>
                                    <td>
                                        @if ($department->TotalEmployeeDepartment != 0)
                                            {{ number_format(($department->TotalEmployeeResponseDepartment / $department->TotalEmployeeDepartment) * 100, 2) . '%' }}
                                        @else
                                            0%
                                        @endif
                                    </td>
                                </tr>
                                @php
                                    $grandTotalEmployeeDepartment += $department->TotalEmployeeDepartment;
                                    $grandTotalEmployeeResponseDepartment += $department->TotalEmployeeResponseDepartment;
                                    $grandTotalEmployeeWithoutResponseDepartment += $department->TotalEmployeeWithoutResponseDepartment;
                                @endphp
                            @endforeach

                            @php
                                $grandTotalEmployeePercentageDepartment = $grandTotalEmployeeResponseDepartment != 0 && $grandTotalEmployeeDepartment != 0 ? ($grandTotalEmployeeResponseDepartment / $grandTotalEmployeeDepartment) * 100 : 0;
                            @endphp

                        <tfoot style="background: #e9500e; color: #ffffff;">
                            <tr>
                                <td colspan="2" class="text-right">Grand Total</td>
                                <td>{{ $grandTotalEmployeeDepartment }}</td>
                                <td>{{ $grandTotalEmployeeResponseDepartment }}</td>
                                <td>{{ $grandTotalEmployeeWithoutResponseDepartment }}</td>
                                <td>{{ number_format($grandTotalEmployeePercentageDepartment, 2) . '%' }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
