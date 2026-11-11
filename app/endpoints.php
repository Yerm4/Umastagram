<?php

$apiEndpoints = [
    "POST" => [
        "api/auth/login"    => "AuthController@login",
        "api/users"         => "AuthController@signup",
        "api/posts"         => "AuthController@createPost",
        "api/posts/likes"   => "AuthController@toggleLike",
        "api/comment"       => "AuthController@createComment",
        "api/friend"        => "AuthController@sendFriendRequest"
    ],
    "GET" => [
        "api/posts"         => "AuthController@getAllPosts",
        "api/users/{username}"    => "AuthController@getUser"
    ],
    "PUT" => [
        
    ],
    "PATCH" => [
        
    ],
    "DELETE" => [
        
    ]
];

return $apiEndpoints;