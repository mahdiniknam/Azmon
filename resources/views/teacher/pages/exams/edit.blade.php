@extends('teacher.layout.master')
@section('teacher-title', 'ویرایش آزمون')
@section('teacher-content')
<main class="flex-1 overflow-y-auto p-6 bg-gray-50 dark:bg-gray-900">
    <div class="bg-white rounded-xl shadow-md p-6 border border-gray-200">
        <h2 class="text-xl font-bold mb-6">ویرایش آزمون</h2>
        <form action="{{ route('teacher.exams.update', $exam->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">عنوان آزمون</label>
                    <input type="text" name="title" value="{{ $exam->title }}" class="w-full rounded-lg border-gray-300" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">نوع آزمون</label>
                    <select name="type" class="w-full rounded-lg border-gray-300">
                        <option value="test" {{ $exam->type == 'test' ? 'selected' : '' }}>تستی</option>
                        <option value="descriptive" {{ $exam->type == 'descriptive' ? 'selected' : '' }}>تشریحی</option>
                        <option value="mixed" {{ $exam->type == 'mixed' ? 'selected' : '' }}>ترکیبی</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">مدت زمان (دقیقه)</label>
                    <input type="number" name="duration" value="{{ $exam->duration }}" class="w-full rounded-lg border-gray-300" required>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">تاریخ شروع</label>
                    <input data-jdp type="text" name="start_date" value="{{ $exam->start_date }}" class="w-full rounded-lg border-gray-300" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">تاریخ پایان</label>
                    <input data-jdp type="text" name="end_date" value="{{ $exam->end_date }}" class="w-full rounded-lg border-gray-300" required>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">نمره منفی</label>
                    <select name="negative_score" class="w-full rounded-lg border-gray-300">
                        <option value="0" {{ $exam->negative_score == 0 ? 'selected' : '' }}>ندارد</option>
                        <option value="1" {{ $exam->negative_score == 1 ? 'selected' : '' }}>دارد</option>
                    </select>
                </div>

                <div class="md:col-span-3">
                    <label class="block text-sm font-medium text-gray-700 mb-2">دروس</label>
                    <select name="subjects[]" class="select2 w-full rounded-lg border-gray-300" multiple>
                        @php $examSubjects = $exam->subjects->pluck('id')->toArray(); @endphp
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ in_array($subject->id, $examSubjects) ? 'selected' : '' }}>{{ $subject->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-3">
                    <label class="block text-sm font-medium text-gray-700 mb-2">سوالات</label>
                    <select name="questions[]" class="select2 w-full rounded-lg border-gray-300" multiple>
                        @php $examQs = $exam->questions->pluck('id')->toArray(); @endphp
                        @foreach($questions as $question)
                            <option value="{{ $question->id }}" {{ in_array($question->id, $examQs) ? 'selected' : '' }}>{{ $question->question_text }}</option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Financials -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">آیا آزمون پولی است؟</label>
                    <select name="is_paid" id="is_paid" class="w-full rounded-lg border-gray-300">
                        <option value="0" {{ $exam->is_paid == 0 ? 'selected' : '' }}>خیر</option>
                        <option value="1" {{ $exam->is_paid == 1 ? 'selected' : '' }}>بله</option>
                    </select>
                </div>
                <div class="financial-section {{ $exam->is_paid ? '' : 'hidden' }}">
                    <label class="block text-sm font-medium text-gray-700 mb-2">قیمت (تومان)</label>
                    <input type="number" name="price" value="{{ $exam->price }}" class="w-full rounded-lg border-gray-300">
                </div>
                <div class="financial-section {{ $exam->is_paid ? '' : 'hidden' }}">
                    <label class="block text-sm font-medium text-gray-700 mb-2">نوع پرداخت</label>
                    <select name="payment_type" class="w-full rounded-lg border-gray-300">
                        <option value="online" {{ $exam->payment_type == 'online' ? 'selected' : '' }}>آنلاین</option>
                        <option value="offline" {{ $exam->payment_type == 'offline' ? 'selected' : '' }}>آفلاین</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">حداکثر شرکت کنندگان</label>
                    <input type="number" name="max_participants" value="{{ $exam->max_participants }}" class="w-full rounded-lg border-gray-300">
                </div>
            </div>
            
            <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">بروزرسانی آزمون</button>
        </form>
    </div>
</main>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('.select2').select2({ dir: "rtl" });
        jalaliDatepicker.startWatch();
        
        $('#is_paid').change(function() {
            if($(this).val() == '1') {
                $('.financial-section').removeClass('hidden');
            } else {
                $('.financial-section').addClass('hidden');
            }
        });
    });
</script>
@endsection
