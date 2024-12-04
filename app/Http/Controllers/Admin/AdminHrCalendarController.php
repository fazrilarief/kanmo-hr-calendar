<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DateRange;
use App\Models\Employee;
use App\Models\KeyActivity;
use App\Models\SubKeyActivity;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminHrCalendarController extends Controller
{
    public function index_list()
    {
        $startYear = 2024; // Nilai default
        $endYear = 2025;   // Nilai default

        $activities = KeyActivity::with(['subActivities', 'dateRanges'])->get();

        return view('admin.calendar.list.index', compact('activities', 'startYear', 'endYear'));
    }

    public function filter(Request $request)
    {
        // Ambil tahun dari request atau gunakan default
        $startYear = $request->input('startYear', 2024);
        $endYear = $request->input('endYear', 2025);

        // Filter data berdasarkan tahun
        $activities = KeyActivity::with(['subActivities', 'dateRanges' => function ($query) use ($startYear, $endYear) {
            $query->whereYear('start_date', '>=', $startYear)
                ->whereYear('end_date', '<=', $endYear);
        }])->get();

        // Buat array bulan untuk header tabel
        $months = [];
        for ($year = $startYear; $year <= $endYear; $year++) {
            foreach (range(1, 12) as $monthNumber) {
                $months[] = Carbon::createFromDate($year, $monthNumber, 1)->format('F Y');
            }
        }

        // Kirim data ke view
        return view('admin.calendar.list.index', compact('months', 'activities', 'startYear', 'endYear'));
    }


    public function add_list()
    {
        return view('admin.calendar.list.add');
    }

    public function store_list(Request $request)
    {
        $activityData = $request->only(['name', 'pic']);

        $activityData['name'] = strtoupper($activityData['name']);
        $activityData['pic'] = strtoupper($activityData['pic']);

        $activity = KeyActivity::create($activityData);

        if ($activity) {
            $subNames = $request->input('sub_name');
            $remarks = $request->input('remarks');

            SubKeyActivity::create([
                'key_activity_id' => $activity->id,
                'sub_name' => strtoupper($subNames),
                'remarks' => strtoupper($remarks),
            ]);
        }

        if ($activity) {
            $startDates = $request->input('start_dates', []);
            $endDates = $request->input('end_dates', []);

            foreach ($startDates as $index => $startDate) {
                $endDate = $endDates[$index] ?? null;
                DateRange::create([
                    'key_activity_id' => $activity->id,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                ]);
            }
        }

        return redirect()->route('admin.hr.calendar.index.list')->with('success', 'Successfully added data');
    }

    public function edit_list($id)
    {
        $activity = KeyActivity::with(['subActivities', 'dateRanges'])->findOrFail($id);

        return view('admin.calendar.list.edit', compact('activity'));
    }

    public function update_list(Request $request, $id)
    {
        $activity = KeyActivity::findOrFail($id);
        $activityData = $request->only(['name', 'pic']);

        $activityData['name'] = strtoupper($activityData['name']);
        $activityData['pic'] = strtoupper($activityData['pic']);

        $activity->update($activityData);

        $activity->subActivities()->delete();
        $activity->dateRanges()->delete();

        $subNames = $request->input('sub_name');
        $remarks = $request->input('remarks');

        $startDates = $request->input('start_dates', []);
        $endDates = $request->input('end_dates', []);
        SubKeyActivity::create([
            'key_activity_id' => $activity->id,
            'sub_name' => strtoupper($subNames),
            'remarks' => strtoupper($remarks),
        ]);

        foreach ($startDates as $index => $startDate) {
            $endDate = $endDates[$index] ?? null;
            DateRange::create([
                'key_activity_id' => $activity->id,
                'start_date' => $startDate,
                'end_date' => $endDate,
            ]);
        }

        return redirect()->route('admin.hr.calendar.index.list')->with('success', 'Activity updated successfully');
    }

    public function delete_list_sub($id)
    {
        $sub_activity = SubKeyActivity::findOrFail($id);
        $sub_activity->delete();

        return back()->with('success', 'Successfully deleted sub activity data');
    }

    public function delete_list($id)
    {
        $activity = KeyActivity::findOrFail($id);
        $activity->subActivities()->delete();
        $activity->dateRanges()->delete();
        $activity->delete();

        return back()->with('success', 'Successfully deleted activity data');
    }

    public function index_view()
    {
        $calendar = Employee::latest()->get();

        return view('admin.calendar.data.index', compact('calendar'));
    }
}
