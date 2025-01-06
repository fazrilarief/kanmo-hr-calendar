<x-app-layout title="Activity Calendar">
    <style>
        .highlight {
            background-color: #7FFFD4;
            color: #000;
            font-weight: bold;
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

        .custom-thin-border table {
            border-collapse: collapse;
        }

        .custom-thin-border th,
        .custom-thin-border td {
            border: 0.5px solid black !important;
        }

        .custom-thin-border {
            overflow-x: auto;
            max-height: 1000px;
            /* Ubah sesuai kebutuhan */
        }

        thead {
            position: sticky;
            top: 0;
            z-index: 1050;
            background-color: #e9500e;
            color: #ffffff;
        }
    </style>
    <div class="card my-4">
        <div class="card-header" style="background: #e9500e; color: #ffffff;">
            Activity Calendar2
        </div>
        <div class="card-body">
            @php
                $months = [];
                for ($year = $startYear; $year <= $endYear; $year++) {
                    foreach (range(1, 12) as $monthNumber) {
                        if ($year == $startYear && $monthNumber < 12) {
                            continue;
                        }
                        $months[] = Carbon\Carbon::createFromDate($year, $monthNumber, 1)->format('F Y');
                    }
                }
            @endphp

            <x-alert />
            <div class="d-flex flex-column justify-content-between align-items-start mb-3" style="gap: 10px;">
                <div class="d-flex align-items-center" style="gap: 10px">
                    <a href="{{ route('admin.hr.calendar.add.list') }}" class="btn btn-default"
                        style="background: #e9500e; color: #ffffff;">Add New</a>
                    <button id="unhideMonths" class="btn btn-default" style="background: #e9500e; color: #ffffff;">
                        Unhide Months
                    </button>
                    <select id="statusFilter" class="form-control" style="width: 200px;">
                        <option value="">All</option>
                        <option value="Ongoing">Ongoing</option>
                        <option value="Done">Done</option>
                    </select>
                </div>

                <form action="{{ route('admin.hr.calendar.filter') }}" method="POST" class="d-flex">
                    @csrf
                    <div class="mr-2">
                        <select name="startYear" id="startYear" class="form-control">
                            <option value="2023" {{ $startYear == 2023 ? 'selected' : '' }}>2023</option>
                            <option value="2024" {{ $startYear == 2024 ? 'selected' : '' }}>2024</option>
                            <option value="2025" {{ $startYear == 2025 ? 'selected' : '' }}>2025</option>
                        </select>
                    </div>
                    <div class="mr-2">
                        <select name="endYear" id="endYear" class="form-control">
                            <option value="2023" {{ $endYear == 2023 ? 'selected' : '' }}>2023</option>
                            <option value="2024" {{ $endYear == 2024 ? 'selected' : '' }}>2024</option>
                            <option value="2025" {{ $endYear == 2025 ? 'selected' : '' }}>2025</option>
                        </select>
                    </div>
                    <button class="btn btn-default" style="background: #e9500e; color: #ffffff;">
                        Filter
                    </button>
                </form>

            </div>
            <div class="custom-thin-border table-responsive">
                <table class="table table-bordered" id="dataTable">
                    <thead style="background: #e9500e; color: #ffffff;">
                        <tr>
                            <th>No</th>
                            <th style="width: 5px;">Action</th>
                            <th style="width: 400px;">Key Activities</th>
                            <th style="width: 200px;">Sub Key Activities</th>
                            <th>PIC</th>
                            @foreach ($months as $month)
                                <th class="text-center">{{ $month }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($activities as $index => $activity)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <form action="{{ route('admin.hr.calendar.delete.list', $activity->id) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-default btn-sm btn-outline"
                                            style="background: #e9500e; color: #ffffff;"
                                            onclick="return confirm('Are you sure delete data, {{ $activity->name }}?')"><i
                                                class="fas fa-trash"></i></button>
                                    </form>
                                </td>
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
                                <td>{{ $subActivity->sub_name ?? '' }}</td>
                                <td>{{ $activity->pic }}</td>
                                @foreach ($months as $month)
                                    @php
                                        $currentMonth = Carbon\Carbon::createFromFormat('F Y', $month)->startOfMonth();
                                        $isHighlighted = false;
                                        $statusText = '';
                                        $displayDate = '';

                                        foreach ($activity->dateRanges as $dateRange) {
                                            $startDate = Carbon\Carbon::parse($dateRange->start_date);
                                            $endDate = Carbon\Carbon::parse($dateRange->end_date);

                                            // Jika bulan termasuk dalam rentang tanggal
                                            if (
                                                $startDate->lte($currentMonth->endOfMonth()) &&
                                                $endDate->gte($currentMonth->startOfMonth())
                                            ) {
                                                $isHighlighted = true;

                                                if ($currentMonth->isCurrentMonth() || $currentMonth->isFuture()) {
                                                    $statusText = 'Ongoing';
                                                } elseif ($currentMonth->isPast()) {
                                                    $statusText = 'Done';
                                                }

                                                // Tampilkan hanya tanggal pada bulan tersebut
                                                if ($startDate->format('F Y') === $month) {
                                                    $displayDate = $startDate->format('d');
                                                } elseif ($endDate->format('F Y') === $month) {
                                                    $displayDate = $endDate->format('d');
                                                }
                                            }
                                        }
                                    @endphp
                                    <td class="{{ $isHighlighted ? 'highlight' : '' }} text-center"
                                        data-status="{{ $statusText }}">
                                        {!! $displayDate !!} <br> {{ $statusText }}
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var currentMonthIndex = (new Date()).getMonth() + 1;
            var isHidden = false; // Default ke unhide
            var cells = document.querySelectorAll('td[data-status]');
            var headers = document.querySelectorAll('th.text-center');
            var unhideButton = document.getElementById('unhideMonths');
            var filterDropdown = document.getElementById('statusFilter');
            var startYearSelect = document.getElementById('startYear'); // Referensi dropdown startYear
            var endYearSelect = document.getElementById('endYear'); // Referensi dropdown endYear

            // Fungsi untuk menyembunyikan bulan
            function hideMonths() {
                cells.forEach(function(cell, index) {
                    if (index % 13 < currentMonthIndex) {
                        cell.style.display = 'none';
                    }
                });
                headers.forEach(function(header, index) {
                    if (index % 13 < currentMonthIndex) {
                        header.style.display = 'none';
                    }
                });
                isHidden = true;
            }

            // Fungsi untuk menampilkan bulan
            function unhideMonths() {
                cells.forEach(function(cell) {
                    cell.style.display = '';
                });
                headers.forEach(function(header) {
                    header.style.display = '';
                });
                isHidden = false;
            }

            // Fungsi untuk memfilter status
            function filterStatus() {
                var selectedStatus = filterDropdown.value;
                cells.forEach(function(cell) {
                    if (selectedStatus === '' || cell.getAttribute('data-status') === selectedStatus) {
                        cell.style.display = '';
                    } else {
                        cell.style.display = 'none';
                    }
                });
            }

            // Fungsi untuk memperbarui opsi endYear
            function updateEndYearOptions() {
                const startYear = parseInt(startYearSelect.value, 10);

                // Reset endYear options
                Array.from(endYearSelect.options).forEach(option => {
                    option.disabled = parseInt(option.value, 10) < startYear;
                });

                // Pastikan nilai yang dipilih valid
                if (parseInt(endYearSelect.value, 10) < startYear) {
                    endYearSelect.value = startYear;
                }
            }

            // Default behavior: Unhide months
            unhideMonths(); // Semua bulan ditampilkan secara default
            unhideButton.textContent = 'Hide Months'; // Ubah teks tombol ke 'Hide Months'

            unhideButton.addEventListener('click', function() {
                if (isHidden) {
                    unhideMonths();
                    this.textContent = 'Hide Months';
                } else {
                    hideMonths();
                    this.textContent = 'Unhide Months';
                }
            });

            filterDropdown.addEventListener('change', filterStatus);

            // Update opsi endYear saat startYear berubah
            startYearSelect.addEventListener('change', updateEndYearOptions);

            // Update opsi endYear saat halaman dimuat
            updateEndYearOptions();
        });
    </script>

</x-app-layout>
