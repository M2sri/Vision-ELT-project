<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Test;
use App\Models\Question;

class PlacementTestSeeder extends Seeder
{
    public function run(): void
    {
        // =========================
        // CREATE / UPDATE TEST
        // =========================
        $test = Test::updateOrCreate(
            ['title' => 'English Placement Test'],
            [
                'duration'    => 45,
                'total_marks' => 45,
            ]
        );

        // Clear old questions
        Question::where('test_id', $test->id)->delete();

        // =========================
        // QUESTIONS
        // =========================
        $questions = [

            // =====================
            // WORD ORDER (10)
            // =====================
            ['q'=>'_____ you are how?','o'=>['How are','Are how','How are you','You are how'],'c'=>'How are you','s'=>'word_order'],
            ['q'=>'_____ we where are?','o'=>['Where are we','Are where we','We where are','We are where'],'c'=>'Where are we','s'=>'word_order'],
            ['q'=>'_____ you crying?','o'=>['Why are','Are why','Why you are','You are why'],'c'=>'Why are','s'=>'word_order'],
            ['q'=>'_____ they eat fish?','o'=>['Do','Does','Are','Is'],'c'=>'Do','s'=>'word_order'],
            ['q'=>'_____ the dog bite?','o'=>['Does','Do','Is','Are'],'c'=>'Does','s'=>'word_order'],
            ['q'=>'_____ does the movie start?','o'=>['When','Where','What','How'],'c'=>'When','s'=>'word_order'],
            ['q'=>'_____ are your friends?','o'=>['How','What','Where','When'],'c'=>'How','s'=>'word_order'],
            ['q'=>'_____ are you going to the beach?','o'=>['Are','Do','Is','Did'],'c'=>'Are','s'=>'word_order'],
            ['q'=>'_____ is your birthday?','o'=>['When','Where','How','What'],'c'=>'When','s'=>'word_order'],
            ['q'=>'_____ is the answer?','o'=>['What','Which','Who','Where'],'c'=>'What','s'=>'word_order'],

            // =====================
            // VOCABULARY (8)
            // =====================
            ['q'=>'Their dog barks a lot, but it won\'t hurt you. It\'s completely _____.','o'=>['harmless','moody','romantic','heavy'],'c'=>'harmless','s'=>'vocabulary'],
            ['q'=>'In the _____, you find a list of things for sale with prices.','o'=>['brochure','calendar','novel','laughter'],'c'=>'brochure','s'=>'vocabulary'],
            ['q'=>'A _____ is a love story.','o'=>['romantic novel','calendar','magician','hurricane'],'c'=>'romantic novel','s'=>'vocabulary'],
            ['q'=>'You had better take an umbrella; it\'s raining _____.','o'=>['heavily','easily','softly','slowly'],'c'=>'heavily','s'=>'vocabulary'],
            ['q'=>'At the show, the _____ kept pulling rabbits out of his hat.','o'=>['magician','actor','writer','driver'],'c'=>'magician','s'=>'vocabulary'],
            ['q'=>'You look at the _____ to know the date and month.','o'=>['calendar','novel','brochure','clock'],'c'=>'calendar','s'=>'vocabulary'],
            ['q'=>'A massive _____ shook the city, destroying buildings.','o'=>['hurricane','drought','famine','storm'],'c'=>'hurricane','s'=>'vocabulary'],
            ['q'=>'Hana is so _____; one minute she laughs, the next she frowns.','o'=>['moody','happy','romantic','kind'],'c'=>'moody','s'=>'vocabulary'],

            // =====================
            // VERB OPPOSITES (10)
            // =====================
            ['q'=>'Opposite of "Accept"?','o'=>['Approve','Refuse','Allow','Agree'],'c'=>'Refuse','s'=>'verb_opposites'],
            ['q'=>'Opposite of "Adore"?','o'=>['Like','Enjoy','Loathe','Love'],'c'=>'Loathe','s'=>'verb_opposites'],
            ['q'=>'Opposite of "Attack"?','o'=>['Hit','Fight','Defend','Destroy'],'c'=>'Defend','s'=>'verb_opposites'],
            ['q'=>'Opposite of "Create"?','o'=>['Build','Make','Destroy','Design'],'c'=>'Destroy','s'=>'verb_opposites'],
            ['q'=>'Opposite of "Encourage"?','o'=>['Support','Help','Discourage','Motivate'],'c'=>'Discourage','s'=>'verb_opposites'],
            ['q'=>'Opposite of "Get worse"?','o'=>['Fail','Improve','Break','Reduce'],'c'=>'Improve','s'=>'verb_opposites'],
            ['q'=>'Opposite of "Increase"?','o'=>['Raise','Grow','Decrease','Add'],'c'=>'Decrease','s'=>'verb_opposites'],
            ['q'=>'Opposite of "Obey"?','o'=>['Follow','Accept','Disobey','Agree'],'c'=>'Disobey','s'=>'verb_opposites'],
            ['q'=>'Opposite of "Praise"?','o'=>['Admire','Support','Criticize','Encourage'],'c'=>'Criticize','s'=>'verb_opposites'],
            ['q'=>'Opposite of "Vanish"?','o'=>['Disappear','Hide','Appear','Leave'],'c'=>'Appear','s'=>'verb_opposites'],

            // =====================
            // PASSIVE FORM (6)
            // =====================
            ['q'=>'Someone stole my bike last week.','o'=>['My bike was stolen last week','My bike stole last week','My bike has stolen','My bike is stealing'],'c'=>'My bike was stolen last week','s'=>'passive_form'],
            ['q'=>'The chef cooks the fish perfectly.','o'=>['The fish is cooked perfectly','The fish cooks perfectly','The fish was cooking','The fish has cooked'],'c'=>'The fish is cooked perfectly','s'=>'passive_form'],
            ['q'=>'We will reach a decision next week.','o'=>['A decision will be reached next week','A decision reached','A decision is reaching','A decision has reached'],'c'=>'A decision will be reached next week','s'=>'passive_form'],
            ['q'=>'They have decided that your contract will not be renewed.','o'=>['It has been decided that your contract will not be renewed','They decided your contract','Your contract was decide','Your contract didn\'t renew'],'c'=>'It has been decided that your contract will not be renewed','s'=>'passive_form'],
            ['q'=>'Have the police already arrested both criminals?','o'=>['Have both criminals already been arrested?','Have both criminals arrested already?','Were both criminals arrest already?','Did both criminals been arrested?'],'c'=>'Have both criminals already been arrested?','s'=>'passive_form'],
            ['q'=>'While they were making the film, the money ran out.','o'=>['While the film was being made, the money ran out','While the film was made','While the film being made','While making the film, money ran out'],'c'=>'While the film was being made, the money ran out','s'=>'passive_form'],

            // =====================
            // SENTENCE TRANSFORMATION (7)
            // =====================
            ['q'=>'If you look after it, I will let you keep my bicycle till the weekend.','o'=>['On condition that you look after it, I will let you keep my bicycle till the weekend','Unless you look after it','Although you look after it','In spite of looking after it'],'c'=>'On condition that you look after it, I will let you keep my bicycle till the weekend','s'=>'sentence_transformation'],
            ['q'=>'She couldn\'t have stolen the jewels if she hadn\'t had inside help.','o'=>['Unless she had inside help, she couldn\'t have stolen the jewels','Unless she has inside help','Unless she had inside help, she didn\'t steal','Unless she has help'],'c'=>'Unless she had inside help, she couldn\'t have stolen the jewels','s'=>'sentence_transformation'],
            ['q'=>'When should I be at the station?','o'=>['She asked when she should be at the station','She asked when should I be','She asked when I should be?','She asked when was I'],'c'=>'She asked when she should be at the station','s'=>'sentence_transformation'],
            ['q'=>'Minutes after shutting the door, I realized I had left my keys inside.','o'=>['No sooner had I shut the door than I realized I had left my keys inside','No sooner I shut the door','No sooner had I shut the door when','No sooner shutting the door'],'c'=>'No sooner had I shut the door than I realized I had left my keys inside','s'=>'sentence_transformation'],
            ['q'=>'Although the circumstances were tough, Rashid managed the situation.','o'=>['In spite of the tough circumstances, Rashid managed the situation','In spite the circumstances were tough','Despite Rashid managed','In spite of Rashid managed'],'c'=>'In spite of the tough circumstances, Rashid managed the situation','s'=>'sentence_transformation'],
            ['q'=>'If the weather worsens, the match will probably be cancelled.','o'=>['Should the weather worsen, the match will probably be cancelled','Should the weather worsens','Should weather worsen','Should the weather worsened'],'c'=>'Should the weather worsen, the match will probably be cancelled','s'=>'sentence_transformation'],
            ['q'=>'Stevenson is an architect; his designs won international praise.','o'=>['Stevenson is an architect whose designs won international praise','Stevenson is an architect which designs','Stevenson is an architect who designs','Stevenson is an architect that designs'],'c'=>'Stevenson is an architect whose designs won international praise','s'=>'sentence_transformation'],

            // =====================
            // READING (5)
            // =====================
            ['q'=>'The tone of the author is best described as:','o'=>['Doubtful','Trustworthy','Sympathetic','Gullible','Perceptive'],'c'=>'Trustworthy','s'=>'reading'],
            ['q'=>'Which statement would weaken the argument?','o'=>['Most riders are insured','Fatalities increased after helmet laws','Cars are more dangerous','Few accidents are serious','Theft still exists'],'c'=>'Fatalities increased after helmet laws','s'=>'reading'],
            ['q'=>'The main purpose of paragraph five is to:','o'=>['Respond to opponents','Present statistics','Explain helmets','Encourage voting','None of these'],'c'=>'Respond to opponents','s'=>'reading'],
            ['q'=>'The author’s tone can also be described as:','o'=>['Fiery','Rigid','Coercive','Firm','Funny'],'c'=>'Firm','s'=>'reading'],
            ['q'=>'Which unstated assumption does the author make?','o'=>['Freedom has limits','Helmets never fail','Motorcycles are unsafe','Laws are perfect','Riders are careless'],'c'=>'Freedom has limits','s'=>'reading'],
        ];

        foreach ($questions as $i => $q) {
                Question::create([
                    'test_id'        => $test->id,
                    'type'           => 'mcq',
                    'question'       => $q['q'],
                    'options'        => $q['o'],
                    'correct_answer' => [$q['c']], // ✅ MUST be array
                    'section'        => $q['s'],
                    'marks'          => 1,
                    'order'          => $i + 1,
                ]);
            }


        // =========================
        // READING PASSAGE
        // =========================
        $test->update([
            'reading_passage' => <<<TEXT
This November, I encourage the people of Arkansas to vote NO on a referendum to repeal
the state’s motorcycle helmet law. The state’s current helmet law saves hundreds of lives per year,
and it is senseless that people should be injured or killed merely because they are too vain to wear
a helmet. Furthermore, helmet laws help to reduce public expenditures on health care and have even
been shown to deter motorcycle theft. For these reasons, the citizens of Arkansas must oppose this
referendum.

One hardly needs to appeal to statistics to show that helmets protect motorcyclists against
injury or death. For those who are skeptical, however, the National Highway Traffic Safety
Administration (NHTSA) calculates that in an accident helmets reduce the likelihood of fatal injury
by 29%. After California passed its helmet law in 1992, that state saw motorcycle-related fatalities
decrease by 37% in a single year. These statistics are impossible to ignore.

Many opponents of the helmet law agree that helmets save lives but argue that wearing a helmet
should be a personal choice. This argument fails because injured riders often rely on public funds
for healthcare. Repealing the law would increase public spending at a time of financial crisis.

Helmet laws also reduce motorcycle theft. After Texas enacted a helmet law, some cities saw
motorcycle theft drop by up to 44%, reducing law enforcement costs.

Opponents claim education is enough and that helmet laws restrict freedom. While education is
important, accidents still happen, and freedom does not justify placing costs on society.

In conclusion, helmet laws benefit not only riders but all citizens.
TEXT
        ]);
    }
}
