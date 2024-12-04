<x-app-layout title="Personal Profile Information">
    <div class="col-xl-12 col-lg-12 col-md-12">
        <h1 class="h3 mb-2 text-gray-800">Personal Profile Information</h1>
        <div class="card my-5">
            <div class="card-header" style="background: #e9500e; color: white;">Personal Profile Information</div>
            <div class="card-body">
                <x-alert />
                <div class="row">
                    <div class="col-lg-6">
                        <form action="{{ route('admin.update', ['admin' => Auth::guard('admin')->user()]) }}"
                            method="post">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="dept">Department</label>
                                <input type="text" class="form-control" id="department" readonly name="department"
                                    value="{{ Auth::guard('admin')->user()->department }}">
                            </div>
                            <div class="form-group">
                                <label for="password">Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ Auth::guard('admin')->user()->name }}">
                            </div>
                            <button type="submit" class="btn btn-default btn-user btn-block"
                                style="background: #e9500e; color: white;">
                                Update
                            </button>
                        </form>
                    </div>
                    <div class="col-lg-6">
                        <form action="{{ route('admin.reset.password') }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="password">New Password</label>
                                <input id="password" type="password" class="form-control" name="password">
                                @error('password')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">Confirm Password</label>
                                <input id="password_confirmation" type="password" class="form-control"
                                    name="password_confirmation">
                            </div>
                            <button type="submit" class="btn btn-default btn-user btn-block"
                                style="background: #e9500e; color: white;">
                                Update
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
