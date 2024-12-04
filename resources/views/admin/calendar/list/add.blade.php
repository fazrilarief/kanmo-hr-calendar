<x-app-layout title="Create New Activity">
    <div class="card my-4">
        <div class="card-header" style="background: #e9500e; color: #ffffff;">
            Add Activity Calendar
        </div>
        <div class="card-body">
            <form action="{{ route('admin.hr.calendar.store.list') }}" method="POST" class="container mt-4">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Activity Name:</label>
                    <input type="text" class="form-control text-uppercase" name="name" id="name" required>
                </div>
                <div class="mb-3">
                    <label for="sub_name" class="form-label">Sub Activity Name:</label>
                    <input type="text" class="form-control text-uppercase" name="sub_name" required>
                </div>
                <div class="mb-3">
                    <label for="pic" class="form-label">PIC:</label>
                    <input type="text" class="form-control text-uppercase" name="pic" id="pic" required>
                </div>
                <div class="mb-3">
                    <label for="remarks" class="form-label">Remarks:</label>
                    <input type="text" class="form-control text-uppercase" name="remarks">
                </div>
                <hr>
                <h3 class="mt-4">Date Ranges:</h3>
                <div id="dateRanges" class="mb-3">
                    <div class="date-range mb-3">
                        <label for="start_dates[]" class="form-label">Start Date:</label>
                        <input type="date" class="form-control mb-2" name="start_dates[]" required>
                        <label for="end_dates[]" class="form-label">End Date:</label>
                        <input type="date" class="form-control mb-2" name="end_dates[]" required>
                        <button type="button" class="btn btn-danger remove-date-range" style="display: none;"
                            onclick="removeDateRange(this)">Remove</button>
                    </div>
                </div>
                <button type="button" class="btn btn-primary mb-3" onclick="addDateRange()">Add Date Range</button>
                <hr>
                <button type="submit" class="btn btn-success">Submit</button>
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
            updateRemoveButtons();
        }

        function removeDateRange(button) {
            button.parentNode.remove();
            updateRemoveButtons();
        }

        function updateRemoveButtons() {
            const buttons = document.querySelectorAll('.remove-date-range');
            buttons.forEach((button, index) => {
                if (buttons.length === 1) {
                    button.style.display = 'none';
                } else {
                    button.style.display = 'inline-block';
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            updateRemoveButtons();
        }, false);
    </script>
</x-app-layout>
