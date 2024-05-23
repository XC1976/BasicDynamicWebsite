INSERT INTO REVIEW_BOOK (id_review, comment, id_book, id_user, respond_to, rating, time_stamp) 
VALUES (1, 'Ce livre est tout simplement magnifique. L''histoire est riche en rebondissements et en émotions. Une lecture incontournable !', 5, 1, NULL, 4, '2024-04-29 10:00:00');

INSERT INTO REVIEW_BOOK (id_review, comment, id_book, id_user, respond_to, rating, time_stamp) 
VALUES (2, 'Le Comte de Monte-Cristo", chef-d''œuvre de la littérature française, est à la fois captivant et déroutant. Alexandre Dumas tisse un récit d''intrigues, de vengeance et de justice qui captive dès les premières pages. Cependant, certains pourraient critiquer sa longueur excessive et ses nombreux rebondissements qui peuvent parfois sembler artificiels. De plus, bien que les personnages soient complexes et fascinants, leur développement peut parfois sembler superficiel, laissant le lecteur avec un sentiment d''inachevé. Néanmoins, la richesse de l''histoire et les thèmes intemporels abordés, tels que la vengeance, la trahison et la rédemption, en font un incontournable de la littérature française. En somme, "Le Comte de Monte-Cristo" est un roman ambitieux qui suscite à la fois admiration et frustration, mais qui reste ancré dans l''imaginaire collectif comme un classique indéniable.', 5, 2, NULL, 5, '2024-04-29 10:03:00');

INSERT INTO REVIEW_BOOK (id_review, comment, id_book, id_user, respond_to, rating, time_stamp) 
VALUES (3, 'Bien que je respecte l''appréciation de \"Le Comte de Monte-Cristo\" comme un chef-d''œuvre, je dois exprimer une opinion divergente. Pour moi, la longueur et les rebondissements incessants ne sont pas des défauts, mais plutôt des éléments qui enrichissent l''expérience de lecture. Chaque twist ajoute une nouvelle dimension à l''intrigue, maintient l''intérêt et permet une exploration approfondie des thèmes complexes du roman. De plus, la complexité des personnages ne nécessite pas forcément un développement exhaustif pour être efficace. Le mystère qui entoure certains d''entre eux ajoute à leur aura et à l''intrigue globale. En fin de compte, la subjectivité de l''appréciation littéraire joue un rôle important, mais pour moi, "Le Comte de Monte-Cristo" reste un chef-d''œuvre incontestable, à savourer pour sa richesse narrative et son ingéniosité.', 5, 3, 2, NULL, '2024-04-29 10:04:00');

INSERT INTO REVIEW_BOOK (id_review, comment, id_book, id_user, respond_to, rating, time_stamp) 
VALUES (4, 'Je comprends ton point de vue, mais pour moi, la richesse narrative ne doit pas sacrifier la concision et la clarté. Trop de rebondissements peuvent parfois diluer l''impact des moments clés. Cependant, je respecte ton appréciation de l''œuvre et je suis ravi que "Le Comte de Monte-Cristo" puisse être perçu de différentes manières selon les lecteurs. C''est là toute la beauté de la littérature !', 5, 2, 3, NULL, '2024-04-29 10:05:00');

INSERT INTO REVIEW_BOOK (id_review, comment, id_book, id_user, respond_to, rating, time_stamp) 
VALUES (5, 'Un classique à ne pas manquer ! L''histoire est captivante et les personnages sont inoubliables. Ce livre mérite sa réputation de chef-d''œuvre.', 5, 5, 2, NULL, '2024-04-29 10:10:00');

INSERT INTO REVIEW_BOOK (id_review, comment, id_book, id_user, respond_to, rating, time_stamp) 
VALUES (6, 'Absolument, c''est ce qui rend la discussion sur la littérature si fascinante : la diversité des interprétations et des ressentis. Il est enrichissant de pouvoir échanger nos points de vue et de voir comment une même œuvre peut susciter des réactions variées. En fin de compte, c''est cette diversité qui contribue à maintenir l''intérêt et la pertinence de chefs-d''œuvre comme "Le Comte de Monte-Cristo" à travers les générations. Merci pour cette conversation stimulante !', 5, 3, 4, NULL, '2024-04-29 11:00:00');

