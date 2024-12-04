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
            List Source For Team {{ Auth::guard('admin')->user()->department }}
        </div>
        <div class="card-body">
            <x-alert />
            <div class="table-responsive">
                <div class="table-container" style="overflow: hidden; max-height: 500px; overflow-y: scroll;">
                    <table class="table table-bordered" id="dataTable">
                        <thead style="background: #e9500e; color: #ffffff;">
                            <tr>
                                <th>No</th>
                                <th>Source</th>
                                <th>Total Employee Source</th>
                                <th>Total Employee Response Source</th>
                                <th>Total Source Percentage</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                                $grandTotalEmployeeSource = 0;
                                $grandTotalEmployeeResponseSource = 0;
                                $grandTotalEmployeePercentageSource = 0;
                            @endphp
                            @foreach ($sources as $source)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td><a
                                            href="{{ route('admin.summary.employee.source', $source->source) }}">{{ $source->source }}</a>
                                    </td>
                                    <td>{{ $source->TotalEmployeeSource }}</td>
                                    <td>{{ $source->TotalEmployeeResponseSource }}</td>
                                    <td>
                                        {{ $source->TotalEmployeeResponseSource != 0 ? number_format(($source->TotalEmployeeResponseSource / $source->TotalEmployeeSource) * 100, 2) . '%' : '0%' }}
                                    </td>
                                </tr>
                                @php
                                    $grandTotalEmployeeSource += $source->TotalEmployeeSource;
                                    $grandTotalEmployeeResponseSource += $source->TotalEmployeeResponseSource;
                                    $grandTotalEmployeePercentageSource = ($grandTotalEmployeeResponseSource / $grandTotalEmployeeSource) * 100;
                                @endphp
                            @endforeach
                        </tbody>
                        <tfoot style="background: #e9500e; color: #ffffff;">
                            <tr>
                                <td colspan="2" class="text-right">Grand Total</td>
                                <td>{{ $grandTotalEmployeeSource }}</td>
                                <td>{{ $grandTotalEmployeeResponseSource }}</td>
                                <td>{{ number_format($grandTotalEmployeePercentageSource, 2) . '%' }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
