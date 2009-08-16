SELECT questions_question_id, tag
        FROM tags
        WHERE questions_question_id IN
            ( SELECT question_id
            FROM questions
            ORDER BY was_sent_at_time
            DESC LIMIT 50
            );