INSERT INTO REVIEW_BOOK (id_review, comment, id_book, id_user, respond_to, rating, time_stamp) 
VALUES (7, 'Passionnant', 5, 5, 6, NULL, '2024-04-29 12:00:00');

INSERT INTO REVIEW_BOOK (comment, id_book, id_user, respond_to, rating, time_stamp) 
VALUES ('Une lecture passionnante', 5, 5, NULL, 3, '2024-04-29 12:00:00');

-- Review about book 2 by user 3
INSERT INTO REVIEW_BOOK (comment, id_book, id_user, respond_to, rating, time_stamp)
VALUES ('Une histoire passionnante avec des personnages attachants.', 2, 3, NULL, 5, '2024-04-30 11:30:00');

-- Review about book 3 by user 6
INSERT INTO REVIEW_BOOK (comment, id_book, id_user, respond_to, rating, time_stamp)
VALUES ('J''ai adoré ce livre, une intrigue palpitante !', 3, 6, NULL, 5, '2024-04-30 13:45:00');

-- Review about book 4 by user 9
INSERT INTO REVIEW_BOOK (comment, id_book, id_user, respond_to, rating, time_stamp)
VALUES ('Ce livre m''a vraiment transporté, une lecture inoubliable !', 4, 9, NULL, 4, '2024-04-30 14:20:00');

-- Review about book 5 by user 13
INSERT INTO REVIEW_BOOK (comment, id_book, id_user, respond_to, rating, time_stamp)
VALUES ('Un livre intéressant, mais quelques longueurs.', 5, 13, NULL, 3, '2024-04-30 15:10:00');

-- Review about book 6 by user 18
INSERT INTO REVIEW_BOOK (comment, id_book, id_user, respond_to, rating, time_stamp)
VALUES ('Une lecture agréable, mais pas exceptionnelle.', 6, 18, NULL, 3, '2024-04-30 16:00:00');

-- Review about book 7 by user 4
INSERT INTO REVIEW_BOOK (comment, id_book, id_user, respond_to, rating, time_stamp)
VALUES ('Un livre fascinant, je le recommande vivement !', 7, 4, NULL, 5, '2024-04-30 09:45:00');

-- Review about book 8 by user 7
INSERT INTO REVIEW_BOOK (comment, id_book, id_user, respond_to, rating, time_stamp)
VALUES ('Ce livre m''a beaucoup fait réfléchir, une lecture enrichissante.', 8, 7, NULL, 4, '2024-04-30 11:00:00');

-- Review about book 9 by user 12
INSERT INTO REVIEW_BOOK (comment, id_book, id_user, respond_to, rating, time_stamp)
VALUES ('Un bon livre, mais l''intrigue était prévisible.', 9, 12, NULL, 3, '2024-04-30 13:20:00');

-- Review about book 10 by user 19
INSERT INTO REVIEW_BOOK (comment, id_book, id_user, respond_to, rating, time_stamp)
VALUES ('J''ai adoré ce livre, impossible de le lâcher !', 10, 19, NULL, 5, '2024-04-30 14:50:00');

-- Review about book 11 by user 23
INSERT INTO REVIEW_BOOK (comment, id_book, id_user, respond_to, rating, time_stamp)
VALUES ('Une lecture captivante, j''ai été absorbé du début à la fin.', 11, 23, NULL, 5, '2024-04-30 16:30:00');

-- Review about book 12 by user 2
INSERT INTO REVIEW_BOOK (comment, id_book, id_user, respond_to, rating, time_stamp)
VALUES ('Ce livre m''a profondément ému, une lecture à recommander absolument !', 12, 2, NULL, 5, '2024-04-30 10:30:00');

