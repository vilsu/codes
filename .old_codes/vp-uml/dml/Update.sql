UPDATE questions SET 
  users_user_id = ?, 
  title = ?, 
  body = ?, 
  was_sent_at_time = ?, 
  flagged_for_moderator_removal = ?, 
  was_last_checked_by_moderator = ? 
WHERE
  question_id = ?;
UPDATE users SET 
  username = ?, 
  email = ?, 
  passhash_md5 = ?, 
  a_moderator = ?, 
  logged_in = ?, 
  has_been_sent_a_moderator_message = ?, 
  salt = ? 
WHERE
  user_id = ?;
UPDATE answers SET 
  answer = ?, 
  questions_question_id = ? 
WHERE
  answer_id = ?;
UPDATE tags SET 
  tag = ?, 
  questions_question_id = ? 
WHERE
  tag_id = ?;

