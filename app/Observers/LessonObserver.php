<?php

namespace App\Observers;

use App\Models\Lesson;

class LessonObserver extends Observer
{
    public function handle($event, $data)
    {
        if ($event === 'stats.created' && !empty($data['lesson_id'])) {
            $lesson = new Lesson();
            $lesson->updateLessonRating($data['lesson_id']);
            $lesson->updateLessonDifficulty($data['lesson_id']);
        }
    }
}