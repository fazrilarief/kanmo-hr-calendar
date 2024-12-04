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
        <div class="card-header" style="background: #e9500e; color: #ffffff;">List All Employee</div>
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
                                <th>Source</th>
                                <th>Time Created</th>
                                <th>Time Updated</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($employee as $item)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $item->nip }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->division }}</td>
                                    <td>{{ $item->department }}</td>
                                    <td>{{ $item->source }}</td>
                                    <td>{{ $item->created_at->format('d M Y, H:i:sa') }}</td>
                                    <td>{{ $item->updated_at->format('d M Y, H:i:sa') }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('admin.employee.show', encrypt($item->id)) }}"
                                                class="btn btn-warning btn-sm mr-2">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            <form action="{{ route('admin.employee.destroy', encrypt($item->id)) }}"
                                                method="post"
                                                onsubmit="return confirm('Are you sure delete employee {{ $item->name }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
