CREATE TABLE users (
    email VARCHAR(320) NOT NULL,       
    passhash_md5 VARCHAR(33),
    user_id SERIAL PRIMARY KEY,      
    logged_in BOOLEAN DEFAULT false,
);

CREATE TABLE questions (
    question_id SERIAL PRIMARY KEY, 
    users_user_id INTEGER 
        REFERENCES users(user_id), 
    body TEXT,
    was_sent_at_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE answers (
    answer TEXT,
    questions_question_id INTEGER,
    answer_id SERIAL PRIMARY KEY,
    answerer_users_user_id INTEGER NOT NULL,
    CONSTRAINT no_duplicate_answers UNIQUE (questions_question_id, answer_id)
);
