<?php

/*
|--------------------------------------------------------------------------
| Tutorial catalogue
|--------------------------------------------------------------------------
|
| content_path is relative to resources/.
| Keep the index_route and show_route values identical to the existing
| named routes in routes/web.php.
|
*/

return [
    'catalog' => [
        'agenticai' => [
            'title' => 'Agentic AI',
            'category' => 'AI & Emerging Technologies',
            'content_path' => 'views/content/tutorials/agenticai',
            'index_route' => 'tutorial.agenticai.index',
            'show_route' => 'tutorial.agenticai.show',
        ],
        'linuxadmin' => [
            'title' => 'Linux Administration',
            'category' => 'Quality & Security',
            'content_path' => 'views/content/tutorials/linuxadmin',
            'index_route' => 'tutorial.linuxadmin.index',
            'show_route' => 'tutorial.linuxadmin.show',
        ],
        'cybersecurity' => [
            'title' => 'Cybersecurity & Practices',
            'category' => 'Quality & Security',
            'content_path' => 'views/content/tutorials/cybersecurity',
            'index_route' => 'tutorial.cybersecurity.index',
            'show_route' => 'tutorial.cybersecurity.show',
        ],
        'linuxadmin' => [
            'title' => 'Linux Administration',
            'category' => 'Quality & Security',
            'content_path' => 'views/content/tutorials/linuxadmin',
            'index_route' => 'tutorial.linuxadmin.index',
            'show_route' => 'tutorial.linuxadmin.show',
        ],
        'githubjira' => [
            'title' => 'GitHub & Jira',
            'category' => 'Industrial Learning Labs',
            'content_path' => 'views/content/tutorials/githubjira',
            'index_route' => 'tutorial.githubjira.index',
            'show_route' => 'tutorial.githubjira.show',
        ],
        'javafundamentals' => [
            'title' => 'Java Fundamentals',
            'category' => 'Application Development',
            'content_path' => 'views/content/tutorials/javafundamentals',
            'index_route' => 'tutorial.javafundamentals.index',
            'show_route' => 'tutorial.javafundamentals.show',
        ],
        'reactnative' => [
            'title' => 'React Native & Expo',
            'category' => 'Application Development',
            'content_path' => 'views/content/tutorials/reactnative',
            'index_route' => 'tutorial.reactnative.index',
            'show_route' => 'tutorial.reactnative.show',
        ],
        'gcpdatamodeling' => [
            'title' => 'Data Modeling',
            'category' => 'Data & Cloud Engineering',
            'content_path' => 'views/content/tutorials/gcpdatamodeling',
            'index_route' => 'tutorial.gcpdatamodeling.index',
            'show_route' => 'tutorial.gcpdatamodeling.show',
        ],
        'selenium' => [
            'title' => 'Selenium Test Automation',
            'category' => 'Quality & Security',
            'content_path' => 'views/content/tutorials/selenium',
            'index_route' => 'tutorial.selenium.index',
            'show_route' => 'tutorial.selenium.show',
        ],
        'springboot' => [
            'title' => 'Spring Boot',
            'category' => 'Application Development',
            'content_path' => 'views/content/tutorials/springboot',
            'index_route' => 'tutorial.springboot.index',
            'show_route' => 'tutorial.springboot.show',
        ],
        'dotnetfundamental' => [
            'title' => '.NET Fundamentals',
            'category' => 'Application Development',
            'content_path' => 'views/content/tutorials/dotnet/fundamental',
            'index_route' => 'tutorial.dotnet.fundamental.index',
            'show_route' => 'tutorial.dotnet.fundamental.show',
        ],
        'dotnetcore' => [
            'title' => '.NET Core & Web Development',
            'category' => 'Application Development',
            'content_path' => 'views/content/tutorials/dotnet/core',
            'index_route' => 'tutorial.dotnet.core.index',
            'show_route' => 'tutorial.dotnet.core.show',
        ],
        'dotnetdatabase' => [
            'title' => 'Database & Data Access',
            'category' => 'Data & Cloud Engineering',
            'content_path' => 'views/content/tutorials/dotnet/database',
            'index_route' => 'tutorial.dotnet.database.index',
            'show_route' => 'tutorial.dotnet.database.show',
        ],
        'dotnetfrontend' => [
            'title' => 'Frontend Development',
            'category' => 'Application Development',
            'content_path' => 'views/content/tutorials/dotnet/frontend',
            'index_route' => 'tutorial.dotnet.frontend.index',
            'show_route' => 'tutorial.dotnet.frontend.show',
        ],
    ],
];
