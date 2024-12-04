<x-app-layout title="Dashboard Admin">
    <div class="card">
        <div class="card-header" style="background: #e9500e; color: #ffffff;">Edit Employee For Team
            {{ Auth::guard('admin')->user()->department }}</div>
        <div class="card-body">
            @if ($errors->any())
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <form action="{{ route('admin.employee.update', encrypt($employee->id)) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" id="name"
                                value="{{ old('name') ?? $employee->name }}" placeholder="Input name" required
                                class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="nip" class="form-label">Nip</label>
                            <input type="text" name="nip" id="nip"
                                value="{{ old('nip') ?? $employee->nip }}" placeholder="Input nip" required
                                class="form-control">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-sm">Update Employee</button>
                            <a href="{{ route('admin.employee.index') }}" class="btn btn-warning btn-sm">Back to
                                List</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
