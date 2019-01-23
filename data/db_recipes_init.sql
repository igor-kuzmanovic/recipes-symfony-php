INSERT INTO ingredient (id, name) VALUES (1, 'Potato');
INSERT INTO ingredient (id, name) VALUES (2, 'Vinegar');
INSERT INTO ingredient (id, name) VALUES (3, 'Cheese');
INSERT INTO ingredient (id, name) VALUES (4, 'Ketchup');
INSERT INTO ingredient (id, name) VALUES (5, 'Lettuce');
INSERT INTO ingredient (id, name) VALUES (6, 'Onions');
INSERT INTO ingredient (id, name) VALUES (7, 'Tomato');
INSERT INTO ingredient (id, name) VALUES (9, 'Dough');
INSERT INTO ingredient (id, name) VALUES (10, 'Pepperoni');
INSERT INTO ingredient (id, name) VALUES (11, 'Oregano');
INSERT INTO ingredient (id, name) VALUES (12, 'Pineapple');

INSERT INTO category (id, name) VALUES (1, 'Breakfast');
INSERT INTO category (id, name) VALUES (2, 'Lunch');
INSERT INTO category (id, name) VALUES (3, 'Dinner');

INSERT INTO tag (id, name) VALUES (1, 'Hot');
INSERT INTO tag (id, name) VALUES (2, 'Sour');
INSERT INTO tag (id, name) VALUES (3, 'Sweet');
INSERT INTO tag (id, name) VALUES (4, 'Fruity');
INSERT INTO tag (id, name) VALUES (5, 'Tangy');

INSERT INTO recipe (id, title, description, date, category_id, image_url) VALUES (1, 'Pepperoni Pizza', 'A pepperoni pizza with additional hot-sauce', CURRENT_TIMESTAMP, 3, 'none');
INSERT INTO recipe (id, title, description, date, category_id, image_url) VALUES (2, 'Vegetarian Pizza', 'A vegetarian pizza rich with vitamins.', CURRENT_TIMESTAMP, 1, 'none');

INSERT INTO recipe_ingredient (recipe_id, ingredient_id) VALUES (1, 1);
INSERT INTO recipe_ingredient (recipe_id, ingredient_id) VALUES (1, 3);
INSERT INTO recipe_ingredient (recipe_id, ingredient_id) VALUES (1, 7);
INSERT INTO recipe_ingredient (recipe_id, ingredient_id) VALUES (1, 11);
INSERT INTO recipe_ingredient (recipe_id, ingredient_id) VALUES (2, 1);
INSERT INTO recipe_ingredient (recipe_id, ingredient_id) VALUES (2, 4);
INSERT INTO recipe_ingredient (recipe_id, ingredient_id) VALUES (2, 6);
INSERT INTO recipe_ingredient (recipe_id, ingredient_id) VALUES (2, 10);
INSERT INTO recipe_ingredient (recipe_id, ingredient_id) VALUES (2, 12);

INSERT INTO recipe_tag (recipe_id, tag_id) VALUES (1, 1);
INSERT INTO recipe_tag (recipe_id, tag_id) VALUES (1, 3);
INSERT INTO recipe_tag (recipe_id, tag_id) VALUES (2, 1);
INSERT INTO recipe_tag (recipe_id, tag_id) VALUES (2, 4);
INSERT INTO recipe_tag (recipe_id, tag_id) VALUES (2, 5);