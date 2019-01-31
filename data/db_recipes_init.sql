INSERT INTO ingredient (name) VALUES ('Potato');
INSERT INTO ingredient (name) VALUES ('Vinegar');
INSERT INTO ingredient (name) VALUES ('Cheese');
INSERT INTO ingredient (name) VALUES ('Ketchup');
INSERT INTO ingredient (name) VALUES ('Lettuce');
INSERT INTO ingredient (name) VALUES ('Onions');
INSERT INTO ingredient (name) VALUES ('Tomato');
INSERT INTO ingredient (name) VALUES ('Dough');
INSERT INTO ingredient (name) VALUES ('Pepperoni');
INSERT INTO ingredient (name) VALUES ('Oregano');
INSERT INTO ingredient (name) VALUES ('Pineapple');

INSERT INTO category (name) VALUES ('Breakfast');
INSERT INTO category (name) VALUES ('Lunch');
INSERT INTO category (name) VALUES ('Dinner');

INSERT INTO tag (name) VALUES ('Hot');
INSERT INTO tag (name) VALUES ('Sour');
INSERT INTO tag (name) VALUES ('Sweet');
INSERT INTO tag (name) VALUES ('Fruity');
INSERT INTO tag (name) VALUES ('Tangy');
INSERT INTO tag (name) VALUES ('Greasy');

INSERT INTO recipe (title, description, date, category_id, image_url) VALUES ('Pepperoni Pizza', 'A pepperoni pizza with additional hot-sauce', CURRENT_TIMESTAMP, (SELECT id FROM category WHERE name = 'Breakfast'), 'http://localhost:8000/images/default.jpeg');
INSERT INTO recipe (title, description, date, category_id, image_url) VALUES ('Vegetarian Pizza', 'A vegetarian pizza rich with vitamins.', CURRENT_TIMESTAMP, (SELECT id FROM category WHERE name = 'Dinner'), 'http://localhost:8000/images/default.jpeg');
INSERT INTO recipe (title, description, date, category_id, image_url) VALUES ('Pineapple Pizza', 'A fruity pizza rich with a tropical twist.', CURRENT_TIMESTAMP, (SELECT id FROM category WHERE name = 'Lunch'), 'http://localhost:8000/images/default.jpeg');

INSERT INTO recipe_ingredient (recipe_id, ingredient_id) VALUES ((SELECT id FROM recipe WHERE title = 'Pepperoni Pizza'), (SELECT id FROM ingredient WHERE name = 'Dough'));
INSERT INTO recipe_ingredient (recipe_id, ingredient_id) VALUES ((SELECT id FROM recipe WHERE title = 'Pepperoni Pizza'), (SELECT id FROM ingredient WHERE name = 'Ketchup'));
INSERT INTO recipe_ingredient (recipe_id, ingredient_id) VALUES ((SELECT id FROM recipe WHERE title = 'Pepperoni Pizza'), (SELECT id FROM ingredient WHERE name = 'Cheese'));
INSERT INTO recipe_ingredient (recipe_id, ingredient_id) VALUES ((SELECT id FROM recipe WHERE title = 'Pepperoni Pizza'), (SELECT id FROM ingredient WHERE name = 'Pepperoni'));
INSERT INTO recipe_ingredient (recipe_id, ingredient_id) VALUES ((SELECT id FROM recipe WHERE title = 'Vegetarian Pizza'), (SELECT id FROM ingredient WHERE name = 'Dough'));
INSERT INTO recipe_ingredient (recipe_id, ingredient_id) VALUES ((SELECT id FROM recipe WHERE title = 'Vegetarian Pizza'), (SELECT id FROM ingredient WHERE name = 'Ketchup'));
INSERT INTO recipe_ingredient (recipe_id, ingredient_id) VALUES ((SELECT id FROM recipe WHERE title = 'Vegetarian Pizza'), (SELECT id FROM ingredient WHERE name = 'Cheese'));
INSERT INTO recipe_ingredient (recipe_id, ingredient_id) VALUES ((SELECT id FROM recipe WHERE title = 'Vegetarian Pizza'), (SELECT id FROM ingredient WHERE name = 'Oregano'));
INSERT INTO recipe_ingredient (recipe_id, ingredient_id) VALUES ((SELECT id FROM recipe WHERE title = 'Vegetarian Pizza'), (SELECT id FROM ingredient WHERE name = 'Lettuce'));
INSERT INTO recipe_ingredient (recipe_id, ingredient_id) VALUES ((SELECT id FROM recipe WHERE title = 'Pineapple Pizza'), (SELECT id FROM ingredient WHERE name = 'Dough'));
INSERT INTO recipe_ingredient (recipe_id, ingredient_id) VALUES ((SELECT id FROM recipe WHERE title = 'Pineapple Pizza'), (SELECT id FROM ingredient WHERE name = 'Lettuce'));
INSERT INTO recipe_ingredient (recipe_id, ingredient_id) VALUES ((SELECT id FROM recipe WHERE title = 'Pineapple Pizza'), (SELECT id FROM ingredient WHERE name = 'Oregano'));
INSERT INTO recipe_ingredient (recipe_id, ingredient_id) VALUES ((SELECT id FROM recipe WHERE title = 'Pineapple Pizza'), (SELECT id FROM ingredient WHERE name = 'Pineapple'));

INSERT INTO recipe_tag (recipe_id, tag_id) VALUES ((SELECT id FROM recipe WHERE title = 'Pepperoni Pizza'), (SELECT id FROM tag WHERE name = 'Hot'));
INSERT INTO recipe_tag (recipe_id, tag_id) VALUES ((SELECT id FROM recipe WHERE title = 'Pepperoni Pizza'), (SELECT id FROM tag WHERE name = 'Greasy'));
INSERT INTO recipe_tag (recipe_id, tag_id) VALUES ((SELECT id FROM recipe WHERE title = 'Vegetarian Pizza'), (SELECT id FROM tag WHERE name = 'Sour'));
INSERT INTO recipe_tag (recipe_id, tag_id) VALUES ((SELECT id FROM recipe WHERE title = 'Vegetarian Pizza'), (SELECT id FROM tag WHERE name = 'Sweet'));
INSERT INTO recipe_tag (recipe_id, tag_id) VALUES ((SELECT id FROM recipe WHERE title = 'Vegetarian Pizza'), (SELECT id FROM tag WHERE name = 'Tangy'));
INSERT INTO recipe_tag (recipe_id, tag_id) VALUES ((SELECT id FROM recipe WHERE title = 'Pineapple Pizza'), (SELECT id FROM tag WHERE name = 'Sweet'));