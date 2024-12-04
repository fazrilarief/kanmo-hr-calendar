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
            List Employee Response For Team {{ Auth::guard('admin')->user()->department }}
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
                                <th>Employee Name</th>
                                <th>Employee Department</th>
                                <th>Question Department</th>
                                <th>Category</th>
                                <th>Question</th>
                                <th>Answer</th>
                                <th>Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($employeeResponses as $item)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $item->nip }}</td>
                                    <td>{{ $item->employee_name }}</td>
                                    <td>{{ $item->employee_department }}</td>
                                    <td>{{ $item->department }}</td>
                                    <td>{{ $item->category }}</td>
                                    <td>{{ $item->question }}</td>
                                    <td>{!! $item->answer !!}</td>
                                    <td>{{ $item->created_at->format('d M Y, H:i:sa') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
