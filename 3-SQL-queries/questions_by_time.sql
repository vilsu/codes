SELECT questions.title, questions.question_id, tags.tag
    FROM questions
    LEFT JOIN tags
    ON questions.question_id in 
    ( 
        SELECT question_id
        FROM questions
        DESC LIMIT 5
    ) 
    WHERE questions.question_id = tags.questions_question_id
    ORDER BY was_sent_at_time
    DESC LIMIT 50;
