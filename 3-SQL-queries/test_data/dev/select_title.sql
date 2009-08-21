SELECT question_id, title
        FROM questions
        WHERE question_id IN
        (
            SELECT question_id
            FROM questions
            ORDER BY was_sent_at_time
            DESC LIMIT 50
        )
        ORDER BY was_sent_at_time
        DESC LIMIT 50;
