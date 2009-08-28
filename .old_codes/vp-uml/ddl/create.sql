CREATE TABLE questions (
  user_infos_user_id int4 NOT NULL, 
  question_id         SERIAL NOT NULL, 
  title              varchar(60), 
  body               text, 
  sent_time          timestamp, 
  moderator_removal  bool, 
  PRIMARY KEY (question_id));
CREATE TABLE user_infos (
  user_id                            SERIAL NOT NULL, 
  username                          varchar(50), 
  email                             varchar(320), 
  password_md5                      varchar(32), 
  is_moderator                      bool, 
  is_login                          bool, 
  has_been_sent_a_moderator_message bool, 
  PRIMARY KEY (user_id));
CREATE TABLE answers (
  answer                text, 
  questions_question_id int4 NOT NULL);
CREATE TABLE tags (
  tag                   varchar(10), 
  questions_question_id int4 NOT NULL);
ALTER TABLE questions ADD CONSTRAINT FKquestions220347 FOREIGN KEY (user_infos_user_id) REFERENCES user_infos (user_id);
ALTER TABLE tags ADD CONSTRAINT FKtags942307 FOREIGN KEY (questions_question_id) REFERENCES questions (question_id);
ALTER TABLE answers ADD CONSTRAINT FKanswers894234 FOREIGN KEY (questions_question_id) REFERENCES questions (question_id);

