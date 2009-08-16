CREATE TABLE users (
    user_id SERIAL PRIMARY KEY NOT NULL,      
    username VARCHAR(320) NOT NULL,
    email VARCHAR(320) NOT NULL UNIQUE,
    passhash_md5 VARCHAR(33) NOT NULL,
    a_moderator BOOLEAN NOT NULL DEFAULT false,
    logged_in BOOLEAN NOT NULL DEFAULT false,
    has_been_sent_a_moderator_message BOOLEAN NOT NULL DEFAULT true,
    CONSTRAINT email_to_user_id UNIQUE (email, user_id)
);

CREATE TABLE questions (
    question_id SERIAL PRIMARY KEY NOT NULL UNIQUE, 
    users_user_id INTEGER NOT NULL 
        REFERENCES users(user_id), 
    body TEXT NOT NULL DEFAULT '',
    title VARCHAR(320) NOT NULL,
    flagged_for_moderator_removal BOOLEAN NOT NULL DEFAULT false,
    was_last_checked_by_moderator_at_time TIMESTAMP, 
    was_sent_at_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT no_duplicate_questions UNIQUE (title, body)
);

CREATE TABLE tags (
    tag_id SERIAL NOT NULL PRIMARY KEY,
    tag VARCHAR(320) NOT NULL,
    questions_question_id INTEGER NOT NULL, 
    CONSTRAINT no_duplicate_tag UNIQUE (questions_question_id, tag_id)
);

CREATE TABLE answers (
    answer_id SERIAL PRIMARY KEY NOT NULL,
    answer TEXT NOT NULL DEFAULT '',
    questions_question_id INTEGER NOT NULL,
    answerer_users_user_id INTEGER NOT NULL,
    flagged_for_moderator_removal BOOLEAN NOT NULL DEFAULT false,
    CONSTRAINT no_duplicate_answers UNIQUE (questions_question_id, answer)
);
