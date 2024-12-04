<x-app-layout title="Activity Calendar">
    <div class="card my-4">
        <div class="card-header" style="background: #e9500e; color: #ffffff;">
            Activity Calendar
        </div>
        <div class="card-body">
            @php
                $months = [
                    'January',
                    'February',
                    'March',
                    'April',
                    'May',
                    'June',
                    'July',
                    'August',
                    'September',
                    'October',
                    'November',
                    'December',
                ];
            @endphp

            <style>
                .calendar-table {
                    width: 100%;
                    border-collapse: collapse;
                }

                .calendar-table th,
                .calendar-table td {
                    border: 1px solid #ddd;
                    padding: 8px;
                    text-align: center;
                }

                .calendar-table th {
                    background-color: #f4f4f4;
                }

                .highlight {
                    background-color: #e9500e;
                    color: #fff;
                }

                .tooltipz {
                    position: relative;
                    display: inline-block;
                    cursor: pointer;
                }

                .tooltipz .tooltiptext {
                    visibility: hidden;
                    background-color: whitesmoke;
                    color: #858796;
                    text-align: left;
                    border-radius: 6px;
                    padding: 20px;
                    position: absolute;
                    z-index: 1;
                    top: 50%;
                    transform: translateY(-50%);
                    left: 105%;
                    width: auto;
                    white-space: nowrap;
                }

                .tooltipz:hover .tooltiptext {
                    visibility: visible;
                }

                .tooltipz ul {
                    margin-left: 20px;
                    padding: 0;
                }

                .tooltipz li {
                    margin: 0;
                    padding: 0;
                }
            </style>

            <table class="calendar-table">
                <a href="{{ route('admin.hr.calendar.add.list') }}">Add New</a>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Key Activities</th>
                        <th>PIC</th>
                        @foreach ($months as $month)
                            <th>{{ $month }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($activities as $index => $activity)
                        <tr>
                            <td rowspan="2">{{ $index + 1 }}</td>
                            <td>
                                <a href="{{ route('admin.hr.calendar.edit.list', $activity->id) }}">
                                    <div class="tooltipz">
                                        <b>{{ $activity->name }}</b>
                                        <span class="tooltiptext">
                                            <h6>Information</h6>
                                            <ul>
                                                @foreach ($activity->subActivities as $subActivity)
                                                    @if ($subActivity->remarks)
                                                        <li>{{ $subActivity->remarks }}</li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </span>
                                    </div>
                                </a>
                            </td>
                            <td rowspan="2">{{ $activity->pic }}</td>
                            @foreach ($months as $monthIndex => $month)
                                @php
                                    $currentMonth = Carbon\Carbon::createFromDate(
                                        null,
                                        $monthIndex + 1,
                                        1,
                                    )->startOfMonth();
                                    $startDate = Carbon\Carbon::parse($activity->start_date);
                                    $endDate = Carbon\Carbon::parse($activity->end_date);

                                    $isStartMonth = $startDate->format('F') === $month;
                                    $isEndMonth = $endDate->format('F') === $month;
                                    $isHighlighted =
                                        $startDate->format('Y-m') === $currentMonth->format('Y-m') ||
                                        $endDate->format('Y-m') === $currentMonth->format('Y-m') ||
                                        ($startDate->startOfMonth()->lte($currentMonth) &&
                                            $endDate->endOfMonth()->gte($currentMonth));
                                    $displayStartDate = $isStartMonth ? $startDate->format('d') : '';
                                    $displayEndDate = $isEndMonth ? $endDate->format('d') : '';
                                @endphp
                                <td class="{{ $isHighlighted ? 'highlight' : '' }}" rowspan="2">
                                    {{ $displayStartDate }}{{ $displayStartDate && $displayEndDate ? '-' : '' }}{{ $displayEndDate }}
                                </td>
                            @endforeach
                        </tr>
                        <tr>
                            <td>
                                @foreach ($activity->subActivities as $subActivity)
                                    @if ($subActivity->sub_name)
                                        - {{ $subActivity->sub_name }} <br>
                                    @endif
                                @endforeach
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
