SELECT users_user_id, question_id, title, body, was_sent_at_time, 
    flagged_for_moderator_removal, was_last_checked_by_moderator 
  FROM questions;
SELECT user_id, username, email, passhash_md5, a_moderator, 
    logged_in, has_been_sent_a_moderator_message, salt 
  FROM users;
SELECT answer, questions_question_id, answer_id 
  FROM answers;
SELECT tag, questions_question_id, tag_id 
  FROM tags;