-- Review about book 13 by user 8
INSERT INTO REVIEW_BOOK (comment, id_book, id_user, respond_to, rating, time_stamp)
VALUES ('Une histoire intrigante, j''ai adoré les rebondissements.', 13, 8, NULL, 4, '2024-04-30 12:15:00');

-- Review about book 14 by user 11
INSERT INTO REVIEW_BOOK (comment, id_book, id_user, respond_to, rating, time_stamp)
VALUES ('Un livre captivant du début à la fin, une belle découverte !', 14, 11, NULL, 5, '2024-04-30 13:40:00');

-- Review about book 15 by user 17
INSERT INTO REVIEW_BOOK (comment, id_book, id_user, respond_to, rating, time_stamp)
VALUES ('Une lecture intéressante, mais certains aspects étaient prévisibles.', 15, 17, NULL, 3, '2024-04-30 15:20:00');

-- Review about book 16 by user 24
INSERT INTO REVIEW_BOOK (comment, id_book, id_user, respond_to, rating, time_stamp)
VALUES ('Un livre qui m''a laissé perplexe, je suis mitigé sur mon ressenti.', 16, 24, NULL, 2, '2024-04-30 16:45:00');

-- Review about book 17 by user 5
INSERT INTO REVIEW_BOOK (comment, id_book, id_user, respond_to, rating, time_stamp)
VALUES ('Ce livre m''a transporté dans un monde imaginaire, une expérience unique !', 17, 5, NULL, 5, '2024-04-30 09:15:00');

-- Review about book 18 by user 10
INSERT INTO REVIEW_BOOK (comment, id_book, id_user, respond_to, rating, time_stamp)
VALUES ('Une lecture divertissante, parfaite pour se détendre.', 18, 10, NULL, 4, '2024-04-30 11:50:00');

-- Review about book 19 by user 15
INSERT INTO REVIEW_BOOK (comment, id_book, id_user, respond_to, rating, time_stamp)
VALUES ('Un livre qui m''a fait réfléchir sur la nature humaine, très intéressant.', 19, 15, NULL, 4, '2024-04-30 13:10:00');

-- Review about book 20 by user 20
INSERT INTO REVIEW_BOOK (comment, id_book, id_user, respond_to, rating, time_stamp)
VALUES ('Une lecture envoûtante, je recommande vivement !', 20, 20, NULL, 5, '2024-04-30 14:25:00');

-- Review about book 21 by user 25
INSERT INTO REVIEW_BOOK (comment, id_book, id_user, respond_to, rating, time_stamp)
VALUES ('Ce livre m''a fait passer un excellent moment, je le relirai avec plaisir.', 21, 25, NULL, 5, '2024-04-30 16:00:00');

-- Review about book 22 by user 1
INSERT INTO REVIEW_BOOK (comment, id_book, id_user, respond_to, rating, time_stamp)
VALUES ('Une lecture passionnante, j''ai été captivé du début à la fin !', 22, 1, NULL, 5, '2024-04-30 10:45:00');

-- Review about book 23 by user 6
INSERT INTO REVIEW_BOOK (comment, id_book, id_user, respond_to, rating, time_stamp)
VALUES ('Un livre qui m''a beaucoup fait réfléchir, je le recommande.', 23, 6, NULL, 4, '2024-04-30 12:30:00');

-- Review about book 24 by user 11
INSERT INTO REVIEW_BOOK (comment, id_book, id_user, respond_to, rating, time_stamp)
VALUES ('Ce livre m''a totalement transporté, une expérience de lecture inoubliable.', 24, 11, NULL, 5, '2024-04-30 14:00:00');

-- Review about book 25 by user 16
INSERT INTO REVIEW_BOOK (comment, id_book, id_user, respond_to, rating, time_stamp)
VALUES ('Une histoire intéressante, mais la fin m''a laissé sur ma faim.', 25, 16, NULL, 3, '2024-04-30 15:30:00');

-- Review about book 26 by user 21
INSERT INTO REVIEW_BOOK (comment, id_book, id_user, respond_to, rating, time_stamp)
VALUES ('Un livre captivant, je n''ai pas pu le poser avant de l''avoir terminé !', 26, 21, NULL, 5, '2024-04-30 16:45:00');

