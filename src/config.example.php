<?php
/**
 * Doorman config
 */
return [
    [
        /* The name of the endpoint, used as a label */
        'name' => 'Example Endpoint Name',
        /* The actual url you'd like to guard */
        'url' => 'https://jsonplaceholder.typicode.com/posts',
        /* The amount of seconds the cache is valid for */
        'cacheSeconds' => 43200,
        /* The slug is the unique identifier for each url, it will be used to generate the new url */
        'slug' => 'endpoint-slug'
    ],
];
