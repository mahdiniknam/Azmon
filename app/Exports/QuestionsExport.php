<?php

namespace App\Exports;

use App\Models\Question;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;

class QuestionsExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize
{
    public function query()
    {
        return Question::query()
            ->with(['subject', 'options'])
            ->orderBy('id');
    }

    public function map($question): array
    {
        $options = $question->options->values();

        $correctIndex = $options->search(function ($option) {
            return (bool) $option->is_correct;
        });

        return [
            $question->id,
            $question->subject?->title ?? '',
            $question->question_text,
            $question->score,
            $question->difficulty,
            $options[0]->option_text ?? '',
            $options[1]->option_text ?? '',
            $options[2]->option_text ?? '',
            $options[3]->option_text ?? '',
            $correctIndex !== false ? $correctIndex + 1 : '',
            $question->created_at?->format('Y-m-d H:i:s'),
        ];
    }

    public function headings(): array
    {
        return [
            'id',
            'subject',
            'question_text',
            'score',
            'difficulty',
            'option_1',
            'option_2',
            'option_3',
            'option_4',
            'correct_option',
            'created_at',
        ];
    }
}