-- Review about book 27 by user 2
INSERT INTO REVIEW_BOOK (comment, id_book, id_user, respond_to, rating, time_stamp)
VALUES ('Ce livre m''a transporté dans un monde fantastique, une lecture magique !', 27, 2, NULL, 5, '2024-04-30 09:30:00');

-- Review about book 28 by user 7
INSERT INTO REVIEW_BOOK (comment, id_book, id_user, respond_to, rating, time_stamp)
VALUES ('Une histoire touchante, j''ai adoré les personnages.', 28, 7, NULL, 4, '2024-04-30 11:15:00');

-- Review about book 29 by user 12
INSERT INTO REVIEW_BOOK (comment, id_book, id_user, respond_to, rating, time_stamp)
VALUES ('Un livre qui m''a fait réfléchir sur la société, très pertinent.', 29, 12, NULL, 4, '2024-04-30 13:40:00');

-- Review about book 30 by user 17
INSERT INTO REVIEW_BOOK (comment, id_book, id_user, respond_to, rating, time_stamp)
VALUES ('Une lecture prenante, je recommande à tous les amateurs de suspens !', 30, 17, NULL, 5, '2024-04-30 15:10:00');

-- Review about book 31 by user 22
INSERT INTO REVIEW_BOOK (comment, id_book, id_user, respond_to, rating, time_stamp)
VALUES ('Un livre captivant, je me suis attaché aux personnages.', 31, 22, NULL, 5, '2024-04-30 16:30:00');

-- Review about book 32 by user 3
INSERT INTO REVIEW_BOOK (comment, id_book, id_user, respond_to, rating, time_stamp)
VALUES ('Un livre captivant, j''ai été absorbé du début à la fin !', 32, 3, NULL, 5, '2024-04-30 09:45:00');

-- Review about book 33 by user 8
INSERT INTO REVIEW_BOOK (comment, id_book, id_user, respond_to, rating, time_stamp)
VALUES ('Ce livre m''a vraiment touché, une histoire poignante.', 33, 8, NULL, 4, '2024-04-30 11:20:00');

-- Review about book 34 by user 13
INSERT INTO REVIEW_BOOK (comment, id_book, id_user, respond_to, rating, time_stamp)
VALUES ('Une lecture intéressante, mais quelques passages étaient prévisibles.', 34, 13, NULL, 3, '2024-04-30 13:00:00');

-- Review about book 35 by user 18
INSERT INTO REVIEW_BOOK (comment, id_book, id_user, respond_to, rating, time_stamp)
VALUES ('Un livre divertissant, parfait pour se changer les idées.', 35, 18, NULL, 4, '2024-04-30 14:40:00');

-- Review about book 36 by user 23
INSERT INTO REVIEW_BOOK (comment, id_book, id_user, respond_to, rating, time_stamp)
VALUES ('Une histoire captivante, je le recommande à tous les amateurs de mystère.', 36, 23, NULL, 5, '2024-04-30 16:15:00');

-- Review about book 37 by user 4
INSERT INTO REVIEW_BOOK (comment, id_book, id_user, respond_to, rating, time_stamp)
VALUES ('Un livre fascinant, je n''ai pas pu le lâcher !', 37, 4, NULL, 5, '2024-04-30 10:00:00');

-- Review about book 38 by user 9
INSERT INTO REVIEW_BOOK (comment, id_book, id_user, respond_to, rating, time_stamp)
VALUES ('Ce livre m''a beaucoup fait réfléchir, une lecture enrichissante.', 38, 9, NULL, 4, '2024-04-30 12:30:00');

-- Review about book 39 by user 14
INSERT INTO REVIEW_BOOK (comment, id_book, id_user, respond_to, rating, time_stamp)
VALUES ('Une histoire captivante, j''ai adoré les rebondissements.', 39, 14, NULL, 5, '2024-04-30 14:00:00');

