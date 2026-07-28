<?php

namespace app\Imports;

use App\Models\Question;
use App\Models\Option;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use DB;

class QuestionsImport implements ToCollection, WithHeadingRow
{
    protected $subjectId;
    protected $user;

    public function __construct($subjectId, $user)
    {
        $this->subjectId = $subjectId;
        $this->user = $user;
    }

    public function collection(Collection $rows)
    {
        DB::transaction(function () use ($rows) {
            foreach ($rows as $row) {
                // ایجاد سوال
                $question = Question::create([
                    'subject_id' => $this->subjectId,
                    'question_text' => $row['matn_soal'], // عنوان ستون در اکسل
                    'score' => $row['nomreh'] ?? 3,
                    'difficulty' => $this->mapDifficulty($row['sokhti']),
                    'created_by_type' => get_class($this->user),
                    'created_by_id' => $this->user->id,
                ]);

                // ایجاد گزینه‌ها
                // فرض می‌کنیم در اکسل ۴ ستون برای گزینه‌ها داریم و یک ستون برای شماره گزینه صحیح
                $options = [
                    1 => $row['gozineh_1'],
                    2 => $row['gozineh_2'],
                    3 => $row['gozineh_3'],
                    4 => $row['gozineh_4'],
                ];

                $correctIndex = (int) $row['gozineh_saheh'];

                foreach ($options as $index => $text) {
                    if (!empty($text)) {
                        $question->options()->create([
                            'option_text' => $text,
                            'is_correct' => $index === $correctIndex,
                        ]);
                    }
                }
            }
        });
    }

    private function mapDifficulty($value)
    {
        $map = [
            'آسان' => 'easy',
            'متوسط' => 'medium',
            'سخت' => 'hard',
        ];
        return $map[$value] ?? 'medium';
    }
}
