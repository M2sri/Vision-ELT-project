<?php
// database/seeders/ReadingQuestionsSeeder.php
namespace Database\Seeders;

use App\Models\ReadingQuestion;
use Illuminate\Database\Seeder;

class ReadingQuestionsSeeder extends Seeder
{
    public function run()
    {
        $questions = [
            // Beginner Level (Questions 1-4)
            [
                'question_text' => 'What time does the movie start? A) 5 PM B) 7 PM C) 9 PM D) 11 PM',
                'option_a' => '5 PM',
                'option_b' => '7 PM',
                'option_c' => '9 PM',
                'option_d' => '11 PM',
                'correct_answer' => 'b',
                'difficulty' => 'beginner'
            ],
            [
                'question_text' => 'Where is the library? A) Next to the bank B) Behind the school C) In front of the park D) Between the hotel and restaurant',
                'option_a' => 'Next to the bank',
                'option_b' => 'Behind the school',
                'option_c' => 'In front of the park',
                'option_d' => 'Between the hotel and restaurant',
                'correct_answer' => 'a',
                'difficulty' => 'beginner'
            ],
            // Intermediate Level (Questions 5-8)
            [
                'question_text' => 'According to the passage, what is the main cause of climate change? A) Natural cycles B) Human activities C) Solar radiation D) Volcanic eruptions',
                'option_a' => 'Natural cycles',
                'option_b' => 'Human activities',
                'option_c' => 'Solar radiation',
                'option_d' => 'Volcanic eruptions',
                'correct_answer' => 'b',
                'difficulty' => 'intermediate'
            ],
            [
                'question_text' => 'What does the author imply about renewable energy? A) It is too expensive B) It is the future C) It is unreliable D) It is harmful',
                'option_a' => 'It is too expensive',
                'option_b' => 'It is the future',
                'option_c' => 'It is unreliable',
                'option_d' => 'It is harmful',
                'correct_answer' => 'b',
                'difficulty' => 'intermediate'
            ],
            // Advanced Level (Questions 9-12)
            [
                'question_text' => 'What is the underlying theme of the author\'s argument about globalization? A) Cultural homogenization B) Economic disparity C) Technological advancement D) Political sovereignty',
                'option_a' => 'Cultural homogenization',
                'option_b' => 'Economic disparity',
                'option_c' => 'Technological advancement',
                'option_d' => 'Political sovereignty',
                'correct_answer' => 'a',
                'difficulty' => 'advanced'
            ],
            // Add 7 more questions following the same pattern...
        ];

        foreach ($questions as $question) {
            ReadingQuestion::create($question);
        }
    }
}