-- Review about book 40 by user 19
INSERT INTO REVIEW_BOOK (comment, id_book, id_user, respond_to, rating, time_stamp)
VALUES ('Un livre qui m''a ému aux larmes, une expérience de lecture unique.', 40, 19, NULL, 5, '2024-04-30 15:45:00');

-- Review about book 41 by user 24
INSERT INTO REVIEW_BOOK (comment, id_book, id_user, respond_to, rating, time_stamp)
VALUES ('Une lecture intéressante, mais j''ai trouvé certains passages lents.', 41, 24, NULL, 3, '2024-04-30 17:00:00');

-- Review about book 42 by user 5
INSERT INTO REVIEW_BOOK (comment, id_book, id_user, respond_to, rating, time_stamp)
VALUES ('Une lecture palpitante, je recommande vivement ce livre !', 42, 5, NULL, 5, '2024-04-30 09:30:00');

-- Review about book 43 by user 10
INSERT INTO REVIEW_BOOK (comment, id_book, id_user, respond_to, rating, time_stamp)
VALUES ('Ce livre m''a fait réfléchir sur de nombreux sujets, une lecture enrichissante.', 43, 10, NULL, 4, '2024-04-30 11:45:00');

-- Review about book 44 by user 15
INSERT INTO REVIEW_BOOK (comment, id_book, id_user, respond_to, rating, time_stamp)
VALUES ('Une histoire fascinante, les personnages sont très bien développés.', 44, 15, NULL, 5, '2024-04-30 13:15:00');

-- Review about book 45 by user 20
INSERT INTO REVIEW_BOOK (comment, id_book, id_user, respond_to, rating, time_stamp)
VALUES ('Un livre captivant, je n''ai pas pu le poser avant de l''avoir terminé !', 45, 20, NULL, 5, '2024-04-30 14:50:00');

-- Review about book 46 by user 25
INSERT INTO REVIEW_BOOK (comment, id_book, id_user, respond_to, rating, time_stamp)
VALUES ('Ce livre m''a transporté dans un autre monde, une expérience de lecture fantastique !', 46, 25, NULL, 5, '2024-04-30 16:15:00');

-- Review about book 47 by user 1
INSERT INTO REVIEW_BOOK (comment, id_book, id_user, respond_to, rating, time_stamp)
VALUES ('Une lecture captivante, je recommande ce livre à tous les amateurs de suspense !', 47, 1, NULL, 5, '2024-04-30 10:30:00');

-- Review about book 48 by user 6
INSERT INTO REVIEW_BOOK (comment, id_book, id_user, respond_to, rating, time_stamp)
VALUES ('Ce livre m''a fait vivre une multitude d''émotions, une expérience de lecture intense.', 48, 6, NULL, 4, '2024-04-30 12:00:00');

-- Review about book 49 by user 11
INSERT INTO REVIEW_BOOK (comment, id_book, id_user, respond_to, rating, time_stamp)
VALUES ('Un livre plein de surprises, j''ai adoré chaque page !', 49, 11, NULL, 5, '2024-04-30 13:45:00');

-- Review about book 50 by user 16
INSERT INTO REVIEW_BOOK (comment, id_book, id_user, respond_to, rating, time_stamp)
VALUES ('Une histoire captivante, mais la fin m''a laissé un peu sur ma faim.', 50, 16, NULL, 4, '2024-04-30 15:30:00');

-- Review about book 51 by user 21
INSERT INTO REVIEW_BOOK (comment, id_book, id_user, respond_to, rating, time_stamp)
VALUES ('Un livre qui m''a fait réfléchir sur de nombreux sujets, je le recommande vivement !', 51, 21, NULL, 5, '2024-04-30 17:00:00');

-- Review about book 52 by user 2
INSERT INTO REVIEW_BOOK (comment, id_book, id_user, respond_to, rating, time_stamp)
VALUES ('Une lecture passionnante, je me suis plongé dans l''histoire dès la première page !', 52, 2, NULL, 5, '2024-04-30 09:45:00');

