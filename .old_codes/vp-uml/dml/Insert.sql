INSERT INTO questions
  (users_user_id, 
  question_id, 
  title, 
  body, 
  was_sent_at_time, 
  flagged_for_moderator_removal, 
  was_last_checked_by_moderator) 
VALUES 
  (?, 
  ?, 
  ?, 
  ?, 
  ?, 
  ?, 
  ?);
INSERT INTO users
  (user_id, 
  username, 
  email, 
  passhash_md5, 
  a_moderator, 
  logged_in, 
  has_been_sent_a_moderator_message, 
  salt) 
VALUES 
  (?, 
  ?, 
  ?, 
  ?, 
  ?, 
  ?, 
  ?, 
  ?);
INSERT INTO answers
  (answer, 
  questions_question_id, 
  answer_id) 
VALUES 
  (?, 
  ?, 
  ?);
INSERT INTO tags
  (tag, 
  questions_question_id, 
  tag_id) 
VALUES 
  (?, 
  ?, 
  ?);

