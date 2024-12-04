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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.26.3/dist/apexcharts.min.css">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.26.3/dist/apexcharts.min.js"></script>

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
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                                $grandTotalEmployeeResponseSource = 0;
                            @endphp
                            @foreach ($sources as $source)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td><a
                                            href="{{ route('admin.summary.response_employee.source', $source->source) }}">{{ $source->source }}</a>
                                    </td>
                                    <td>{{ $source->TotalEmployeeResponseSource }}</td>
                                </tr>
                                @php
                                    $grandTotalEmployeeResponseSource += $source->TotalEmployeeResponseSource;
                                @endphp
                            @endforeach
                        </tbody>
                        <tfoot style="background: #e9500e; color: #ffffff;">
                            <tr>
                                <td colspan="2" class="text-right">Grand Total</td>
                                <td>{{ $grandTotalEmployeeResponseSource }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
