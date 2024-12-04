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
            List Sources "{{ $sources }}"
        </div>
        <div class="card-body">
            <x-alert />
            <div class="table-responsive">
                <div class="table-container" style="overflow: hidden; max-height: 500px; overflow-y: scroll;">
                    <table class="table table-bordered" id="dataTable">
                        <thead style="background: #e9500e; color: #ffffff;">
                            <tr>
                                <th>No</th>
                                <th>Divisions</th>
                                <th>Total Employee Division</th>
                                <th>Total Employee Response Division</th>
                                <th>Total Division Percentage</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                                $grandTotalEmployeeDivision = 0;
                                $grandTotalEmployeeResponseDivision = 0;
                                $grandTotalEmployeePercentageDivision = 0;
                            @endphp
                            @foreach ($divisions as $division)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>
                                        <a
                                            href="{{ route('admin.summary.employee.division', ['source' => $division->source, 'division' => $division->division]) }}">
                                            {{ $division->division }}
                                        </a>
                                    </td>
                                    <td>{{ $division->TotalEmployeeDivision }}</td>
                                    <td>{{ $division->TotalEmployeeResponseDivision }}</td>
                                    <td>
                                        {{ $division->TotalEmployeeResponseDivision != 0 ? number_format(($division->TotalEmployeeResponseDivision / $division->TotalEmployeeDivision) * 100, 2) . '%' : '0%' }}
                                    </td>
                                </tr>
                                @php
                                    $grandTotalEmployeeDivision += $division->TotalEmployeeDivision;
                                    $grandTotalEmployeeResponseDivision += $division->TotalEmployeeResponseDivision;
                                    $grandTotalEmployeePercentageDivision = ($grandTotalEmployeeResponseDivision / $grandTotalEmployeeDivision) * 100;
                                @endphp
                            @endforeach
                        </tbody>
                        <tfoot style="background: #e9500e; color: #ffffff;">
                            <tr>
                                <td colspan="2" class="text-right">Grand Total</td>
                                <td>{{ $grandTotalEmployeeDivision }}</td>
                                <td>{{ $grandTotalEmployeeResponseDivision }}</td>
                                <td>{{ number_format($grandTotalEmployeePercentageDivision, 2) . '%' }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
