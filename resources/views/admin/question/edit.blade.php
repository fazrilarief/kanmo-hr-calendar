<x-app-layout title="Dashboard Admin">
    <div class="card">
        <div class="card-header" style="background: #e9500e; color: #ffffff;">Edit List Question For Team
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
                    <form action="{{ route('admin.question.update', encrypt($question->id)) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="department" class="form-label">Department</label>
                            <select name="department" id="department" class="form-control">
                                <option value="">Select department</option>
                                @foreach ($dept as $item)
                                    <option value="{{ $item->department }}"
                                        {{ $question->department == $item->department ? 'selected' : '' }}>
                                        {{ $item->department }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="category" class="form-label">Category</label>
                            <input type="text" name="category" id="category"
                                value="{{ old('category') ?? $question->category }}" placeholder="Input your category"
                                required class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="question" class="form-label">Question</label>
                            <input type="text" name="question" id="question"
                                value="{{ old('question') ?? $question->question }}" placeholder="Input your question"
                                required class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="answer" class="form-label">Answer</label>
                            <textarea id="answer" name="answer">{{ old('answer') ?? $question->answer }}</textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-sm">Update Question</button>
                            <a href="{{ route('admin.question.index') }}" class="btn btn-warning btn-sm">Back to
                                List</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>