INSERT INTO db_recipes.ingredient (id, name) VALUES (1, 'Potato');
INSERT INTO db_recipes.ingredient (id, name) VALUES (2, 'Vinegar');
INSERT INTO db_recipes.ingredient (id, name) VALUES (3, 'Cheese');
INSERT INTO db_recipes.ingredient (id, name) VALUES (4, 'Ketchup');
INSERT INTO db_recipes.ingredient (id, name) VALUES (5, 'Lettuce');
INSERT INTO db_recipes.ingredient (id, name) VALUES (6, 'Onions');
INSERT INTO db_recipes.ingredient (id, name) VALUES (7, 'Tomato');
INSERT INTO db_recipes.ingredient (id, name) VALUES (9, 'Dough');
INSERT INTO db_recipes.ingredient (id, name) VALUES (10, 'Pepperoni');
INSERT INTO db_recipes.ingredient (id, name) VALUES (11, 'Oregano');
INSERT INTO db_recipes.ingredient (id, name) VALUES (12, 'Pineapple');

INSERT INTO db_recipes.category (id, name) VALUES (1, 'Breakfast');
INSERT INTO db_recipes.category (id, name) VALUES (2, 'Lunch');
INSERT INTO db_recipes.category (id, name) VALUES (3, 'Dinner');

INSERT INTO db_recipes.tag (id, name) VALUES (1, 'Hot');
INSERT INTO db_recipes.tag (id, name) VALUES (2, 'Sour');
INSERT INTO db_recipes.tag (id, name) VALUES (3, 'Sweet');
INSERT INTO db_recipes.tag (id, name) VALUES (4, 'Fruity');
INSERT INTO db_recipes.tag (id, name) VALUES (5, 'Tangy');

INSERT INTO db_recipes.recipe (id, title, description, date, category_id) VALUES (1, 'Pepperoni Pizza', 'A pepperoni pizza with additional hot-sauce', CURRENT_TIMESTAMP, 3);
INSERT INTO db_recipes.recipe (id, title, description, date, category_id) VALUES (2, 'Vegetarian Pizza', 'A vegetarian pizza rich with vitamins.', CURRENT_TIMESTAMP, 1);

INSERT INTO db_recipes.recipe_ingredient (recipe_id, ingredient_id) VALUES (1, 1);
INSERT INTO db_recipes.recipe_ingredient (recipe_id, ingredient_id) VALUES (1, 3);
INSERT INTO db_recipes.recipe_ingredient (recipe_id, ingredient_id) VALUES (1, 7);
INSERT INTO db_recipes.recipe_ingredient (recipe_id, ingredient_id) VALUES (1, 11);
INSERT INTO db_recipes.recipe_ingredient (recipe_id, ingredient_id) VALUES (2, 1);
INSERT INTO db_recipes.recipe_ingredient (recipe_id, ingredient_id) VALUES (2, 4);
INSERT INTO db_recipes.recipe_ingredient (recipe_id, ingredient_id) VALUES (2, 6);
INSERT INTO db_recipes.recipe_ingredient (recipe_id, ingredient_id) VALUES (2, 10);
INSERT INTO db_recipes.recipe_ingredient (recipe_id, ingredient_id) VALUES (2, 12);

INSERT INTO db_recipes.recipe_tag (recipe_id, tag_id) VALUES (1, 1);
INSERT INTO db_recipes.recipe_tag (recipe_id, tag_id) VALUES (1, 3);
INSERT INTO db_recipes.recipe_tag (recipe_id, tag_id) VALUES (2, 1);
INSERT INTO db_recipes.recipe_tag (recipe_id, tag_id) VALUES (2, 4);
INSERT INTO db_recipes.recipe_tag (recipe_id, tag_id) VALUES (2, 5);