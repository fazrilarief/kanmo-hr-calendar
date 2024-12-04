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
            List Department "{{ $departments }}"
        </div>
        <div class="card-body">
            <x-alert />
            <div class="table-responsive">
                <div class="table-container" style="overflow: hidden; max-height: 500px; overflow-y: scroll;">
                    <table class="table table-bordered" id="dataTable">
                        <thead style="background: #e9500e; color: #ffffff;">
                            <tr>
                                <th>No</th>
                                <th>Nip</th>
                                <th>Name</th>
                                <th>Division</th>
                                <th>Department</th>
                                <th>Question</th>
                                <th>Answer</th>
                                <th>Time Created</th>
                                <th>Time Updated</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($employees as $item)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $item->nip }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->division }}</td>
                                    <td>{{ $item->department }}</td>
                                    <td>{{ $item->question }}</td>
                                    <td>{{ $item->answer }}</td>
                                    <td>{{ $item->created_at->format('d M Y, H:i:sa') }}</td>
                                    <td>{{ $item->updated_at->format('d M Y, H:i:sa') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
