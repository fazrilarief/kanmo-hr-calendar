<x-app-layout title="Edit Activity">
    <div class="card my-4">
        <div class="card-header" style="background: #e9500e; color: #ffffff;">
            Edit Activity Calendar
        </div>
        <div class="card-body">
            <form action="{{ route('admin.hr.calendar.update.list', $activity->id) }}" method="POST"
                class="container mt-4">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Activity Name:</label>
                    <input type="text" class="form-control text-uppercase" name="name" id="name"
                        value="{{ $activity->name }}" required>
                </div>
                <div class="mb-3">
                    <label for="sub_name" class="form-label">Sub Activity Name:</label>
                    <input type="text" class="form-control text-uppercase" name="sub_name"
                                value="{{ $activity->subActivities->first()->sub_name }}" required>
                </div>
                <div class="mb-3">
                    <label for="pic" class="form-label">PIC:</label>
                    <input type="text" class="form-control text-uppercase" name="pic" id="pic"
                        value="{{ $activity->pic }}" required>
                </div>
                <div class="mb-3">
                    <label for="remarks" class="form-label">Remarks:</label>
                    <input type="text" class="form-control text-uppercase" name="remarks"
                                value="{{ $activity->subActivities->first()->remarks }}">
                </div>
                <h3 class="mt-4">Date Ranges:</h3>
                <div id="dateRanges" class="mb-3">
                    @foreach ($activity->dateRanges as $index => $dateRange)
                        <div class="date-range mb-3">
                            <label for="start_dates[]" class="form-label">Start Date:</label>
                            <input type="date" class="form-control mb-2" name="start_dates[]"
                                value="{{ $dateRange->start_date }}" required>
                            <label for="end_dates[]" class="form-label">End Date:</label>
                            <input type="date" class="form-control mb-2" name="end_dates[]"
                                value="{{ $dateRange->end_date }}" required>
                            <button type="button" class="btn btn-danger remove-date-range"
                                onclick="removeDateRange(this)">Remove</button>
                        </div>
                    @endforeach
                </div>
                <button type="button" class="btn btn-primary mb-3" onclick="addDateRange()">Add Date Range</button>
                <hr>
                <button type="submit" class="btn btn-success">Update</button>
            </form>
        </div>
    </div>
    <script>
        function addDateRange() {
            const container = document.getElementById('dateRanges');
            const newRange = document.createElement('div');
            newRange.classList.add('date-range', 'mb-3');
            newRange.innerHTML = `
                <label for="start_dates[]" class="form-label">Start Date:</label>
                <input type="date" class="form-control mb-2" name="start_dates[]" required>
                <label for="end_dates[]" class="form-label">End Date:</label>
                <input type="date" class="form-control mb-2" name="end_dates[]" required>
                <button type="button" class="btn btn-danger remove-date-range" onclick="removeDateRange(this)">Remove</button>
            `;
            container.appendChild(newRange);
        }

        function removeDateRange(element) {
            element.parentNode.remove();
        }
    </script>
</x-app-layout>
