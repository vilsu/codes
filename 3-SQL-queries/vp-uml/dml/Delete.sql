DELETE FROM questions 
  WHERE question_id = ?;
DELETE FROM users 
  WHERE user_id = ?;
DELETE FROM answers 
  WHERE answer_id = ?;
DELETE FROM tags 
  WHERE tag_id = ?;

