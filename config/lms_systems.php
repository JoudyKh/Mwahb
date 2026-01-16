<?php

return [
    'mawahb' => [
        'features' => [
            'login' => [
                'enabled' => true,
                //to use it later for security .
                'login_attempts_limit' => 5,
                'password_complexity' => 'high',
                'lockout_duration' => 15,
                'login_fields' => ['username'],
                'require_password' => true,
            ],
            'register' => [
                'enabled' => true,
                'require_email_verification' => true,
                'default_role' => 'student',
            ],
            'reset_password' => [
                'enabled' => true,
                'token_expiration' => 60, // in minutes
            ],

            'profile_management' => [
                'enabled' => true,
                'allowed_profile_fields' => ['name', 'email', 'phone'],
            ],

            'sections' => [
                'enabled' => true,
                'max_depth' => 1,
                'layers' => [
                    'super' => [
                        //todo make the validation and sql schema from here .
                        'attributes' => [
                            'name' => ['data_type' => 'string'],
                            'image' => ['data_type' => 'string'],
                        ],
                        //- means this will only be loaded in the get by id api
                        //* means this will only be loaded in the get all api
                        //you can put - and * together
                        'with' => [
                            'relations' => [
                                'common' => [
                                    //this for the eager loading to get the total lessons time
                                    '-children.lessons',
                                    //? mean that only will be load on demand from the request .
                                    '-subSections?',
                                    '*subSections.lessons',



                                ],
                                'admin' => [
                                ],
                                'student' => [

                                ]

                            ],
                            'functions' => [
                                'common' => [
                                    '-getAllSubSectionsLessonsTimes',
                                    '*scopeWithSubSectionLessonTimes'
                                ],
                                'admin' => [
                                ],
                                'student' => [
                                    //'-getStudentSubscribed',
                                ],


                            ],
                        ],
                        'order_by' => [
                            'sections.created_at' => 'asc',
                        ],
                        'children' => [

                        ]
                    ],
                    'courses' => [
                        //todo make the validation and sql schema from here .
                        'attributes' => [
                            'name' => ['data_type' => 'string'],
                            'image' => ['data_type' => 'string'],
                            //todo complete them
                        ],
                        //- means this will only be loaded in the get by id api
                        //* means this will only be loaded in the get all api
                        //you can put - and * together
                        'with' => [
                            'relations' => [
                                'common' => [
                                    //this for the eager loading to get the total lessons time
                                    '-teachers',
                                    //? mean that only will be load on demand from the request .
                                    '-subSections?',
                                    //check if the exams needed in getAll mode
                                    '*-exams',

                                ],
                                'admin' => [
                                ],
                                'student' => [
                                    '*sectionStudents',
                                    '-lessons?subscribed=1',
                                    '-freeLessons?subscribed=0',
                                    '-paidLessons?subscribed=0',
                                ]
                            ],
                            'functions' => [
                                'common' => [
                                    '-getAllSubSectionsLessonsTimes',
                                    '*scopeWithSubSectionLessonTimes',
                                ],
                                'admin' => [
                                ],
                                'student' => [
                                    //'-*getStudentSubscribed',
                                ],


                            ],
                        ],
                        'order_by' => [
                            'sections.created_at' => 'asc',
                        ],
                        'children' => [
                            'lessons' => [
                                'max' => null,
                                'order_by' => 'asc',
                                'with' => ['total_time'],
                            ],
                            'students' => [
                                'max' => null,
                                'order_by' => 'asc',
                                'with' => [],
                            ],
                            'teachers' => [
                                'max' => 0,
                                'order_by' => 'asc',
                                'with' => [],
                            ],
                        ]
                    ],
                    'book_section' => [
                        //todo make the validation and sql schema from here .
                        'attributes' => [
                            'name' => ['data_type' => 'string'],
                            'image' => ['data_type' => 'string'],
                            //todo complete them
                        ],
                        //- means this will only be loaded in the get by id api
                        //* means this will only be loaded in the get all api
                        //you can put - and * together
                        'with' => [
                            'relations' => [
                                'common' => [
                                    //this for the eager loading to get the total lessons time
                                    // '-books',
                                ],
                                'admin' => [
                                ],
                                'student' => [
                                ]

                            ],
                            'functions' => [
                                'common' => [
                                ],
                                'admin' => [
                                ],
                                'student' => [
                                ],


                            ],
                        ],
                        'order_by' => [
                            'sections.created_at' => 'asc',
                        ],
                        'children' => [
                            'book_sub_section' => [
                                'max' => null,
                                'order_by' => 'asc',
                                'with' => [],
                            ],
                        ]
                    ],
                    'book_sub_section' => [
                        //todo make the validation and sql schema from here .
                        'attributes' => [
                            'name' => ['data_type' => 'string'],
                            'image' => ['data_type' => 'string'],
                            //todo complete them
                        ],
                        //- means this will only be loaded in the get by id api
                        //* means this will only be loaded in the get all api
                        //you can put - and * together
                        'with' => [
                            'relations' => [
                                'common' => [
                                    //this for the eager loading to get the total lessons time
                                    '-books',
                                ],
                                'admin' => [
                                ],
                                'student' => [
                                ]

                            ],
                            'functions' => [
                                'common' => [
                                ],
                                'admin' => [
                                ],
                                'student' => [
                                ],


                            ],
                        ],
                        'order_by' => [
                            'sections.created_at' => 'asc',
                        ],
                        'children' => [
                            'books' => [
                                'max' => null,
                                'order_by' => 'asc',
                                'with' => [],
                            ],
                        ]
                    ],


                ],
            ],





            'lessons' => [
                'enabled' => true,
                'video_formats' => ['mp4', 'mov'],
                'max_video_size' => 1024,
                'allow_comments' => true,
            ],
            'books' => [
                'enabled' => true,
                'file_types' => ['pdf', 'epub'],
                'max_file_size' => 50,
            ],


            'contact_messages' => [
                'enabled' => true,
                'email_notifications' => true,
                //todo add this
                'notification_email' => 'support@mawahb.com',
            ],


            'offers' => [
                'enabled' => true,
            ],


            'top_students' => [
                'enabled' => true,
                'display_limit' => 10,
            ],


            'certificate_requests' => [
                'enabled' => true,
                'approval_required' => true,
            ],
            'sliders' => [
                'enabled' => true,
                'max_slides' => 5,
                'allowed_image_formats' => ['jpg', 'png'],
                'slide_duration' => 5,
            ],

            'teachers' => [
                'enabled' => true,
                'profile_approval_required' => true,
                'max_courses' => 10,
            ],

            'students' => [
                'enabled' => true,
                'max_enrollments' => 5,
            ],

            'admins' => [
                'enabled' => true,

            ],

            'purchase_codes' => [
                'enabled' => true,
                'code_length' => 10,
            ],

            'exams' => [
                'enabled' => true,
                'question_types' => ['multiple_choice'],
            ],
            'exam_questions' => [
                'enabled' => true,
                'max_questions_per_exam' => 50,
            ],
            'exam_question_options' => [
                'enabled' => true,
                'max_options_per_question' => 4,
            ],

            'course_teacher_assignments' => [
                'enabled' => true,
                'allow_multiple_teachers_per_course' => true,
            ],
            'infos' => [
                'enabled' => true,
                'editable_fields' => ['about_us', 'contact_us', 'privacy_policy'],
            ],
            'coupons' => [
                'enabled' => true,
                'code_length' => 8,
            ],

            'notifications' => [
                'enabled' => true,
                'channels' => ['in_app', 'firebase'],
            ],

            'home_content' => [
                'enabled' => true,
                'featured_courses_limit' => 5,
            ],
            'mobile_home_content' => [
                'enabled' => true,
                'featured_courses_limit' => 3,
            ],

            'subscription_requests' => [
                'enabled' => true,
                'approval_required' => true,
            ],


            'student_exams' => [
                'enabled' => true,
                'allow_review_after_completion' => true,
                'show_correct_answers' => false,
            ],
            'course_enrollment' => [
                'enabled' => true,
                'allow_self_enrollment' => true,
                'enrollment_approval_required' => false,
            ],
        ],
    ],
    'full_example' => [
        'features' => [
            'login' => [
                'enabled' => true,
                //to use it later for security .
                'login_attempts_limit' => 5,
                'password_complexity' => 'high',
                'lockout_duration' => 15,
                'login_fields' => ['username'],
                'require_password' => true,
            ],
            'register' => [
                'enabled' => true,
                'require_email_verification' => true,
                'default_role' => 'student',
            ],
            'reset_password' => [
                'enabled' => true,
                'token_expiration' => 60, // in minutes
            ],

            'profile_management' => [
                'enabled' => true,
                'allowed_profile_fields' => ['name', 'email', 'phone'],
            ],

            'sections' => [
                'enabled' => true,
                'max_depth' => 1,
                'layers' => [
                    'super' => [
                        //todo make the validation and sql schema from here .
                        'attributes' => [
                            'name' => ['data_type' => 'string'],
                            'image' => ['data_type' => 'string'],
                        ],
                        //- means this will only be loaded in the get by id api
                        //* means this will only be loaded in the get all api
                        //you can put - and * together
                        'with' => [
                            'relations' => [
                                'common' => [
                                    //this for the eager loading to get the total lessons time
                                    '-children.lessons',
                                    //? mean that only will be load on demand from the request .
                                    '-subSections?',


                                ],
                                'admin' => [
                                ],
                                'student' => [
                                    //relation?param=1&other_param=0 this means the relation will only be load on the same param name value exists in the model instance .
                                    '-lessons?subscribed=1',
                                    '-freeLessons?subscribed=0',
                                    '-paidLessons?subscribed=0',
                                ]

                            ],
                            'functions' => [
                                'common' => [
                                    '-getAllSubSectionsLessonsTimes',
                                ],
                                'admin' => [
                                ],
                                'student' => [
                                    '-getStudentSubscribed',
                                ],


                            ],
                        ],
                        'children' => [

                        ]
                    ],
                    'courses' => [
                        //todo make the validation and sql schema from here .
                        'attributes' => [
                            'name' => ['data_type' => 'string'],
                            'image' => ['data_type' => 'string'],
                            //todo complete them
                        ],
                        //- means this will only be loaded in the get by id api
                        //* means this will only be loaded in the get all api
                        //you can put - and * together
                        'with' => [
                            'relations' => [
                                'common' => [
                                    //this for the eager loading to get the total lessons time
                                    '-teachers',
                                    //? mean that only will be load on demand from the request .
                                    '-subSections?',
                                ],
                                'admin' => [
                                ],
                                'student' => [
                                    'sectionStudents'
                                ]

                            ],
                            'functions' => [
                                'common' => [
                                    '-getAllSubSectionsLessonsTimes',
                                ],
                                'admin' => [
                                ],
                                'student' => [
                                    '-*getStudentSubscribed',
                                ],


                            ],
                        ],
                        'children' => [
                            'students' => [
                                'max' => null,
                                'order_by' => 'asc',
                                'with' => [],
                            ],
                            'teachers' => [
                                'max' => 0,
                                'order_by' => 'asc',
                                'with' => [],
                            ],
                        ]
                    ],
                    'course_sections' => [
                        //todo make the validation and sql schema from here .
                        'attributes' => [
                            'name' => ['data_type' => 'string'],
                            'image' => ['data_type' => 'string'],
                            //todo complete them
                        ],
                        //- means this will only be loaded in the get by id api
                        //* means this will only be loaded in the get all api
                        //you can put - and * together
                        'with' => [
                            'relations' => [
                                'common' => [
                                    //this for the eager loading to get the total lessons time
                                    '-lessons',
                                ],
                                'admin' => [
                                ],
                                'student' => [
                                ]

                            ],
                            'functions' => [
                                'common' => [
                                    '-getAllSubSectionsLessonsTimes',
                                ],
                                'admin' => [
                                ],
                                'student' => [
                                    '-*getStudentSubscribed',
                                ],


                            ],
                        ],
                        'children' => [
                            'lessons' => [
                                'max' => null,
                                'order_by' => 'asc',
                                'with' => ['total_time'],
                            ],
                            'students' => [
                                'max' => null,
                                'order_by' => 'asc',
                                'with' => [],
                            ],
                        ]
                    ],
                    'book_sub_section' => [
                        //todo make the validation and sql schema from here .
                        'attributes' => [
                            'name' => ['data_type' => 'string'],
                            'image' => ['data_type' => 'string'],
                            //todo complete them
                        ],
                        //- means this will only be loaded in the get by id api
                        //* means this will only be loaded in the get all api
                        //you can put - and * together
                        'with' => [
                            'relations' => [
                                'common' => [
                                    //this for the eager loading to get the total lessons time
                                    '-books',
                                ],
                                'admin' => [
                                ],
                                'student' => [
                                ]

                            ],
                            'functions' => [
                                'common' => [
                                ],
                                'admin' => [
                                ],
                                'student' => [
                                ],


                            ],
                        ],
                        'children' => [
                            'books' => [
                                'max' => null,
                                'order_by' => 'asc',
                                'with' => [],
                            ],
                        ]
                    ],

                ],
            ],





            'lessons' => [
                'enabled' => true,
                'video_formats' => ['mp4', 'mov'],
                'max_video_size' => 1024,
                'allow_comments' => true,
            ],
            'books' => [
                'enabled' => true,
                'file_types' => ['pdf', 'epub'],
                'max_file_size' => 50,
            ],


            'contact_messages' => [
                'enabled' => true,
                'email_notifications' => true,
                //todo add this
                'notification_email' => 'support@mawahb.com',
            ],


            'offers' => [
                'enabled' => true,
            ],


            'top_students' => [
                'enabled' => true,
                'display_limit' => 10,
            ],


            'certificate_requests' => [
                'enabled' => true,
                'approval_required' => true,
            ],
            'sliders' => [
                'enabled' => true,
                'max_slides' => 5,
                'allowed_image_formats' => ['jpg', 'png'],
                'slide_duration' => 5,
            ],

            'teachers' => [
                'enabled' => true,
                'profile_approval_required' => true,
                'max_courses' => 10,
            ],

            'students' => [
                'enabled' => true,
                'max_enrollments' => 5,
            ],

            'admins' => [
                'enabled' => true,

            ],

            'purchase_codes' => [
                'enabled' => true,
                'code_length' => 10,
            ],

            'exams' => [
                'enabled' => true,
                'question_types' => ['multiple_choice'],
            ],
            'exam_questions' => [
                'enabled' => true,
                'max_questions_per_exam' => 50,
            ],
            'exam_question_options' => [
                'enabled' => true,
                'max_options_per_question' => 4,
            ],

            'course_teacher_assignments' => [
                'enabled' => true,
                'allow_multiple_teachers_per_course' => true,
            ],
            'infos' => [
                'enabled' => true,
                'editable_fields' => ['about_us', 'contact_us', 'privacy_policy'],
            ],
            'coupons' => [
                'enabled' => true,
                'code_length' => 8,
            ],

            'notifications' => [
                'enabled' => true,
                'channels' => ['in_app', 'firebase'],
            ],

            'home_content' => [
                'enabled' => true,
                'featured_courses_limit' => 5,
            ],
            'mobile_home_content' => [
                'enabled' => true,
                'featured_courses_limit' => 3,
            ],

            'subscription_requests' => [
                'enabled' => true,
                'approval_required' => true,
            ],


            'student_exams' => [
                'enabled' => true,
                'allow_review_after_completion' => true,
                'show_correct_answers' => false,
            ],
            'course_enrollment' => [
                'enabled' => true,
                'allow_self_enrollment' => true,
                'enrollment_approval_required' => false,
            ],
        ],
    ],
];
