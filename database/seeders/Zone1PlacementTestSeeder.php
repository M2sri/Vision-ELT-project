<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Test;
use App\Models\Question;

class Zone1PlacementTestSeeder extends Seeder
{
    public function run(): void
    {
        $test = Test::updateOrCreate(
            ['title' => 'Kids Placement Test – Zone 1'],
            [
                'duration'    => 22,
                'total_marks' => 22,
            ]
        );

        Question::where('test_id', $test->id)->delete();

        $questions = [

            /* =========================
               A. CIRCLE THE CORRECT LETTER (5)
            ========================= */
            ['q'=>'/b/ sound','o'=>['B','D','F'],'c'=>'B','s'=>'phonics'],
            ['q'=>'/m/ sound','o'=>['N','M','T'],'c'=>'M','s'=>'phonics'],
            ['q'=>'/s/ sound','o'=>['A','S','P'],'c'=>'S','s'=>'phonics'],
            ['q'=>'/t/ sound','o'=>['T','K','M'],'c'=>'T','s'=>'phonics'],
            ['q'=>'/a/ sound','o'=>['O','E','A'],'c'=>'A','s'=>'phonics'],

            /* =========================
               B. MATCH LETTER TO PICTURE (5)
            ========================= */
            [
                'q' => 'Match the letter to the picture',
                'type' => 'match',
                'o' => ['A','B','C','D','E'],
                'c' => json_encode([
                    'A' => 'fa-apple-whole',
                    'B' => 'fa-lemon',
                    'C' => 'fa-cat',
                    'D' => 'fa-dog',
                    'E' => 'fa-egg',
                ]),
                's' => 'matching_letters'
            ],

            /* =========================
               C. READ AND MATCH (8)
            ========================= */
            [
                'q' => 'Read and match the word to the picture',
                'type' => 'match',
                'o' => ['Ball','Hat','Fish','Dog','Book','Pen','Cat','Sun'],
                'c' => json_encode([
                    'Ball' => 'fa-futbol',
                    'Hat'  => 'fa-hat-cowboy',
                    'Fish' => 'fa-fish',
                    'Dog'  => 'fa-dog',
                    'Book' => 'fa-book',
                    'Pen'  => 'fa-pen',
                    'Cat'  => 'fa-cat',
                    'Sun'  => 'fa-sun',
                ]),
                's' => 'matching_words'
            ],

            /* =========================
               D. READ AND CHOOSE (2)
            ========================= */
            [
                'q'=>'The cat is under the table.',
                'o'=>[
                    'The cat is on the table',
                    'The cat is under the table'
                ],
                'c'=>'The cat is under the table',
                's'=>'reading_choose'
            ],
            [
                'q'=>'Ali has a red ball.',
                'o'=>[
                    'Ali has a red ball',
                    'Ali has a blue ball'
                ],
                'c'=>'Ali has a red ball',
                's'=>'reading_choose'
            ],

            /* =========================
               E. READING COMPREHENSION (2)
            ========================= */
            [
                'q'=>'What color is Sarah\'s bag?',
                'o'=>['Blue','Red','Green'],
                'c'=>'Blue',
                's'=>'comprehension'
            ],
            [
                'q'=>'What does Sarah put in her bag?',
                'o'=>['Book','Ball','Pen'],
                'c'=>'Book',
                's'=>'comprehension'
            ],
        ];

        foreach ($questions as $index => $q) {
            Question::create([
                'test_id'        => $test->id,
                'type'           => $q['type'] ?? 'mcq', // Use 'match' type for matching questions
                'section'        => $q['s'],
                'question'       => $q['q'],
                'options'        => json_encode($q['o']),
                'correct_answer' => $q['c'],
                'marks'          => 1,
                'order'          => $index + 1,
            ]);
        }
    }
}