-- Review about book 53 by user 7
INSERT INTO REVIEW_BOOK (comment, id_book, id_user, respond_to, rating, time_stamp)
VALUES ('Ce livre m''a fait voyager dans un univers fascinant, une expérience de lecture inoubliable.', 53, 7, NULL, 5, '2024-04-30 11:15:00');

-- Review about book 54 by user 12
INSERT INTO REVIEW_BOOK (comment, id_book, id_user, respond_to, rating, time_stamp)
VALUES ('Un livre qui m''a tenu en haleine jusqu''à la dernière page, je le recommande vivement !', 54, 12, NULL, 5, '2024-04-30 13:40:00');

-- Review about book 55 by user 17
INSERT INTO REVIEW_BOOK (comment, id_book, id_user, respond_to, rating, time_stamp)
VALUES ('Une histoire captivante, j''ai été complètement absorbé par l''intrigue.', 55, 17, NULL, 5, '2024-04-30 15:10:00');

-- Review about book 56 by user 22
INSERT INTO REVIEW_BOOK (comment, id_book, id_user, respond_to, rating, time_stamp)
VALUES ('Ce livre m''a fait réfléchir sur des questions importantes, une lecture enrichissante.', 56, 22, NULL, 4, '2024-04-30 16:30:00');

-- Review about book 57 by user 3
INSERT INTO REVIEW_BOOK (comment, id_book, id_user, respond_to, rating, time_stamp)
VALUES ('Une lecture captivante, j''ai été emporté par l''histoire !', 57, 3, NULL, 5, '2024-04-30 09:30:00');

-- Review about book 58 by user 8
INSERT INTO REVIEW_BOOK (comment, id_book, id_user, respond_to, rating, time_stamp)
VALUES ('Ce livre m''a fait réfléchir sur des thèmes universels, une expérience de lecture enrichissante.', 58, 8, NULL, 4, '2024-04-30 11:45:00');

-- Review about book 59 by user 13
INSERT INTO REVIEW_BOOK (comment, id_book, id_user, respond_to, rating, time_stamp)
VALUES ('Une histoire palpitante, j''ai été captivé du début à la fin !', 59, 13, NULL, 5, '2024-04-30 13:00:00');

-- Review about book 60 by user 18
INSERT INTO REVIEW_BOOK (comment, id_book, id_user, respond_to, rating, time_stamp)
VALUES ('Un livre divertissant, parfait pour se détendre après une longue journée.', 60, 18, NULL, 4, '2024-04-30 14:20:00');

-- Review about book 61 by user 23
INSERT INTO REVIEW_BOOK (comment, id_book, id_user, respond_to, rating, time_stamp)
VALUES ('Ce livre m''a fait voyager dans un monde imaginaire, une lecture magique !', 61, 23, NULL, 5, '2024-04-30 16:45:00');

-- Review about book 62 by user 4
INSERT INTO REVIEW_BOOK (comment, id_book, id_user, respond_to, rating, time_stamp)
VALUES ('Une lecture captivante, les rebondissements m''ont surpris à chaque tournant !', 62, 4, NULL, 5, '2024-04-30 10:15:00');

-- Review about book 63 by user 9
INSERT INTO REVIEW_BOOK (comment, id_book, id_user, respond_to, rating, time_stamp)
VALUES ('Ce livre m''a ému aux larmes, une histoire bouleversante !', 63, 9, NULL, 5, '2024-04-30 12:30:00');

-- Review about book 64 by user 14
INSERT INTO REVIEW_BOOK (comment, id_book, id_user, respond_to, rating, time_stamp)
VALUES ('Une lecture passionnante, j''ai été complètement absorbé par l''intrigue.', 64, 14, NULL, 5, '2024-04-30 14:00:00');

-- Review about book 65 by user 19
INSERT INTO REVIEW_BOOK (comment, id_book, id_user, respond_to, rating, time_stamp)
VALUES ('Un livre captivant, je recommande à tous les amateurs de fiction !', 65, 19, NULL, 5, '2024-04-30 15:30:00');
