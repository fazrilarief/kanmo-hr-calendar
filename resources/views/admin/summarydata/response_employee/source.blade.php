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
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                                $grandTotalEmployeeResponseDivision = 0;
                            @endphp
                            @foreach ($divisions as $division)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>
                                        <a
                                            href="{{ route('admin.summary.response_employee.division', ['source' => $division->source, 'division' => $division->division]) }}">
                                            {{ $division->division }}
                                        </a>
                                    </td>
                                    <td>{{ $division->TotalEmployeeResponseDivision }}</td>
                                </tr>
                                @php
                                    $grandTotalEmployeeResponseDivision += $division->TotalEmployeeResponseDivision;
                                    100;
                                @endphp
                            @endforeach
                        </tbody>
                        <tfoot style="background: #e9500e; color: #ffffff;">
                            <tr>
                                <td colspan="2" class="text-right">Grand Total</td>
                                <td>{{ $grandTotalEmployeeResponseDivision }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
