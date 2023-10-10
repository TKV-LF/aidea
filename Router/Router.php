<?php
// get score
$router->get('/score/:id', 'score@detail');
// update score
$router->post('/score/update', 'score@update');

