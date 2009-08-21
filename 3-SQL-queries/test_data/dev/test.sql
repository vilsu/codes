SELECT q.question_id, q.title, q.was_sent_at_time, u.username 
FROM questions q LEFT 
JOIN users u
    ON q.user_id=u.user_id 
WHERE question_id IN 
( 
    SELECT question_id 
    FROM questions 
    LIMIT 50 
) 
ORDER BY was_sent_at_time 
DESC LIMIT 50;
