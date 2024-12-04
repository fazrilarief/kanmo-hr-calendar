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
            List Summary Feedback For Team {{ Auth::guard('admin')->user()->department }}
        </div>
        <div class="card-body">
            <x-alert />
            <div class="table-responsive">
                <div class="table-container" style="overflow: hidden; max-height: 500px; overflow-y: scroll;">
                    <table class="table table-bordered" id="dataTable">
                        <thead style="background: #e9500e; color: #ffffff;">
                            <tr>
                                <th>No</th>
                                <th>Rating</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                                $ratingDescriptions = [
                                    3 => 'Very Excited',
                                    2 => 'Neutral',
                                    1 => 'Happy',
                                ];
                                $grandTotal = 0;
                            @endphp
                            @foreach ($employeeFeedbacks as $item)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>
                                        @if ($item->rating == 3)
                                            <a
                                                href="{{ route('admin.summary.feedback.rating', ['rating' => $item->rating]) }}">3
                                                (Very Excited)
                                            </a>
                                        @elseif ($item->rating == 2)
                                            <a
                                                href="{{ route('admin.summary.feedback.rating', ['rating' => $item->rating]) }}">2
                                                (Neutral)</a>
                                        @elseif ($item->rating == 1)
                                            <a
                                                href="{{ route('admin.summary.feedback.rating', ['rating' => $item->rating]) }}">1
                                                (Happy)</a>
                                        @endif
                                    </td>
                                    <td>{{ $item->total }}</td>
                                </tr>
                                @php
                                    $grandTotal += $item->total;
                                @endphp
                            @endforeach
                        </tbody>
                        <tfoot style="background: #e9500e; color: #ffffff;">
                            <tr>
                                <td colspan="2" class="text-right">Grand Total</td>
                                <td>{{ $grandTotal }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
