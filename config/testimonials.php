<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Testimonials Configuration
    |--------------------------------------------------------------------------
    |
    | Hardcoded testimonials dataset for the Gym Management System.
    | Can be migrated to a database table in future phases if dynamic CRUD is needed.
    |
    */

    'items' => [
        [
            'id' => 1,
            'name' => 'Sarah Jenkins',
            'role' => 'Member - Downtown Flagship',
            'branch' => 'Downtown Flagship',
            'quote' => 'Joining this gym transformed my fitness routine. The trainers are knowledgeable, motivating, and the facilities are always spotless.',
            'rating' => 5,
            'image' => 'testimonials/sarah.jpg',
        ],
        [
            'id' => 2,
            'name' => 'Ahmed Hassan',
            'role' => 'Member - Seaside Arena',
            'branch' => 'Seaside Arena',
            'quote' => 'The CrossFit classes with Marcus are intense and rewarding. The community here pushes you to be your best self every single day.',
            'rating' => 5,
            'image' => 'testimonials/ahmed.jpg',
        ],
        [
            'id' => 3,
            'name' => 'Layla Mahmoud',
            'role' => 'Member - Oasis Club',
            'branch' => 'Oasis Club',
            'quote' => 'Love the Zumba sessions with Elena! It never feels like a workout, just pure energy and fun. Highly recommend the 6-month plan!',
            'rating' => 5,
            'image' => 'testimonials/layla.jpg',
        ],
    ],
];
