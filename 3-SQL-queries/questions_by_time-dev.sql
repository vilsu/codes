SELECT questions.title, questions.question_id, tags.tag
    FROM questions
    LEFT JOIN tags
    ON questions.question_id = tags.questions_question_id 
    WHERE questions.question_id = 14
    ORDER BY was_sent_at_time
    DESC LIMIT 10;
