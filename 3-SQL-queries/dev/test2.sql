SELECT t.question_id, t.tag
FROM tags t
WHERE t.question_id IN
(
    SELECT q.question_id
    FROM questions q
    WHERE q.user_id IN
        (
            SELECT u.user_id
            FROM users u
            WHERE u.username='hello'
        )
)
ORDER BY t.question_id;
