<?php

namespace App\Services;

use App\Models\Exam;
use Illuminate\Support\Facades\DB;
use Morilog\Jalali\Jalalian;

class ExamService
{
    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            $subjects = $data['subjects'] ?? [];
            $questions = $data['questions'] ?? [];
            $allowedStudents = $data['students'] ?? [];

            $data['start_date'] = Jalalian::fromFormat('Y/m/d', $data['start_date'])->toCarbon()->toDateString();
            $data['end_date'] = Jalalian::fromFormat('Y/m/d', $data['end_date'])->toCarbon()->toDateString();

            $data['is_public'] = ($data['is_public'] ?? 'public') === 'public';

            unset(
                $data['subjects'],
                $data['questions'],
                $data['students'],
                $data['is_public']
            );

            $exam = Exam::create($data);
            $exam->createdBy()->associate(auth()->user());
            $exam->save();

            if (!empty($subjects)) {
                foreach ($subjects as $subjectId => $subject) {
                    $exam->subjects()->attach($subjectId, [
                        'question_count' => $subject['question_count'] ?? null,
                        'negative_score' => $subject['negative_score'] ?? null,
                        'order' => $subject['order'] ?? null,
                    ]);
                }
            }

            if (!empty($questions)) {
                foreach ($questions as $index => $questionId) {
                    $exam->questions()->attach($questionId, [
                        'order' => $index + 1,
                    ]);
                }
            }

            // اگر برای allowed_students جدول واسط داری اینجا sync کن
            $exam->students()->sync($allowedStudents);

            return $exam;
        });
    }



    public function update(Exam $exam, array $data)
    {
        return DB::transaction(function () use ($exam, $data) {

            $subjects = $data['subjects'] ?? [];
            $questions = $data['questions'] ?? [];

            unset($data['subjects'], $data['questions']);

            $exam->update($data);

            if (!empty($subjects)) {

                $syncData = [];

                foreach ($subjects as $subject) {

                    $syncData[$subject['id']] = [
                        'question_count' => $subject['question_count'] ?? null,
                        'negative_score' => $subject['negative_score'] ?? null,
                        'order' => $subject['order'] ?? null,
                    ];
                }

                $exam->subjects()->sync($syncData);
            }

            if (!empty($questions)) {

                $syncQuestions = [];

                foreach ($questions as $index => $questionId) {

                    $syncQuestions[$questionId] = [
                        'order' => $index + 1
                    ];
                }

                $exam->questions()->sync($syncQuestions);
            }

            return $exam;
        });
    }

    public function delete(Exam $exam)
    {
        return DB::transaction(function () use ($exam) {

            $exam->subjects()->detach();
            $exam->questions()->detach();

            $exam->delete();

            return true;
        });
    }
}
