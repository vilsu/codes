INSERT INTO answers (questions_question_id, answerer_users_user_id, answer)
    VALUES (1, 1 'Vastaus_1');

INSERT INTO answers (questions_question_id, answerer_users_user_id, answer)
    VALUES (2, 2, 'Vastaus_2');

INSERT INTO answers (questions_question_id, answerer_users_user_id, answer)
    VALUES (3, 3, 'Vastaus_3');
    
INSERT INTO answers (questions_question_id, answerer_users_user_id, answer)
    VALUES (4, 4, 'Vastaus_4');

--  answer-column is enough to differentiate answers
INSERT INTO answers (questions_question_id, answerer_users_user_id, answer)
    VALUES (4, 4, 'Vastaus_4_samalta_userilta');

-- show only one
-- BEGIN
INSERT INTO answers (questions_question_id, answerer_users_user_id, answer)
    VALUES (4, 4, 'Vastaus_4_ala_nayta_kahta');

INSERT INTO answers (questions_question_id, answerer_users_user_id, answer)
    VALUES (4, 4, 'Vastaus_4_ala_nayta_kahta');

INSERT INTO answers (questions_question_id, answerer_users_user_id, answer)
    VALUES (4, 4, 'Vastaus_4_ala_nayta_kahta');

--END
