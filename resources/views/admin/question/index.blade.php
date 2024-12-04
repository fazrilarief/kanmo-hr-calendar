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
        <div class="card-header" style="background: #e9500e; color: #ffffff;">List Question For Team
            {{ Auth::guard('admin')->user()->department }}</div>
        <div class="card-body">
            <x-alert />
            <div class="table-responsive">
                <a href="{{ route('admin.question.add') }}" class="btn btn-default btn-sm mb-3"
                    style="background: #e9500e; color: #ffffff;"><i class="fas fa-plus"></i> Add Question</a>
                <div class="table-container" style="overflow: hidden; max-height: 500px; overflow-y: scroll;">
                    <table class="table table-bordered" id="dataTable">
                        <thead style="background: #e9500e; color: #ffffff;">
                            <tr>
                                <th>No</th>
                                <th>Department</th>
                                <th>Category</th>
                                <th>Question</th>
                                <th>Answer</th>
                                <th>Time Created</th>
                                <th>Time Updated</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($question as $item)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $item->department }}</td>
                                    <td>{{ $item->category }}</td>
                                    <td>{!! $item->question !!}</td>
                                    <td>{!! $item->answer !!}</td>
                                    <td>{{ $item->created_at->format('d M Y, H:i:sa') }}</td>
                                    <td>{{ $item->updated_at->format('d M Y, H:i:sa') }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('admin.question.show', encrypt($item->id)) }}"
                                                class="btn btn-warning btn-sm mr-2">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            <form action="{{ route('admin.question.destroy', encrypt($item->id)) }}"
                                                method="post"
                                                onsubmit="return confirm('Are you sure delete question {{ $item->question }}?')">
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
